<?php

// Fungsi untuk menampilkan form quote
function shutter_customizer_quote_form()
{
    ob_start();

    // Data Frames (contoh)
    $frames = array(
        'standard' => array(
            'name' => 'Standard Frame',
            'image' => 'https://www.shutterwise.com.au/wp-content/uploads/2022/08/DIY-PVC-Shutter-Fit-Recess-L-Frame.jpg',
            'price' => 0,
        ),
        'premium' => array(
            'name' => 'Premium Frame (+$50)',
            'image' => 'https://www.shutterwise.com.au/wp-content/uploads/2022/08/DIY-PVC-Shutter-Fit-Recess-Z-Frame.jpg',
            'price' => 50,
        ),
    );

    // Data Warna (contoh)
    $colors = array(
        'white' => array('color' => '#f7f8fa', 'label' => 'White'),
        'beige' => array('color' => '#FFF0DB', 'label' => 'Beige'),
        'brown' => array('color' => '#8C6F4F', 'label' => 'Brown'),
    );

?>
    <div class="shutter-customizer-form multi-step-form">

        <div class="sidebar">
            <ul class="steps">
                <li class="step active" data-step="1">Size</li>
                <li class="step" data-step="2">Layout</li>
                <li class="step" data-step="3">Recess</li>
                <li class="step" data-step="4">Sill & Architrave</li>
                <li class="step" data-step="5">Color</li>
                <li class="step" data-step="6">Configurations</li>
            </ul>
        </div>

        <form id="shutter-quote-form" method="post">

            <!-- Step 1: Size -->
            <div class="form-step active" data-step="1">
                <h2 class="step-title">Size</h2>
                <div class="form-row">
                    <label for="quote_window_name">Window Name:</label>
                    <input type="text" id="quote_window_name" name="quote_window_name" placeholder="ex. Living Room">
                </div>

                <div class="form-row">
                    <label for="quote_width">Width (mm):</label>
                    <input type="number" id="quote_width" name="quote_width" placeholder="Width from 250mm" min="250" required>
                </div>

                <div class="form-row">
                    <label for="quote_height">Height (mm):</label>
                    <input type="number" id="quote_height" name="quote_height" placeholder="Height from 400mm" min="400" required>
                </div>

                <div class="form-row">
                    <label for="quote_total_area">Total Area (m²):</label>
                    <input type="text" id="quote_total_area" name="quote_total_area" value="0.00" readonly>
                </div>

                <div class="form-row">
                    <label for="quote_price">Price:</label>
                    <input type="text" id="quote_price" name="quote_price" value="$0.00" readonly>
                </div>

                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 2: Layout -->
            <div class="form-step" data-step="2">
                <h2 class="step-title">Layout</h2>
                <div class="form-row">
                    <h3>How many panes does your window have?</h3>
                    <div class="pane-options">
                        <label class="pane-option">
                            <input type="radio" name="quote_panes" value="1" required>
                            <span>1</span>
                        </label>
                        <label class="pane-option">
                            <input type="radio" name="quote_panes" value="2" required>
                            <span>2</span>
                        </label>
                        <label class="pane-option">
                            <input type="radio" name="quote_panes" value="3" required>
                            <span>3</span>
                        </label>
                        <label class="pane-option">
                            <input type="radio" name="quote_panes" value="4" required>
                            <span>4</span>
                        </label>
                        <label class="pane-option">
                            <input type="radio" name="quote_panes" value="5" required>
                            <span>+</span>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <h3>What is the layout of your window?</h3>
                    <div class="layout-options">
                        <label class="layout-option">
                            <input type="radio" name="quote_layout" value="layout1" required>
                            <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/layout1.png'; ?>" alt="Layout 1">
                        </label>
                        <label class="layout-option">
                            <input type="radio" name="quote_layout" value="layout2" required>
                            <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/layout2.png'; ?>" alt="Layout 2">
                        </label>
                        <label class="layout-option">
                            <input type="radio" name="quote_layout" value="upload" required>
                            <span>Can't see your layout here? Upload a photo for photo to confirm.</span>
                        </label>
                    </div>
                </div>

                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 3: Recess -->
            <div class="form-step" data-step="3">
                <h2 class="step-title">Recess</h2>
                <div class="form-row">
                    <h3>Does your window have a recess?</h3>
                    <div class="recess-options">
                        <label class="recess-option">
                            <input type="radio" name="quote_recess" value="yes" required>
                            <span>YES</span>
                        </label>
                        <label class="recess-option">
                            <input type="radio" name="quote_recess" value="no" required>
                            <span>NO</span>
                        </label>
                    </div>
                </div>

                <div class="form-row conditional-recess-depth" style="display: none;">
                    <h3>Is the recess at least 70mm deep?</h3>
                    <div class="recess-depth-options">
                        <label class="recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="yes">
                            <span>Yes</span>
                        </label>
                        <label class="recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="no">
                            <span>No</span>
                        </label>
                        <label class="recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="idk">
                            <span>I don't know</span>
                        </label>
                    </div>
                    <p>Measure to the shallowest point considering obstacles like window winders and handles or inward opening windows.</p>
                </div>

                <div class="form-row">
                    <button type="button" class="info-button">WHAT IS A RECESS?</button>
                    <button type="button" class="idk-button">I DON'T KNOW</button>
                </div>

                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 4: Sill & Architrave -->
            <div class="form-step" data-step="4">
                <h2 class="step-title">Sill & Architrave</h2>
                <p>Coming soon!</p>
                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 5: Color -->
            <div class="form-step" data-step="5">
                <h2 class="step-title">Color</h2>
                <div class="form-section">
                    <h3>Color Options</h3>
                    <div class="color-options">
                        <?php foreach ($colors as $value => $color) : ?>
                            <label class="color-option">
                                <input type="radio" name="quote_color" value="<?php echo esc_attr($color['label']); ?>" required>
                                <span class="color-box" style="background-color: <?php echo esc_attr($color['color']); ?>; width:80px; height:80px; display:block;"></span>
                                <span><?php echo esc_html($color['label']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button type="button" class="prev-step">Previous</button>
                <button type="button" class="next-step">Next</button>
            </div>

            <!-- Step 6: Configurations -->
            <div class="form-step" data-step="6">
                <h2 class="step-title">Configurations</h2>
                <div class="form-section">
                    <h3>Choose Your Frame Type</h3>
                    <div class="frame-options">
                        <?php foreach ($frames as $frame_key => $frame) : ?>
                            <label class="frame-option">
                                <input type="radio" name="quote_frame" value="<?php echo esc_attr($frame_key); ?>" data-price="<?php echo esc_attr($frame['price']); ?>" required>
                                <img src="<?php echo esc_url($frame['image']); ?>" alt="<?php echo esc_attr($frame['name']); ?>">
                                <span><?php echo esc_html($frame['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="button" class="prev-step">Previous</button>
                <input type="hidden" name="action" value="calculate_shutter_quote">
                <input type="submit" value="Dapatkan Quote">
            </div>

        </form>
    </div>
<?php

    return ob_get_clean();
}

// Fungsi untuk memproses form quote
function process_shutter_customizer_quote_form()
{
    if (isset($_POST['action']) && $_POST['action'] == 'calculate_shutter_quote') {
        global $wpdb;
        $table_name = $wpdb->prefix . 'shutter_quotes';

        // Ambil data dari form
        $user_id     = get_current_user_id();
        $window_name = sanitize_text_field($_POST['quote_window_name']);
        $width       = intval($_POST['quote_width']);
        $height      = intval($_POST['quote_height']);
        $frame       = sanitize_text_field($_POST['quote_frame']);
        $color       = sanitize_text_field($_POST['quote_color']);
        $layout      = sanitize_text_field($_POST['quote_layout']);
        $recess      = sanitize_text_field($_POST['quote_recess']);

        // Kalkulasi Harga (ganti dengan logika Anda)
        $area = ($width * $height) / 1000000;
        $price_per_sqm = 100;
        $frame_price = 0; // Ambil dari data frame
        $total_price = ($area * $price_per_sqm) + $frame_price;

        // Masukkan data ke database
        $wpdb->insert(
            $table_name,
            array(
                'user_id'     => $user_id,
                'window_name' => $window_name,
                'width'       => $width,
                'height'      => $height,
                'frame'       => $frame,
                'color'       => $color,
                'layout'      => $layout,
                'recess'      => $recess,
                'total_price' => $total_price,
            ),
            array(
                '%d',   // user_id
                '%s',   // window_name
                '%d',   // width
                '%d',   // height
                '%s',   // frame
                '%s',   // color
                '%s',   // layout
                '%s',   // recess
                '%f'    // total_price
            )
        );

        $quote_id = $wpdb->insert_id; // ID quote yang baru dibuat

        echo '<p>Thank You! Quote has been saved with ID: ' . $quote_id . '</p>'; // Ganti dengan redirect
    }
}

// Register shortcode
add_shortcode('shutter_quote_form', 'shutter_customizer_quote_form');

// Add action
add_action('init', 'process_shutter_customizer_quote_form');
