<?php

/*
 * Plugin Name:       Embed GCalendar Anywhere
 * Plugin URI:        https://github.com/abc101/embed-gcalendar-anywhere
 * Description:       Embed Public Google Calendars Anywhere with color options, customizable iframe size, timezone settings, and view modes in WordPress.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Song M. Kim
 * Author URI:        https://abc101.net/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// 1. Add a settings page to the admin menu
function embed_gca_plugin_menu() {
    add_options_page(
        'Embed GCalendar Anywhere Settings',        // page title
        'Embed GCalendar Anywhere',                 // menu name
        'manage_options',                  // privileges
        'embed-gca-settings',        // page slug
        'embed_gca_settings_page'    // callback function
    );
}
add_action('admin_menu', 'embed_gca_plugin_menu');

// 2. Importing JavaScript modules
function embed_gca_enqueue_scripts($hook) {
    if ($hook != 'settings_page_embed-gca-settings') {
        return;
    }
    wp_enqueue_script(
        'main-js', 
        plugins_url('main.js', __FILE__), 
        [], 
        filemtime(plugin_dir_path(__FILE__) . 'main.js'), 
        true
    );
    

}
add_action('admin_enqueue_scripts', 'embed_gca_enqueue_scripts');

// 3. Callback function for a settings page
function embed_gca_settings_page() {
    ?>
    <div class="wrap">
        <h1>Embed GCalendar Anywhere Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('embed_gca_settings_group'); // settings group
            do_settings_sections('embed-gca-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// 4. Register settings feild
function embed_gca_settings_init() {
    register_setting('embed_gca_settings_group', 'embed_gca_title', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => ''
    ]);
    register_setting('embed_gca_settings_group', 'multiple_calendar_ids', [
        'type' => 'array',
        'sanitize_callback' => 'embed_gca_sanitize_ids'
    ]);
    register_setting('embed_gca_settings_group', 'embed_gca_iframe_width', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '800'
    ]);
    register_setting('embed_gca_settings_group', 'embed_gca_iframe_height', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => '600'
    ]);
    register_setting('embed_gca_settings_group', 'embed_gca_timezone', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'UTC'
    ]);


    add_settings_section(
        'embed_gca_section',
        'GCalendar Settings',
        'embed_gca_section_callback',
        'embed-gca-settings'
    );

    add_settings_field(
        'embed_gca_title',
        'Calendar Title',
        'embed_gca_title_callback',
        'embed-gca-settings',
        'embed_gca_section'
    );

    add_settings_field(
        'embed_gca_timezone',
        'Time Zone',
        'embed_gca_timezone_callback',
        'embed-gca-settings',
        'embed_gca_section'
    );
    
    add_settings_field(
        'multiple_calendar_ids',
        'Google Calendar IDs and Colors',
        'multiple_calendar_ids_callback',
        'embed-gca-settings',
        'embed_gca_section'
    );

    add_settings_field(
        'embed_gca_iframe_width',
        'iFrame Width (px)',
        'embed_gca_iframe_width_callback',
        'embed-gca-settings',
        'embed_gca_section'
    );

    add_settings_field(
        'embed_gca_iframe_height',
        'iFrame Height (px)',
        'embed_gca_iframe_height_callback',
        'embed-gca-settings',
        'embed_gca_section'
    );
}
add_action('admin_init', 'embed_gca_settings_init');

// Settings section description
function embed_gca_section_callback() {
    echo '<p>This plugin allows you to embed multiple <b>Public</b> Google Calendars with color options, customizable iframe size, timezone settings, and different view modes (Month, Week, Agenda) on your WordPress site.</p>';

    echo '<h3>How to Use:</h3>';
    echo '<ol>';
    echo '<li>Go to the settings below to add multiple <b>Public</b> Google  Calendar IDs and set individual colors for each.</li>';
    echo '<li>Specify the iframe width, height, and select your preferred timezone.</li>';
    echo '<li>Use the shortcode <code> [embed-gca]</code>. It\'s default mode and same with <code>[embed-gca mode="MONTH"]</code> to display the monthly calendar. You can change the <code>mode</code> attribute to <code>WEEK</code> or <code>AGENDA</code> for different views.</li>';
    echo '<li>For example, use <code>[embed-gca mode="WEEK"]</code> for a weekly view or <code>[embed-gca mode="AGENDA"]</code> for an agenda view.</li>';
    echo '</ol>';
    echo '<p>After configuring the settings and inserting the shortcode into a post or page, your Google Calendars will be displayed with your specified settings.</p>';
    echo '<p>👉 Google Calendar doesn\'t support <code><b>mode="DAY"</b></code>';
}

// Title input field callback function
function embed_gca_title_callback() {
    $title = get_option('embed_gca_title', '');
    echo "<input type='text' name='embed_gca_title' value='" . esc_attr($title) . "' placeholder='Enter calendar title' style='width: 300px;' />";
}

// Callback function for multiple calendar IDs and color input fields
function multiple_calendar_ids_callback() {
    $calendar_data = get_option('multiple_calendar_ids', [['id' => '', 'color' => '#000000']]);
    echo '<div id="calendar-ids-container" style="margin-top: 10px;">';
    foreach ($calendar_data as $index => $data) {
        $id_value = esc_attr($data['id']);
        $color_value = esc_attr($data['color']);
        echo "<div style='margin-bottom: 10px; display: flex; gap: 5px; align-items: center;'>";
        echo "<input type='text' name='multiple_calendar_ids[" . esc_attr($index) . "][id]' value='" . esc_attr($id_value) . "' placeholder='Enter Calendar ID' style='width: 200px;' />";
        echo "<input type='color' name='multiple_calendar_ids[" . esc_attr($index) . "][color]' value='" . esc_attr($color_value) . "' />";

        echo '</button>';

        if ($index > 0) {
            echo "<button type='button' class='remove-id' onclick='this.parentNode.remove()'>Remove</button>";
        }
        echo '</div>';
    }
    echo '</div>';
    echo "<button type='button' onclick='addCalendarIdField()'>Add Calendar ID</button>";
}

// Callback function for iFrame width
function embed_gca_iframe_width_callback() {
    $width = get_option('embed_gca_iframe_width', '800');
    echo "<input type='text' name='embed_gca_iframe_width' value='" . esc_attr($width) . "' style='width: 100px;' /> px";
}

// Callback function for iFrame height 
function embed_gca_iframe_height_callback() {
    $height = get_option('embed_gca_iframe_height', '600');
    echo "<input type='text' name='embed_gca_iframe_height' value='" . esc_attr($height) . "' style='width: 100px;' /> px";
}

// Callback function for timezone drop dwon menu
function embed_gca_timezone_callback() {
    $timezone = get_option('embed_gca_timezone', 'UTC');
    $timezones = timezone_identifiers_list();

    echo "<select name='embed_gca_timezone' style='width: 200px;'>";
    foreach ($timezones as $zone) {
        $selected = ($zone === $timezone) ? 'selected' : '';
        echo "<option value='" . esc_attr($zone) . "' " . esc_attr($selected) . ">" . esc_html($zone) . "</option>";
    }
    echo "</select>";
}

// 4. Creating a personalized iFrame view for multiple calendars, allowing users to customize color, size, time zone, and view preferences
function display_iframe_embed_gcas($atts) {
    $calendar_data = get_option('multiple_calendar_ids', []);
    $iframe_width = get_option('embed_gca_iframe_width', '800');
    $iframe_height = get_option('embed_gca_iframe_height', '600');
    $timezone = get_option('embed_gca_timezone', 'UTC');
    $calendar_title = get_option('embed_gca_title', '');
    
    // Setting up the 'mode' attribute handler in shortcodes, with 'MONTH' as the fallback value
    $atts = shortcode_atts(['mode' => 'MONTH'], $atts, 'iframe_embed_gcas_with_colors');
    $mode = strtoupper($atts['mode']);
    if (!in_array($mode, ['MONTH', 'WEEK', 'AGENDA'])) {
        $mode = 'MONTH'; // Set to the default value if the value is invalid
    }

    // Assign the current date in Ymd format to the 'start' and 'end' properties of the 'dates' object
    $today = gmdate('Ymd');
    $dates = "{$today}/{$today}"; 

    if (empty($calendar_data)) {
        return '<p>Please set your Google Calendar IDs, colors, iFrame size, and time zone in the settings page.</p>';
    }

    $base_url = "https://calendar.google.com/calendar/embed?";
    $iframe_url = $base_url . http_build_query([
        'ctz' => $timezone,  
        'mode' => $mode,      
        'dates' => $dates,
        'title' => $calendar_title
    ]);

    foreach ($calendar_data as $data) {
        if (!empty($data['id'])) {
            $iframe_url .= "&src=" . urlencode($data['id']) . "&color=" . urlencode($data['color']);
        }
    }

    $output = "<iframe src='{$iframe_url}' style='border: 0' width='{$iframe_width}' height='{$iframe_height}' frameborder='0' scrolling='no'></iframe>";

    return $output;
}
add_shortcode('embed-gca', 'display_iframe_embed_gcas');

// A function to construct a data structure suitable for database insertion from an array of IDs and colors
function embed_gca_sanitize_ids($input) {
    $sanitized = [];
    foreach ($input as $item) {
        if (!empty($item['id'])) {
            $sanitized[] = [
                'id' => sanitize_text_field($item['id']),
                'color' => sanitize_hex_color($item['color'])
            ];
        }
    }
    return $sanitized;
}
