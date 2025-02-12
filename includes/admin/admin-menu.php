<?php

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'shutter_customizer_admin_menu');

function shutter_customizer_admin_menu()
{
    add_menu_page(
        'Shutter Quotes',
        'Shutter Quotes',
        'manage_options',
        'shutter-quotes',
        'shutter_quotes_page'
    );
}

function shutter_quotes_page()
{
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/quote-list.php';
}
