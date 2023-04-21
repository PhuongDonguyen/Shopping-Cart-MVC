<?php

function get_list_product_by_cat($cat_id) {
    return db_fetch_array("SELECT * FROM `products` WHERE `cat_id` = $cat_id");
}

function get_cat_info($cat_id) {
    return db_fetch_row("SELECT * FROM `product_cat` WHERE `id` = $cat_id");
}

function load_data($data) {
    foreach($data as $item) {
        db_query("INSERT INTO `products` (`id`, `code`, `product_title`, `price`, `product_desc`, `product_thumb`, `product_content`, `cat_id`)
        VALUES ('{$item['id']}', '{$item['code']}', '{$item['product_title']}', '{$item['price']}', '{$item['product_desc']}', '{$item['product_thumb']}', '{$item['product_content']}', '{$item['cat_id']}')");
    }
}


