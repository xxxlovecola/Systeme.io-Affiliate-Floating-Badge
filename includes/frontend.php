<?php

if (!defined('WPINC')) {
    die;
}

/**
 * Enqueue frontend assets
 */
function sio_afb_enqueue_assets()
{
    wp_enqueue_style('sio-afb-style', SIO_AFB_URL . 'assets/css/frontend.css', array(), SIO_AFB_VERSION);
    wp_enqueue_script('sio-afb-script', SIO_AFB_URL . 'assets/js/frontend.js', array(), SIO_AFB_VERSION, true);

    $settings = get_option('sio_afb_settings');
    $language = $settings['language'];

    // Dynamic data for JS
    $links_config = array(
        'fr' => array(
            'base_url' => 'https://systeme.io/fr/',
            'links' => array(
                array('title' => 'Compte Gratuit', 'path' => ''),
                array('type' => 'separator', 'title' => 'Plans Startup'),
                array('title' => 'Startup Mensuel', 'path' => 'pricing'),
                array('title' => 'Startup Annuel', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Plans Webinars'),
                array('title' => 'Webinar Mensuel', 'path' => 'pricing'),
                array('title' => 'Webinar Annuel', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Plans Illimités'),
                array('title' => 'Unlimited Mensuel', 'path' => 'pricing'),
                array('title' => 'Unlimited Annuel', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Installer ce badge'),
                array('title' => 'Comment installer le badge', 'path' => 'badge-info'),
            )
        ),
        'en' => array(
            'base_url' => 'https://systeme.io/en/',
            'links' => array(
                array('title' => 'Free Account', 'path' => ''),
                array('type' => 'separator', 'title' => 'Startup Plans'),
                array('title' => 'Startup Monthly', 'path' => 'pricing'),
                array('title' => 'Startup Annual', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Webinar Plans'),
                array('title' => 'Webinar Monthly', 'path' => 'pricing'),
                array('title' => 'Webinar Annual', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Unlimited Plans'),
                array('title' => 'Unlimited Monthly', 'path' => 'pricing'),
                array('title' => 'Unlimited Annual', 'path' => 'pricing'),
                array('type' => 'separator', 'title' => 'Install this badge'),
                array('title' => 'Install this badge', 'path' => 'badge-info'),
            )
        )
    );

    $badge_url = '';
    if ($settings['badge_source'] === 'built-in') {
        $badge_url = SIO_AFB_URL . 'assets/images/' . $settings['built_in_badge'];
    } else {
        $badge_url = $settings['custom_badge_url'];
    }

    $js_data = array(
        'affiliate_id' => $settings['affiliate_id'],
        'tracking_code' => $settings['tracking_code'],
        'language' => $language,
        'badge_url' => $badge_url,
        'position' => $settings['position'],
        'h_offset' => $settings['h_offset'],
        'v_offset' => $settings['v_offset'],
        'mobile_breakpoint' => $settings['mobile_breakpoint'],
        'config' => $links_config[$language]
    );

    wp_localize_script('sio-afb-script', 'sio_afb_data', $js_data);
}
add_action('wp_enqueue_scripts', 'sio_afb_enqueue_assets');

/**
 * Add container to footer
 */
function sio_afb_footer_container()
{
    echo '<div id="sio-afb-container"></div>';
}
add_action('wp_footer', 'sio_afb_footer_container');
