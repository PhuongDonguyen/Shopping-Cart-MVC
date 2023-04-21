<?php

function construct() {
    load_model('index');
}

function indexAction() {
    load('helper', 'format');
    $macbook_cat_info = get_cat_info(2);
    $phone_cat_info = get_cat_info(1);
    $macbook_product_list = get_list_product_by_cat(2);
    $phone_product_list = get_list_product_by_cat(1);

    $data['macbook_cat_info'] = $macbook_cat_info;
    $data['phone_cat_info'] = $phone_cat_info;
    $data['macbook_product_list'] = $macbook_product_list;
    $data['phone_product_list'] = $phone_product_list;
    load_view('index', $data);
}

