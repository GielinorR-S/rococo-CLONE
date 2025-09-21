<?php
// Shop UI helper: centralized sidebar rendering (Option A rebuild)
require_once __DIR__ . '/products.php';

/**
 * Render the shop sidebar with grouped collapsible categories.
 * Expansion rules: first group expanded OR group containing selected category.
 */
function render_shop_sidebar(string $location, array $categories, ?int $selectedCat): void {
    // Group categories by group_name (already coalesced in retrieval)
    $grouped = [];
    foreach($categories as $cat) {
        $g = $cat['group_name'] ?? 'Other';
        if(!isset($grouped[$g])) $grouped[$g] = [];
        $grouped[$g][] = $cat;
    }

    // Canonical group order for consistent cross-location display
    $desiredOrder = [
        'Antipasti & Bread',
        'Pizza',
        'Pasta',
        'Seafood',
        'Vegetables',
        'Fried',
        'Oven Baked',
        'Mains',
        'Dolci',
        'Other'
    ];

    $ordered = [];
    foreach($desiredOrder as $gName) {
        if(isset($grouped[$gName])) { $ordered[$gName] = $grouped[$gName]; }
    }
    // Append any unforeseen groups
    foreach($grouped as $gName => $list) {
        if(!isset($ordered[$gName])) { $ordered[$gName] = $list; }
    }

    echo '<aside class="shop-sidebar" aria-label="Categories" data-location="'.htmlspecialchars($location).'">';    
    echo '<h2 class="visually-hidden">Categories</h2>';
    // All Items link
    echo '<ul class="cat-list all-list"><li><a class="'.(!$selectedCat ? 'active':'').'" href="shop.php?location='.urlencode($location).'">All Items</a></li></ul>';

    foreach($ordered as $gName => $list) {
        $containsSelected = $selectedCat && in_array($selectedCat, array_column($list,'id'));
        // Collapsed by default unless the selected category is inside this group
        $expanded = $containsSelected; 
        $groupId = 'catgrp-' . preg_replace('/[^a-z0-9]+/i','-', strtolower($gName));
        echo '<div class="cat-group" data-group>';        
        echo '<h3 class="cat-group-title">';
        echo '<button type="button" class="cat-toggle" aria-expanded="'.($expanded?'true':'false').'" aria-controls="'.$groupId.'">';
        echo '<span class="cat-toggle-label">'.htmlspecialchars($gName).'</span>';        
        echo '<span class="chevron" aria-hidden="true">▾</span>';
        echo '</button>';
        echo '</h3>';
        echo '<ul class="cat-list" id="'.$groupId.'" role="list"'.(!$expanded ? ' hidden':'').'>';
        foreach($list as $cat) {
            $active = ($selectedCat === (int)$cat['id']) ? 'active' : '';
            echo '<li><a class="'.$active.'" href="shop.php?location='.urlencode($location).'&cat='.(int)$cat['id'].'">'.htmlspecialchars($cat['name']).'</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    echo '</aside>';
}
?>