<?php
/**
 * Plugin Name: Systeme.io Affiliate Floating Badge
 * Description: Displays a floating badge with a drop-up menu to promote Systeme.io affiliate offers.
 * Version: 1.0.0
 * Author: James
 * License: GPL2
 * Text Domain: systeme-io-affiliate-floating-badge
 */

if (!defined('WPINC')) {
    die;
}

// Define constants
define('SIO_AFB_VERSION', '1.0.0');
define('SIO_AFB_PATH', plugin_dir_path(__FILE__));
define('SIO_AFB_URL', plugin_dir_url(__FILE__));

// Include required files
require_once SIO_AFB_PATH . 'includes/admin-settings.php';
require_once SIO_AFB_PATH . 'includes/frontend.php';

// Add settings link on plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'sio_afb_settings_link');

function sio_afb_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=systeme-io-badge">' . __('Settings', 'systeme-io-affiliate-floating-badge') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Activation hook
register_activation_hook(__FILE__, 'sio_afb_activate');

function sio_afb_activate()
{
    // Default settings
    $defaults = array(
        'affiliate_id' => '',
        'tracking_code' => 'BadgeAffiliationFacile',
        'language' => 'fr',
        'badge_source' => 'built-in',
        'built_in_badge' => 'badge-fr-1.gif',
        'custom_badge_url' => '',
        'position' => 'bottom-right',
        'h_offset' => 10,
        'v_offset' => 10,
        'mobile_breakpoint' => 900,
        'display_on' => array('home', 'single', 'archive'),
    );

    if (false === get_option('sio_afb_settings')) {
        add_option('sio_afb_settings', $defaults);
    }
}
