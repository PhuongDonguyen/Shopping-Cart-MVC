<?php

function construct() {
    load_model('index');
}

function indexAction() {
    $id = $_GET['id'];
    $page_data = get_page_data($id);
    $data['page_data'] = $page_data;
    load_view('index', $data);
}