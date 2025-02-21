<?php

/**
 * Plugin Name: Shutter Customizer
 * Description: Custom form for shutter customization and options
 * Version: 1.0.0
 * Author: Framewrks
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Autoload class
require_once plugin_dir_path(__FILE__) . 'includes/class-shutter-customizer.php';

// Plugin initiation
add_action('plugins_loaded', array('ShutterCustomizer', 'get_instance'));

register_activation_hook(__FILE__, array('ShutterCustomizer', 'plugin_activate'));
