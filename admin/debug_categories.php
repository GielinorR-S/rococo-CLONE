<?php
require __DIR__ . '/../includes/config.php';
$c = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$c){ die('DB connect fail'); }
$sql = "SELECT location_slug, COALESCE(group_name,name) g, name FROM product_categories ORDER BY location_slug, g, name";
$r = $c->query($sql);
$map = [];
while($row = $r->fetch_assoc()) {
  $map[$row['location_slug']][$row['g']][] = $row['name'];
}
header('Content-Type: text/plain');
foreach($map as $loc => $groups){
  echo "== $loc ==\n";
  foreach($groups as $g => $names){
    echo "  [$g] " . implode(', ', $names) . "\n";
  }
  echo "\n";
}
?>