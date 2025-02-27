<?php

if (! defined('ABSPATH')) {
    exit;
}

class ShutterCustomizer
{
    /**
     * Instance of this class.
     *
     * @var object
     */
    protected static $instance = null;

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    private function __construct()
    {
        // Load admin menu
        require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';

        // Load product form
        require_once plugin_dir_path(__FILE__) . 'product-form.php';

        // Load quote form
        require_once plugin_dir_path(__FILE__) . 'quote-form.php';

        // Action to load scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Return an instance of this class.
     *
     * @return object A single instance of this class.
     */
    public static function get_instance()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function enqueue_scripts()
    {
        if (is_product()) {
            wp_enqueue_style(
                'shutter-customizer-style',
                plugins_url('../assets/css/style.css', __FILE__)
            );

            // Properly get the product object
            global $post;
            $product = wc_get_product($post->ID);

            // Only proceed if we have a valid product
            if ($product) {
                wp_enqueue_script(
                    'shutter-customizer-script',
                    plugins_url('../assets/js/script.js', __FILE__),
                    array('jquery'),
                    '1.0.0',
                    true
                );

                // Pass the product price to JavaScript
                wp_localize_script('shutter-customizer-script', 'shutterData', array(
                    'price_per_sqm' => $product->get_regular_price(),
                    'is_on_sale' => $product->is_on_sale(),
                    'sale_price' => $product->get_sale_price(),
                ));
            }
        }

        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'shutter_quote_form')) {
            // Enqueue Style
            wp_enqueue_style('shutter-quote-form-style', plugin_dir_url(__FILE__) . '../assets/css/output.css');

            // Enqueue Script
            wp_enqueue_script('shutter-quote-script', plugin_dir_url(__FILE__) . '../assets/js/quote-script.js', array('jquery'), null, true);

            // Pass AJAX data to JavaScript for quote form
            wp_localize_script(
                'shutter-quote-script', // Handle that must match
                'shutter_ajax_params',
                array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('shutter_nonce'),
                    'home_url' => home_url(),
                )
            );
        }
    }

    // Create table when plugin is activated
    public static function plugin_activate()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shutter_quotes';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        user_id int(11) DEFAULT NULL,
        window_name varchar(255) DEFAULT NULL,
        width int(11) DEFAULT NULL,
        height int(11) DEFAULT NULL,
        frame varchar(255) DEFAULT NULL,
        panes int(11) DEFAULT NULL,
        color varchar(255) DEFAULT NULL,
        layout varchar(255) DEFAULT NULL,
        recess varchar(255) DEFAULT NULL,
        recess_depth varchar(255) DEFAULT NULL,
        total_price decimal(10,2) DEFAULT NULL,
        status varchar(255) DEFAULT 'pending',
        date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Check if there is an error
        if (! empty($wpdb->last_error)) {
            error_log('Error creating table: ' . $wpdb->last_error);
        }
    }
}
