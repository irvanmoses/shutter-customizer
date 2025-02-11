<div class="shutter-customizer-form">
    <h4 class="shutter-customizer-form-title">Customize Your Shutter</h4>

    <div class="measurement-section">
        <div class="form-row">
            <label for="window_name">Window Name</label>
            <input type="text" id="window_name" name="window_name" placeholder="Enter window name" required>
        </div>

        <div class="form-row">
            <label for="shutter_width">Width (mm)</label>
            <input type="number"
                id="shutter_width"
                name="shutter_width"
                placeholder="Width from 250mm"
                required
                min="250"
                max="4800"
                step="1">
            <div class="invalid-feedback">
                Width must be between 250-4800.
            </div>
        </div>

        <div class="form-row">
            <label for="shutter_height">Height (mm)</label>
            <input type="number"
                id="shutter_height"
                name="shutter_height"
                placeholder="Height from 400mm"
                required
                min="400"
                max="4800"
                step="1">
            <div class="invalid-feedback">
                Height must be between 400-4800.
            </div>
        </div>


        <div class="form-row">
            <label>Total Area (m²)</label>
            <div class="total-area-container">
                <span id="total_area">0.00</span>
            </div>
        </div>

        <div class="form-row">
            <label for="calculated_price">Price</label>
            <div class="calculated-price-container">
                <span id="calculated_price">$0.00</span>
            </div>
        </div>
    </div>

    <h4 class="frame-title">Choose Your Frame Type</h4>
    <div class="frame-options">
        <div class="frame-option" data-value="standard">
            <img src="https://www.shutterwise.com.au/wp-content/uploads/2022/08/DIY-PVC-Shutter-Fit-Recess-L-Frame.jpg" alt="Standard Frame">
            <span>Standard Frame</span>

        </div>
        <div class="frame-option" data-value="premium">
            <img src="https://www.shutterwise.com.au/wp-content/uploads/2022/08/DIY-PVC-Shutter-Fit-Recess-Z-Frame.jpg" alt="Premium Frame">
            <span>Premium Frame (+$50)</span>
        </div>
    </div>
    <input type="hidden" id="frame_type" name="frame_type" value="" required>

    <h4 class="color-title">Color Options</h4>
    <div class="color-options">
        <?php

        $colors = array(
            'white' => array('color' => '#f7f8fa', 'label' => 'White'),
            'beige' => array('color' => '#FFF0DB', 'label' => 'Beige'),
            'brown' => array('color' => '#8C6F4F', 'label' => 'Brown'),
        );

        foreach ($colors as $value => $color) : ?>
            <div class="color-option" data-value="<?php echo esc_attr($value); ?>">
                <div class="color-option-preview" style="background-color: <?php echo esc_attr($color['color']); ?>;"></div>
                <span><?php echo esc_html($color['label']); ?></span>
            </div>


        <?php endforeach; ?>
        <input type="hidden" id="shutter_color" name="shutter_color" value="" required>
    </div>

</div>
