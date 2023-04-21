<?php

function add_to_cart($product_id) {
    $item = db_fetch_row("SELECT * FROM `products` WHERE `id` = $product_id ");
    $qty = 1;
    if (isset($_SESSION['cart']) && array_key_exists($product_id, $_SESSION['cart']['buy'])) {
        $qty = $_SESSION['cart']['buy'][$product_id]['qty'] + 1;
    }
    $_SESSION['cart']['buy'][$product_id] = array(
        'id' => $product_id,
        'qty' => $qty,
        'code' => $item['code'],
        'product_title' => $item['product_title'],
        'product_thumb' => $item['product_thumb'],
        'url' => "?mod=product&controller=index&action=detail&id={$item['id']}",
        'price' => $item['price'],
        'sub_total' => $item['price'] * $qty
    );
    update_cart_info();
}

function update_cart_info() {
    $num_order = 0;
    $total = 0;
    foreach($_SESSION['cart']['buy'] as $item) {
        $num_order += $item['qty'];
        $total += $item['sub_total'];
    }
    $_SESSION['cart']['info'] = array(
        'num_order' => $num_order,
        'total' => $total
    );
}

function get_list_buy_cart() {
    if (isset($_SESSION['cart'])) {
        foreach($_SESSION['cart']['buy'] as &$item) {
            $item['delete_cart_url'] = "?mod=cart&controller=index&action=delete&id={$item['id']}";
        }
        return $_SESSION['cart']['buy'];
    } else return false;
}

function get_cart_info() {
    if (isset($_SESSION['cart']))
        return $_SESSION['cart']['info'];
    else return false;
}

function delete_cart($product_id) {
    if (!empty($product_id)) {
        unset($_SESSION['cart']['buy'][$product_id]);
        update_cart_info();
    }
    else unset($_SESSION['cart']);
}

function update_cart($qty_arr) {
    foreach($qty_arr as $id => $new_qty) {
        $_SESSION['cart']['buy'][$id]['qty'] = $new_qty;
        $_SESSION['cart']['buy'][$id]['sub_total'] = $new_qty * $_SESSION['cart']['buy'][$id]['price'];
    }
    update_cart_info();
}

function get_total_cart() {
    if (isset($_SESSION['cart'])) return $_SESSION['cart']['info']['total'];
}