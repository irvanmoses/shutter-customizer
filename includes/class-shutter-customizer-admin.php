<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class ShutterCustomizerAdmin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_save_shutter_form_fields', array($this, 'save_shutter_form_fields'));
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Shutter Form Builder', // Page title
            'Shutter Form',         // Menu title
            'manage_options',       // Capability
            'shutter-form-builder', // Menu slug
            array($this, 'render_form_builder'), // Callback function
            'dashicons-admin-generic', // Icon
            30                       // Position
        );
    }

    public function enqueue_scripts($hook)
    {
        if ($hook === 'toplevel_page_shutter-form-builder') {
            wp_enqueue_style('shutter-form-builder-style', plugins_url('assets/css/style.css', dirname(__FILE__)));
            wp_enqueue_script('shutter-form-builder-script', plugins_url('assets/js/script.js', dirname(__FILE__)), array('jquery', 'jquery-ui-sortable'), '1.0.0', true);
            wp_localize_script('shutter-form-builder-script', 'shutterFormBuilder', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('shutter_form_builder_nonce')
            ));
        }
    }

    public function render_form_builder()
    {
?>
        <div class="wrap">
            <h1>Shutter Form Builder</h1>
            <div id="shutter-form-builder">
                <div id="form-fields">
                    <!-- Fields will be added here dynamically -->
                </div>
                <button id="add-field" class="button">Add Field</button>
                <button id="save-fields" class="button button-primary">Save Fields</button>
            </div>
        </div>
<?php
    }

    public function save_shutter_form_fields()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'shutter_form_builder_nonce')) {
            wp_send_json_error('Invalid nonce');
        }

        if (isset($_POST['fields'])) {
            update_option('shutter_form_fields', $_POST['fields']);
            wp_send_json_success('Fields saved successfully');
        } else {
            wp_send_json_error('No fields to save');
        }
    }
}

new ShutterCustomizerAdmin();
