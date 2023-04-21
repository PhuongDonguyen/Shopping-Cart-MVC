<?php

function get_product_cat($cat_id) {
    return db_fetch_row("SELECT * FROM `product_cat` WHERE `id` = $cat_id");
}

function get_list_product($cat_id) {
    $result =  db_fetch_array(("SELECT * FROM `products` WHERE `cat_id` = $cat_id"));
    foreach($result as &$item) {
        $item['url'] = "?mod=product&controller=index&action=detail&id={$item['id']}";
    }
    return $result;
}

function get_product_by_id($product_id) {
    $result = db_fetch_row("SELECT * FROM `products` WHERE `id` = $product_id");
    $result['add_cart_url'] = "?mod=cart&controller=index&action=add&id={$result['id']}";
    return $result;
}