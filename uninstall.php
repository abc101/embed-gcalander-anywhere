<?php

// Check security
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// List to delete option
$options = [
    'embed_gca_title',
    'embed_gca__timezone',
    'multiple_calendar_ids',
    'embed_gca__iframe_width',
    'embed_gca__iframe_height'
];

// Delet each option
foreach ($options as $option) {
    delete_option($option);
}
