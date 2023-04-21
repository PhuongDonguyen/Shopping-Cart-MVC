<?php

function construct() {
    load('helper', 'format');
    load_model('index');
}

function indexAction() {
    $id = $_GET['id'];
    $cat_info = get_product_cat($id);
    $list_product = get_list_product($id);
    $data['cat_info'] = $cat_info;
    $data['list_product'] = $list_product;
    load_view('index', $data);
}

function detailAction() {
    $id = $_GET['id'];
    $product_info = get_product_by_id($id);
    $data['product_info'] = $product_info;
    load_view('detail', $data);
}