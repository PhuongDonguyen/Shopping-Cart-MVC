<?php

function get_page_data($page_id) {
    return db_fetch_row("SELECT * FROM `pages` WHERE `id` = $page_id");
}