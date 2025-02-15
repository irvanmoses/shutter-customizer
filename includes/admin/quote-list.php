<?php

/**
 *  Displays the list of shutter quotes in the admin panel.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wpdb;
$table_name = $wpdb->prefix . 'shutter_quotes';

$quotes = $wpdb->get_results("SELECT * FROM $table_name");

echo '<div class="wrap">';
echo '<h1>Shutter Quotes</h1>';
echo '<table class="wp-list-table widefat fixed striped">';
echo '<thead><tr>
        <th>ID</th>
        <th>Window Name</th>
        <th>Width</th>
        <th>Height</th>
        <th>Panes</th>
        <th>Recess</th>
        <th>Recess Depth</th>
        <th>Total Price</th>
        <th>Date</th>
        </tr></thead>'; // Added new table headers
echo '<tbody>';
foreach ($quotes as $quote) {
    echo '<tr>';
    echo '<td>' . esc_html($quote->id) . '</td>';
    echo '<td>' . esc_html($quote->window_name) . '</td>';
    echo '<td>' . esc_html($quote->width) . '</td>';
    echo '<td>' . esc_html($quote->height) . '</td>';
    echo '<td>' . esc_html($quote->panes) . '</td>'; // Added new table data
    echo '<td>' . esc_html($quote->recess) . '</td>'; // Added new table data
    echo '<td>' . esc_html($quote->recess_depth) . '</td>'; // Added new table data
    echo '<td>' . esc_html($quote->total_price) . '</td>';
    echo '<td>' . esc_html($quote->date_created) . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
