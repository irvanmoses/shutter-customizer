<?php

// Function to display form quote
function shutter_customizer_quote_form()
{
    ob_start();

    // Data Frames
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

    // Data Color
    $colors = array(
        'white' => array('color' => '#f7f8fa', 'label' => 'White'),
        'beige' => array('color' => '#FFF0DB', 'label' => 'Beige'),
        'brown' => array('color' => '#8C6F4F', 'label' => 'Brown'),
    );

?>
    <div class="flex w-full text-black shutter-customizer-form multi-step-form">

        <div class="sidebar w-[260px] h-auto px-4 py-6 border-r border-gray-200">
            <div class="flex items-center gap-2 mb-4 quote-summary">
                <div class="flex items-center justify-center h-16 bg-gray-100 rounded-full min-w-16">
                    <i class="text-4xl text-gray-400 fa-solid fa-calculator"></i>
                </div>
                <div class="flex flex-col">
                    <p id="summary-window-name" class="text-base font-semibold"></p>
                    <p id="summary-price" class="text-lg font-semibold"></p>
                </div>
            </div>

            <ul class="flex flex-col gap-2 p-0 m-0 list-none steps">
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step active" data-step="1">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">01 Size</span>
                </li>
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step" data-step="2">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">02 Layout</span>
                </li>
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step" data-step="3">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">03 Recess</span>
                </li>
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step" data-step="4">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">04 Sill & Architrave</span>
                </li>
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step" data-step="5">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">05 Color</span>
                </li>
                <li class="p-3 rounded-md cursor-pointer hover:bg-[#F1EBE6] step" data-step="6">
                    <span class="hidden text-green-500 step-check"><i class="fa-solid fa-check-circle"></i></span>
                    <span class="font-semibold step-title">06 Configurations</span>
                </li>
            </ul>
        </div>

        <form id="shutter-quote-form" method="post" class="flex-1 p-6">

            <!-- Step 1: Size -->
            <div class="form-step active" data-step="1">
                <h2 class="mb-4 text-xl font-bold step-title">Size</h2>
                <div class="mb-4 form-row">
                    <label for="quote_window_name" class="block mb-2 text-sm font-semibold text-gray-700">Window Name:</label>
                    <input type="text" id="quote_window_name" name="quote_window_name" placeholder="ex. Living Room" required class="w-full p-3 leading-tight border border-gray-300 rounded appearance-none focus:outline-gray-400">
                </div>

                <div class="mb-4 form-row">
                    <label for="quote_width" class="block mb-2 text-sm font-semibold text-gray-700">Width (mm):</label>
                    <input type="number" id="quote_width" name="quote_width" placeholder="Width from 250mm" min="250" required class="w-full p-3 leading-tight border border-gray-300 rounded appearance-none focus:outline-gray-400">
                </div>

                <div class="mb-4 form-row">
                    <label for="quote_height" class="block mb-2 text-sm font-semibold text-gray-700">Height (mm):</label>
                    <input type="number" id="quote_height" name="quote_height" placeholder="Height from 400mm" min="400" required class="w-full p-3 leading-tight border border-gray-300 rounded appearance-none focus:outline-gray-400">
                </div>

                <div class="mb-4 form-row">
                    <label for="quote_total_area" class="block mb-2 text-sm font-semibold text-gray-700">Total Area (m²):</label>
                    <input type="text" id="quote_total_area" name="quote_total_area" value="0.00" readonly class="w-full p-3 leading-tight border border-gray-300 rounded appearance-none focus:outline-gray-400">
                </div>

                <div class="mb-4 form-row">
                    <label for="quote_price" class="block mb-2 text-sm font-semibold text-gray-700">Price:</label>
                    <input type="text" id="quote_price" name="quote_price" value="$0.00" readonly class="w-full p-3 leading-tight border border-gray-300 rounded appearance-none focus:outline-gray-400">
                </div>

                <button type="button" class="font-semibold w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer">Next</button>
            </div>

            <!-- Step 2: Layout -->
            <div class="hidden form-step" data-step="2">
                <h2 class="mb-4 text-xl font-bold step-title">Layout</h2>
                <div class="mb-6 form-row">
                    <h3 class="mb-3 text-xl! font-semibold">How many panes does your window have?</h3>
                    <div class="flex space-x-4 pane-options">
                        <label class="inline-flex items-center cursor-pointer pane-option">
                            <input type="radio" name="quote_panes" value="1" required class="hidden w-5 h-5 peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">1</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer pane-option">
                            <input type="radio" name="quote_panes" value="2" required class="hidden w-5 h-5 peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">2</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer pane-option">
                            <input type="radio" name="quote_panes" value="3" required class="hidden w-5 h-5 peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">3</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer pane-option">
                            <input type="radio" name="quote_panes" value="4" required class="hidden w-5 h-5 peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">4</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer pane-option">
                            <input type="radio" name="quote_panes" value="5" required class="hidden w-5 h-5 peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">5</span>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <h3 class="mb-3 text-xl! font-semibold">What is the layout of your window?</h3>
                    <div class="flex gap-4 layout-options">
                        <label class="flex items-center justify-center px-4 py-3 text-center rounded-md cursor-pointer layout-option outline outline-gray-300">
                            <input type="radio" name="quote_layout" value="layout1" required class="hidden">
                            <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/images/layout1.png'; ?>" alt="Layout 1" class="w-[180px]">
                        </label>
                        <label class="flex items-center justify-center px-4 py-3 text-center rounded-md cursor-pointer layout-option outline outline-gray-300">
                            <input type="radio" name="quote_layout" value="layout2" required class="hidden">
                            <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/images/layout2.png'; ?>" alt="Layout 2" class="w-[180px]">
                        </label>
                        <label class="flex items-center justify-center px-4 py-3 text-center rounded-md cursor-pointer layout-option outline outline-gray-300">
                            <input type="radio" name="quote_layout" value="upload" required class="hidden">
                            <span>Can't see your layout here? Upload a photo for photo to confirm.</span>
                        </label>
                    </div>
                </div>

                <button type="button" class="prev-step w-[100px] p-3 text-primary rounded-md next-step bg-transparent border border-primary hover:bg-primary/90 cursor-pointer hover:text-white mt-4!">Previous</button>
                <button type="button" class="next-step w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer mt-4!">Next</button>
            </div>

            <!-- Step 3: Recess -->
            <div class="hidden form-step" data-step="3">
                <h2 class="mb-4 text-xl font-bold step-title">Recess</h2>
                <div class="form-row">
                    <h3 class="mb-2 text-xl! font-semibold">Does your window have a recess?</h3>
                    <div class="flex gap-4 recess-options">
                        <label class="inline-flex items-center cursor-pointer recess-option">
                            <input type="radio" name="quote_recess" value="yes" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">YES</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer recess-option">
                            <input type="radio" name="quote_recess" value="no" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">NO</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer recess-option">
                            <input type="radio" name="quote_recess" value="idk" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">I DON'T KNOW</span>
                        </label>
                    </div>
                </div>

                <div class="mt-5 form-row conditional-recess-depth" style="display: none;">
                    <h3 class="mb-2 text-xl! font-semibold">Is the recess at least 70mm deep?</h3>
                    <div class="flex gap-4 recess-depth-options">
                        <label class="inline-flex items-center cursor-pointer recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="yes" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">Yes</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="no" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">No</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer recess-depth-option">
                            <input type="radio" name="quote_recess_depth" value="idk" required class="hidden peer">
                            <span class="peer-checked:font-bold peer-checked:bg-[#e0e0e0] px-5 py-3 border border-gray-300 rounded">I don't know</span>
                        </label>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 w-[360px]">Measure to the shallowest point considering obstacles like window winders and handles or inward opening windows.</p>
                </div>

                <div class="flex items-center gap-2 mt-4 form-row">
                    <div class="flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-primary"></i>
                        <a href="#" class="text-primary! font-semibold">What is a recess?</a>
                    </div>
                </div>

                <button type="button" class="prev-step w-[100px] p-3 text-primary rounded-md next-step bg-transparent border border-primary hover:bg-primary/90 cursor-pointer hover:text-white mt-4!">Previous</button>
                <button type="button" class="next-step w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer mt-4!">Next</button>
            </div>

            <!-- Step 4: Sill & Architrave -->
            <div class="hidden form-step" data-step="4">
                <h2 class="mb-4 text-xl font-bold step-title">Sill & Architrave</h2>
                <p>Coming soon!</p>
                <button type="button" class="prev-step w-[100px] p-3 text-primary rounded-md next-step bg-transparent border border-primary hover:bg-primary/90 cursor-pointer hover:text-white mt-4!">Previous</button>
                <button type="button" class="next-step w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer mt-4!">Next</button>
            </div>

            <!-- Step 5: Color -->
            <div class="hidden form-step" data-step="5">
                <h2 class="mb-4 text-xl font-bold step-title">Color</h2>
                <div class="form-section">
                    <h3 class="mb-2 text-xl! font-semibold">Choose Your Frame Color</h3>
                    <div class="flex gap-6 color-options">
                        <?php foreach ($colors as $value => $color) : ?>
                            <div class="flex flex-col items-center gap-1 cursor-pointer color-option" data-value="<?php echo esc_attr($value); ?>">
                                <div class="w-16 h-16 rounded color-option-preview outline outline-gray-300" style="background-color: <?php echo esc_attr($color['color']); ?>;"></div>
                                <span><?php echo esc_html($color['label']); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <input type="hidden" id="quote_color" name="quote_color" value="" required>
                    </div>
                </div>
                <button type="button" class="prev-step w-[100px] p-3 text-primary rounded-md next-step bg-transparent border border-primary hover:bg-primary/90 cursor-pointer hover:text-white mt-4! mr-1!">Previous</button>
                <button type="button" class="next-step w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer mt-4!">Next</button>
            </div>

            <!-- Step 6: Configurations -->
            <div class="hidden form-step" data-step="6">
                <h2 class="mb-4 text-xl font-bold step-title">Configurations</h2>
                <div class="form-section">
                    <h3 class="mb-2 text-xl! font-semibold">Choose Your Frame Type</h3>
                    <div class="flex gap-4 frame-options">
                        <?php foreach ($frames as $frame_key => $frame) : ?>
                            <label class="flex flex-col items-center gap-1 px-4 py-3 rounded-md cursor-pointer frame-option outline outline-gray-300">
                                <input type="radio" name="quote_frame" value="<?php echo esc_attr($frame_key); ?>" data-price="<?php echo esc_attr($frame['price']); ?>" required class="hidden">
                                <img src="<?php echo esc_url($frame['image']); ?>" alt="<?php echo esc_attr($frame['name']); ?>">
                                <span><?php echo esc_html($frame['name']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="button" class="prev-step w-[100px] p-3 text-primary rounded-md next-step bg-transparent border border-primary hover:bg-primary/90 cursor-pointer hover:text-white mt-4!">Previous</button>
                <input type="hidden" name="action" value="calculate_shutter_quote">
                <input type="submit" value="Get Quote" class="w-[100px] p-3 text-white rounded-md next-step bg-primary hover:bg-primary/90 cursor-pointer mt-4! ml-1!">
            </div>

        </form>
    </div>
<?php

    return ob_get_clean();
}


// Function to proceed form data (used by AJAX and non-AJAX)
function process_shutter_form_data($post_data)
{
    // Check nonce (if exist)
    if (isset($post_data['nonce']) && ! wp_verify_nonce($post_data['nonce'], 'shutter_nonce')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce.');
    }

    // Get data from form
    $window_name  = isset($post_data['quote_window_name']) ? sanitize_text_field($post_data['quote_window_name']) : '';
    $width        = isset($post_data['quote_width']) ? intval($post_data['quote_width']) : 0;
    $height       = isset($post_data['quote_height']) ? intval($post_data['quote_height']) : 0;
    $frame        = isset($post_data['quote_frame']) ? sanitize_text_field($post_data['quote_frame']) : '';
    $color        = isset($post_data['quote_color']) ? sanitize_text_field($post_data['quote_color']) : '';
    $layout       = isset($post_data['quote_layout']) ? sanitize_text_field($post_data['quote_layout']) : '';
    $recess       = isset($post_data['quote_recess']) ? sanitize_text_field($post_data['quote_recess']) : '';
    $recess_depth = isset($post_data['quote_recess_depth']) ? sanitize_text_field($post_data['quote_recess_depth']) : '';
    $panes        = isset($post_data['quote_panes']) ? sanitize_text_field($post_data['quote_panes']) : '';

    // Convert recess_depth values to more descriptive text before saving
    if ($recess === 'yes') {
        switch ($recess_depth) {
            case 'yes':
                $recess_depth_text = 'Recess is at least 70mm deep';
                break;
            case 'no':
                $recess_depth_text = 'Recess is NOT at least 70mm deep';
                break;
            case 'idk':
                $recess_depth_text = 'Recess depth is unknown';
                break;
            default:
                $recess_depth_text = 'No recess depth info';
                break;
        }
    } else {
        $recess_depth_text = 'No recess';
    }

    $data = array(
        // Existing Code
        'recess_depth' => $recess_depth_text,  // store updated text info
    );

    // Validasi Data
    $errors = array();

    // ... Another validation codes ...

    // Validate recess depth (only if recess is set to "yes")
    if ($recess === 'yes') {
        $allowed_recess_depth = array('yes', 'no', 'idk');
        if (!in_array($recess_depth, $allowed_recess_depth)) {
            $errors[] = 'Invalid recess depth selected.';
        }
    }

    // Validate panes
    $allowed_panes = array('1', '2', '3', '4', '5');
    if (!in_array($panes, $allowed_panes)) {
        $errors[] = 'Invalid number of panes selected.';
    }

    if (!empty($errors)) {
        return new WP_Error('validation_error', implode('<br>', $errors));
    }

    // Calculate price
    $area = ($width * $height) / 1000000;
    $price_per_sqm = 100;
    $frame_price = 0;
    $total_price = ($area * $price_per_sqm) + $frame_price;

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'shutter_quotes';

    $data = array(
        'user_id' => get_current_user_id(),
        'window_name' => $window_name,
        'width' => $width,
        'height' => $height,
        'frame' => $frame,
        'color' => $color,
        'layout' => $layout,
        'recess' => $recess,
        'recess_depth' => $recess_depth,
        'panes' => $panes,
        'total_price' => $total_price
    );

    $format = array(
        '%d',  // user_id
        '%s',  // window_name
        '%d',  // width
        '%d',  // height
        '%s',  // frame
        '%s',  // color
        '%s',  // layout
        '%s',  // recess
        '%s',  // recess_depth
        '%s',  // panes
        '%f'   // total_price
    );

    $wpdb->insert($table_name, $data, $format);

    if ($wpdb->last_error) {
        return new WP_Error('database_error', 'Database error: ' . $wpdb->last_error);
    }

    $quote_id = $wpdb->insert_id;

    return $quote_id;
}

// Function to proceed form quote (non-AJAX)
function process_shutter_customizer_quote_form()
{
    if (isset($_POST['action']) && $_POST['action'] == 'calculate_shutter_quote') {
        $result = process_shutter_form_data($_POST);

        if (is_wp_error($result)) {
            // Show error message
            echo '<div class="error">' . $result->get_error_message() . '</div>';
        } else {
            // Show success message
            echo '<div class="success">Quote submitted successfully! Quote ID: ' . $result . '</div>';
        }
    }
}
add_action('init', 'process_shutter_customizer_quote_form');

// Function to handle AJAX (AJAX data processing)
add_action('wp_ajax_process_shutter_form', 'process_shutter_form_callback');
add_action('wp_ajax_nopriv_process_shutter_form', 'process_shutter_form_callback');

function process_shutter_form_callback()
{
    $result = process_shutter_form_data($_POST);

    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
    } else {
        wp_send_json_success(array('message' => 'Quote submitted successfully! Quote ID: ' . $result));
    }

    wp_die();
}

add_shortcode('shutter_quote_form', 'shutter_customizer_quote_form');
