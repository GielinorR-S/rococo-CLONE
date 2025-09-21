<?php
// Product & Cart helper functions
require_once __DIR__ . '/config.php';

// ---------------------------------------------------------------
// Bootstrap: ensure product tables exist & optionally seed data
// This prevents fatal errors if database_setup.sql wasn't run.
// ---------------------------------------------------------------

function rocco_db() {
    global $conn;
    if(isset($conn) && $conn instanceof mysqli) return $conn;
    // create database if missing then connect
    $c = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if(!$c) die('DB connection failed');
    mysqli_query($c, 'CREATE DATABASE IF NOT EXISTS `'.DB_NAME.'`');
    mysqli_select_db($c, DB_NAME);
    return $c;
}

function ensure_product_tables(){
    static $done = false; if($done) return; $done = true;
    $db = rocco_db();
    // Create tables (idempotent)
    $db->query("CREATE TABLE IF NOT EXISTS product_categories (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        location_slug VARCHAR(40) NOT NULL,\n        name VARCHAR(120) NOT NULL,\n        display_order INT DEFAULT 0,\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        KEY idx_location (location_slug)\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $db->query("CREATE TABLE IF NOT EXISTS products (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        category_id INT NOT NULL,\n        name VARCHAR(160) NOT NULL,\n        description TEXT,\n        price DECIMAL(8,2) NOT NULL DEFAULT 0.00,\n        image_url VARCHAR(255),\n        is_active TINYINT(1) NOT NULL DEFAULT 1,\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        KEY idx_active (is_active),\n        CONSTRAINT fk_prod_cat FOREIGN KEY (category_id) REFERENCES product_categories(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $db->query("CREATE TABLE IF NOT EXISTS product_images (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        product_id INT NOT NULL,\n        image_url VARCHAR(255) NOT NULL,\n        display_order INT DEFAULT 0,\n        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        CONSTRAINT fk_img_prod FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Seed only if no categories yet
    $res = $db->query("SELECT COUNT(*) AS c FROM product_categories");
    if($res && ($row = $res->fetch_assoc()) && (int)$row['c'] === 0){
        $db->query("INSERT INTO product_categories (location_slug,name,display_order) VALUES\n            ('stkilda','Antipasti',1),('stkilda','Pizza',2),('stkilda','Pasta',3),\n            ('hawthorn','Pizza',1),('hawthorn','Mains',2),\n            ('pointcook','Pizza',1),('pointcook','Dessert',2)");

        // Map cat names to ids for inserts
        $cats = [];
        $r2 = $db->query("SELECT id,name,location_slug FROM product_categories");
        while($r2 && $cRow = $r2->fetch_assoc()){ $cats[$cRow['name']] = $cRow['id']; }
        $safe = function($s) use ($db){ return "'".$db->real_escape_string($s)."'"; };
        $productsValues = [];
        $seedProducts = [
            ['Antipasti','Garlic Focaccia','Wood fired garlic, rosemary & sea salt.',8.50,'https://images.unsplash.com/photo-1604908176997-125d4d978f74?auto=format&fit=crop&w=800&q=60'],
            ['Pizza','Margherita','San Marzano tomato, fior di latte, basil.',18.00,'https://images.unsplash.com/photo-1601924582971-b7eabf6d5f5d?auto=format&fit=crop&w=800&q=60'],
            ['Pizza','Diavola','Hot salami, mozzarella, chilli oil.',22.00,'https://images.unsplash.com/photo-1594007654729-407eedc4be65?auto=format&fit=crop&w=800&q=60'],
            ['Pasta','Spaghetti Carbonara','Guanciale, pecorino, egg yolk emulsion.',24.00,'https://images.unsplash.com/photo-1617196034796-73dfa7f4c9d0?auto=format&fit=crop&w=800&q=60'],
            ['Mains','Veal Parmigiana','Crumbed veal, Napoli, mozzarella, fries.',29.00,'https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=800&q=60'],
            ['Dessert','Tiramisu','Espresso soaked savoiardi, mascarpone.',12.00,'https://images.unsplash.com/photo-1606755962773-d324e0a13086?auto=format&fit=crop&w=800&q=60'],
        ];
        foreach($seedProducts as $sp){
            if(!isset($cats[$sp[0]])) continue; // category missing
            $productsValues[] = '('.(int)$cats[$sp[0]].','.$safe($sp[1]).','.$safe($sp[2]).','.number_format($sp[3],2,'.','').','.$safe($sp[4]).')';
        }
        if($productsValues){
            $db->query('INSERT INTO products (category_id,name,description,price,image_url) VALUES '.implode(',', $productsValues));
        }
    }

    // --- Migration: add group_name column if missing ---
    $colRes = $db->query("SHOW COLUMNS FROM product_categories LIKE 'group_name'");
    if($colRes && $colRes->num_rows === 0){
        $db->query("ALTER TABLE product_categories ADD COLUMN group_name VARCHAR(120) NULL AFTER name");
    }

    // Assign group_name for existing basic categories (idempotent)
    $db->query("UPDATE product_categories SET group_name='Antipasti & Bread' WHERE name IN ('Antipasti') AND (group_name IS NULL OR group_name='')");
    $db->query("UPDATE product_categories SET group_name='Pizza' WHERE name='Pizza' AND (group_name IS NULL OR group_name='')");
    $db->query("UPDATE product_categories SET group_name='Pasta' WHERE name='Pasta' AND (group_name IS NULL OR group_name='')");
    $db->query("UPDATE product_categories SET group_name='Mains' WHERE name='Mains' AND (group_name IS NULL OR group_name='')");
    $db->query("UPDATE product_categories SET group_name='Dolci' WHERE name='Dessert' AND (group_name IS NULL OR group_name='')");

    // New category definitions (we'll add for each location if missing) limited to create groups for expanded menu
    $newCats = [
        ['Antipasti & Bread','Bread',4],
        ['Seafood','Seafood',5],
        ['Vegetables','Vegetables',6],
        ['Fried','Fried',7],
        ['Oven Baked','Al Forno',8],
        ['Dolci','Dolci',20]
    ];
    $locations = ['stkilda','hawthorn','pointcook'];
    foreach($locations as $loc){
        foreach($newCats as $nc){
            list($group,$name,$ord) = $nc;
            // skip if name already exists for that location
            $stmt = $db->prepare("SELECT id FROM product_categories WHERE location_slug=? AND name=? LIMIT 1");
            $stmt->bind_param('ss',$loc,$name); $stmt->execute(); $r=$stmt->get_result();
            if(!$r->fetch_assoc()){
                $ins = $db->prepare("INSERT INTO product_categories (location_slug,name,group_name,display_order) VALUES (?,?,?,?)");
                $ins->bind_param('sssi',$loc,$name,$group,$ord); $ins->execute();
            } else {
                // ensure group_name applied if category existed earlier (e.g. Dessert -> Dolci handled above)
                $upd = $db->prepare("UPDATE product_categories SET group_name=? WHERE location_slug=? AND name=? AND (group_name IS NULL OR group_name='')");
                $upd->bind_param('sss',$group,$loc,$name); $upd->execute();
            }
        }
    }

    // Seed additional products only if they don't exist (by name + category location uniqueness)
    // We limit to St Kilda for new items to keep overall distinct count near 20.
    $stCats = [];
    $rsc = $db->query("SELECT id,name FROM product_categories WHERE location_slug='stkilda'");
    while($rsc && $rowc = $rsc->fetch_assoc()){ $stCats[$rowc['name']] = (int)$rowc['id']; }
    // Map of product definitions: [categoryName, name, description, price, image]
    $newProducts = [
        ['Antipasti','Tomato Bruschetta','Heirloom tomato, basil, cold-pressed olive oil on toasted pane rustico.',12.50,'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=800&q=60'],
        ['Fried','Arancini Porcini','Crispy risotto balls, porcini, fontina centre, truffle aioli.',15.00,'https://images.unsplash.com/photo-1551218808-94e220e084d2?auto=format&fit=crop&w=800&q=60'],
        ['Seafood','Calamari Fritti','Flash-fried local calamari, lemon, saffron aioli.',19.50,'https://images.unsplash.com/photo-1612195589085-d3c9713a0c80?auto=format&fit=crop&w=800&q=60'],
        ['Seafood','Gamberi Aglio e Olio','Garlic chilli prawns, parsley, white wine butter.',24.50,'https://images.unsplash.com/photo-1601312378427-8220a4193c8e?auto=format&fit=crop&w=800&q=60'],
        ['Seafood','Mussels Bianco','Kinkawooka mussels, garlic, fennel, white wine broth.',23.00,'https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=800&q=60'],
        ['Vegetables','Charred Broccolini','Grilled broccolini, lemon oil, toasted almonds.',13.50,'https://images.unsplash.com/photo-1604908553562-9b84a2210a7b?auto=format&fit=crop&w=800&q=60'],
        ['Vegetables','Caponata Siciliana','Sweet-sour eggplant, celery, pine nuts, capers.',14.00,'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=800&q=60'],
        ['Al Forno','Lasagne al Forno','Slow beef & pork ragu, fresh pasta layers, besciamella.',26.00,'https://images.unsplash.com/photo-1603132737379-62d3e0173c02?auto=format&fit=crop&w=800&q=60'],
        ['Pasta','Penne Arrabbiata','Tomato, garlic, Calabrian chilli, basil. (V)',21.00,'https://images.unsplash.com/photo-1523986371872-9d3ba2e2f642?auto=format&fit=crop&w=800&q=60'],
        ['Pasta','Gnocchi Sorrentina','Hand-rolled potato gnocchi, tomato, fior di latte, basil.',25.00,'https://images.unsplash.com/photo-1521389508051-d7ffb5dc8d61?auto=format&fit=crop&w=800&q=60'],
        ['Pizza','Funghi','Fior di latte, mixed mushrooms, taleggio, thyme.',22.00,'https://images.unsplash.com/photo-1601924582971-b7eabf6d5f5d?auto=format&fit=crop&w=800&q=60'],
        ['Pizza','Prosciutto e Rucola','San Marzano, fior di latte, prosciutto, rocket, grana.',24.00,'https://images.unsplash.com/photo-1542281286-9e0a16bb7366?auto=format&fit=crop&w=800&q=60'],
        ['Mains','Pollo al Limone','Free-range chicken breast, lemon butter sauce, herbs.',29.50,'https://images.unsplash.com/photo-1601312378625-b4d3cb43f7a5?auto=format&fit=crop&w=800&q=60'],
        ['Mains','Bistecca Tagliata','Sliced sirloin, rocket, aged balsamic, parmesan.',38.00,'https://images.unsplash.com/photo-1604908553775-43f6af5120a4?auto=format&fit=crop&w=800&q=60'],
        ['Dolci','Panna Cotta','Vanilla bean panna cotta, seasonal berry coulis.',12.50,'https://images.unsplash.com/photo-1514516345957-556ca7d90a5a?auto=format&fit=crop&w=800&q=60']
    ];
    foreach($newProducts as $np){
        list($catName,$name,$desc,$price,$img) = $np;
        if(!isset($stCats[$catName])) continue;
        // Check if product already exists for that category (by name)
        $chk = $db->prepare("SELECT p.id FROM products p WHERE p.category_id=? AND p.name=? LIMIT 1");
        $cid = $stCats[$catName];
        $chk->bind_param('is',$cid,$name); $chk->execute(); $cr = $chk->get_result();
        if(!$cr->fetch_assoc()){
            $ins = $db->prepare("INSERT INTO products (category_id,name,description,price,image_url) VALUES (?,?,?,?,?)");
            $ins->bind_param('issds',$cid,$name,$desc,$price,$img); $ins->execute();
        }
    }

    // For authenticity ensure each category in each location has at least one product placeholder if currently empty.
    $allCats = $db->query("SELECT c.id, c.name, c.location_slug FROM product_categories c");
    while($allCats && $cRow = $allCats->fetch_assoc()) {
        $cid = (int)$cRow['id'];
        $chk = $db->prepare("SELECT id FROM products WHERE category_id=? LIMIT 1");
        $chk->bind_param('i',$cid); $chk->execute(); $has = $chk->get_result()->fetch_assoc();
        if(!$has){
            $placeholderName = $cRow['name'] . ' Item';
            $desc = $cRow['name'] . ' signature placeholder item. Update via admin.';
            $price = 9.99;
            $img = null; // will fallback
            $ins = $db->prepare("INSERT INTO products (category_id,name,description,price,image_url) VALUES (?,?,?,?,?)");
            $ins->bind_param('issds',$cid,$placeholderName,$desc,$price,$img); $ins->execute();
        }
    }
}

// Run bootstrap on load
ensure_product_tables();

function get_shop_locations(): array {
    // Hard-coded slugs for now; could move to table later
    return [
        'stkilda' => 'St Kilda',
        'hawthorn' => 'Hawthorn',
        'pointcook' => 'Point Cook'
    ];
}

function normalize_location_slug(?string $slug): ?string {
    if(!$slug) return null;
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i','', $slug));
    $map = get_shop_locations();
    return array_key_exists($slug, $map) ? $slug : null;
}

function get_location_label(string $slug): string {
    $map = get_shop_locations();
    return $map[$slug] ?? ucfirst($slug);
}

function get_categories_for_location(string $location): array {
    $db = rocco_db();
    // Coalesce group_name to category name so grouping label always present (prevents styling issues when group_name null)
    $sql = "SELECT id, name, COALESCE(group_name,name) AS group_name, display_order FROM product_categories WHERE location_slug = ? ORDER BY COALESCE(display_order,999), name";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $location);
    $stmt->execute();
    $res = $stmt->get_result();
    $cats = [];
    while($row = $res->fetch_assoc()) { $cats[] = $row; }
    return $cats;
}

function get_products(string $location, ?int $categoryId = null): array {
    $db = rocco_db();
    $params = [$location];
    $types = 's';
    $where = 'c.location_slug = ?';
    if($categoryId !== null){
        $where .= ' AND p.category_id = ?';
        $params[] = $categoryId;
        $types .= 'i';
    }
    $sql = "SELECT p.id, p.name, p.description, p.price, p.image_url, p.category_id
            FROM products p
            JOIN product_categories c ON c.id = p.category_id
            WHERE $where AND p.is_active = 1
            ORDER BY p.name";
    $stmt = $db->prepare($sql);
        if($categoryId !== null){
            $stmt->bind_param('si', $location, $categoryId);
        } else {
            $stmt->bind_param('s', $location);
        }
    $stmt->execute();
    $res = $stmt->get_result();
    $items = [];
    while($row = $res->fetch_assoc()) { $items[] = $row; }
    return $items;
}

function get_product(int $id): ?array {
    $db = rocco_db();
    $stmt = $db->prepare("SELECT p.*, c.location_slug FROM products p JOIN product_categories c ON c.id = p.category_id WHERE p.id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_assoc() ?: null;
}

// Utility to reconcile Dessert vs Dolci naming (authentic "Dolci")
function reconcile_dessert_categories() {
    $db = rocco_db();
    // Rename any 'Dessert' category to 'Dolci' if a Dolci does not already exist for that location.
    $res = $db->query("SELECT id, location_slug FROM product_categories WHERE name='Dessert'");
    while($res && $row = $res->fetch_assoc()) {
        $loc = $row['location_slug'];
        $check = $db->prepare("SELECT id FROM product_categories WHERE location_slug=? AND name='Dolci' LIMIT 1");
        $check->bind_param('s',$loc); $check->execute(); $cr = $check->get_result();
        if(!$cr->fetch_assoc()) {
            $upd = $db->prepare("UPDATE product_categories SET name='Dolci', group_name='Dolci' WHERE id=?");
            $upd->bind_param('i',$row['id']); $upd->execute();
        } else {
            // If both exist, ensure 'Dessert' rows have group_name Dolci for grouping consistency.
            $db->query("UPDATE product_categories SET group_name='Dolci' WHERE id=".(int)$row['id']);
        }
    }
}

reconcile_dessert_categories();

// Ensure each location has the full canonical category set for consistent sidebar.
function ensure_canonical_categories() {
    $db = rocco_db();
    $locations = array_keys(get_shop_locations());
    // canonical structure: group_label => [category names]
    $structure = [
        'Antipasti & Bread' => ['Antipasti','Bread'],
        'Pizza' => ['Pizza'],
        'Pasta' => ['Pasta'],
        'Seafood' => ['Seafood'],
        'Vegetables' => ['Vegetables'],
        'Fried' => ['Fried'],
        'Oven Baked' => ['Al Forno'],
        'Mains' => ['Mains'],
        'Dolci' => ['Dolci']
    ];
    foreach($locations as $loc){
        $fetchExisting = function() use ($db,$loc){
            $stmt = $db->prepare("SELECT id,name,group_name FROM product_categories WHERE location_slug=?");
            $stmt->bind_param('s',$loc); $stmt->execute(); $res=$stmt->get_result();
            $ex = [];
            while($row=$res->fetch_assoc()) { $ex[$row['name']] = $row; }
            return $ex;
        };
        $existing = $fetchExisting();
        // Remove stray 'Dessert' duplicates (Dolci canonical)
        if(isset($existing['Dessert'])) {
            // If Dolci exists keep Dolci and delete Dessert; else rename
            if(isset($existing['Dolci'])) {
                $db->query("DELETE FROM product_categories WHERE id=".(int)$existing['Dessert']['id']);
                unset($existing['Dessert']);
            } else {
                $upd = $db->prepare("UPDATE product_categories SET name='Dolci', group_name='Dolci' WHERE id=?");
                $upd->bind_param('i',$existing['Dessert']['id']);
                $upd->execute();
                $existing['Dolci'] = $existing['Dessert'];
                unset($existing['Dessert']);
            }
        }
        $displayOrder = 1;
        foreach($structure as $groupLabel => $catNames){
            foreach($catNames as $catName){
                if(!isset($existing[$catName])){
                    $ins = $db->prepare("INSERT INTO product_categories (location_slug,name,group_name,display_order) VALUES (?,?,?,?)");
                    $ins->bind_param('sssi',$loc,$catName,$groupLabel,$displayOrder);
                    $ins->execute();
                    $existing = $fetchExisting(); // refresh after insert
                } else {
                    // ensure group label & display order correct
                    $upd = $db->prepare("UPDATE product_categories SET group_name=?, display_order=? WHERE id=? AND (group_name<>? OR display_order IS NULL)");
                    $gid = $existing[$catName]['id'];
                    $upd->bind_param('siis',$groupLabel,$displayOrder,$gid,$groupLabel);
                    $upd->execute();
                }
                $displayOrder++;
            }
        }
        // Post-pass: ensure Antipasti & Pasta exist (edge case if earlier logic skipped due to naming mismatch)
        foreach(['Antipasti'=>'Antipasti & Bread','Pasta'=>'Pasta'] as $mustName => $grp){
            if(!isset($existing[$mustName])){
                $displayOrder++;
                $ins2 = $db->prepare("INSERT INTO product_categories (location_slug,name,group_name,display_order) VALUES (?,?,?,?)");
                $ins2->bind_param('sssi',$loc,$mustName,$grp,$displayOrder);
                $ins2->execute();
            }
        }
    }
}

ensure_canonical_categories();

// Fallback hard sync: mirror St Kilda category presence (names + group_name) to other locations if still missing
function force_sync_categories() {
    $db = rocco_db();
    $baseLoc = 'stkilda';
    $base = [];
    $r = $db->prepare("SELECT name, COALESCE(group_name,name) g FROM product_categories WHERE location_slug=?");
    $r->bind_param('s',$baseLoc); $r->execute(); $res=$r->get_result();
    while($row=$res->fetch_assoc()){ $base[$row['name']] = $row['g']; }
    $targets = array_diff(array_keys(get_shop_locations()), [$baseLoc]);
    foreach($targets as $loc){
        // Remove stray 'Dessert'
        $db->query("DELETE FROM product_categories WHERE location_slug='".$db->real_escape_string($loc)."' AND name='Dessert'");
        // Load existing names
        $ex = [];
        $r2 = $db->prepare("SELECT name FROM product_categories WHERE location_slug=?");
        $r2->bind_param('s',$loc); $r2->execute(); $re2=$r2->get_result();
        while($rw=$re2->fetch_assoc()){ $ex[$rw['name']] = true; }
        $order = 1;
        foreach($base as $name => $group){
            if(!isset($ex[$name])){
                $ins = $db->prepare("INSERT INTO product_categories (location_slug,name,group_name,display_order) VALUES (?,?,?,?)");
                $ins->bind_param('sssi',$loc,$name,$group,$order);
                $ins->execute();
            } else {
                // ensure group align
                $upd = $db->prepare("UPDATE product_categories SET group_name=?, display_order=? WHERE location_slug=? AND name=?");
                $upd->bind_param('siss',$group,$order,$loc,$name);
                $upd->execute();
            }
            $order++;
        }
    }
}

force_sync_categories();

// Image fallback mapping: if a product has no image_url in DB, provide themed placeholder
function product_fallback_image(string $name): string {
    $key = strtolower($name);
    $map = [
        'garlic focaccia' => 'https://images.unsplash.com/photo-1604917173596-e30ba64b3ba7?auto=format&fit=crop&w=800&q=60',
        'margherita' => 'https://images.unsplash.com/photo-1548365328-8b6db40429ba?auto=format&fit=crop&w=800&q=60',
        'diavola' => 'https://images.unsplash.com/photo-1601924928376-3e3a122390f1?auto=format&fit=crop&w=800&q=60',
        'spaghetti carbonara' => 'https://images.unsplash.com/photo-1612927601601-e6e1311bb65c?auto=format&fit=crop&w=800&q=60',
        'veal parmigiana' => 'https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?auto=format&fit=crop&w=800&q=60',
        'tiramisu' => 'https://images.unsplash.com/photo-1601972599720-b7cd5b1a3a35?auto=format&fit=crop&w=800&q=60'
    ];
    if(isset($map[$key])) return $map[$key];
    // generic Italian food fallback
    return 'https://images.unsplash.com/photo-1529692236671-f1dc28b14e18?auto=format&fit=crop&w=800&q=60';
}

// ------------------ CART ---------------------
function cart_init() {
    if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

function cart_add(int $productId, int $qty = 1) {
    cart_init();
    if($qty < 1) $qty = 1;
    if(isset($_SESSION['cart'][$productId])) $_SESSION['cart'][$productId] += $qty; else $_SESSION['cart'][$productId] = $qty;
}

function cart_update(int $productId, int $qty) {
    cart_init();
    if($qty <= 0) { unset($_SESSION['cart'][$productId]); return; }
    $_SESSION['cart'][$productId] = $qty;
}

function cart_remove(int $productId) {
    cart_init();
    unset($_SESSION['cart'][$productId]);
}

function cart_items(): array {
    cart_init();
    $items = [];
    foreach($_SESSION['cart'] as $pid => $qty) {
        $p = get_product((int)$pid);
        if(!$p) continue; // skip stale id
        $p['quantity'] = $qty;
        $p['line_total'] = $qty * (float)$p['price'];
        $items[] = $p;
    }
    return $items;
}

function cart_totals(): array {
    $items = cart_items();
    $subtotal = 0.0;
    foreach($items as $it) { $subtotal += $it['line_total']; }
    $tax = 0.0; // placeholder (GST inclusive assumption for now)
    $total = $subtotal + $tax;
    return [ 'subtotal' => $subtotal, 'tax' => $tax, 'total' => $total ];
}

function money($v): string { return '$' . number_format((float)$v, 2); }

?>