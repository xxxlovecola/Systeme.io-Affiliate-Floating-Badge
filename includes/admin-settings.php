<?php

if (!defined('WPINC')) {
    die;
}

/**
 * Register the admin menu
 */
function sio_afb_add_admin_menu()
{
    add_menu_page(
        __('Systeme.io Badge', 'systeme-io-affiliate-floating-badge'),
        __('Systeme.io Badge', 'systeme-io-affiliate-floating-badge'),
        'manage_options',
        'systeme-io-badge',
        'sio_afb_settings_page',
        'dashicons-external',
        100
    );
}
add_action('admin_menu', 'sio_afb_add_admin_menu');

/**
 * Register settings
 */
function sio_afb_register_settings()
{
    register_setting('sio_afb_settings_group', 'sio_afb_settings', 'sio_afb_sanitize_settings');
}
add_action('admin_init', 'sio_afb_register_settings');

/**
 * Sanitize settings
 */
function sio_afb_sanitize_settings($input)
{
    $new_input = array();
    $new_input['affiliate_id'] = sanitize_text_field($input['affiliate_id']);
    $new_input['tracking_code'] = sanitize_text_field($input['tracking_code']);
    $new_input['language'] = in_array($input['language'], array('fr', 'en')) ? $input['language'] : 'fr';
    $new_input['badge_source'] = in_array($input['badge_source'], array('built-in', 'custom')) ? $input['badge_source'] : 'built-in';
    $new_input['built_in_badge'] = sanitize_text_field($input['built_in_badge']);
    $new_input['custom_badge_url'] = esc_url_raw($input['custom_badge_url']);
    $new_input['position'] = in_array($input['position'], array('bottom-right', 'bottom-left')) ? $input['position'] : 'bottom-right';
    $new_input['h_offset'] = intval($input['h_offset']);
    $new_input['v_offset'] = intval($input['v_offset']);
    $new_input['mobile_breakpoint'] = intval($input['mobile_breakpoint']);

    return $new_input;
}

/**
 * Settings page output
 */
function sio_afb_settings_page()
{
    $settings = get_option('sio_afb_settings');
    ?>
    <div class="wrap">
        <h1>
            <?php _e('Systeme.io Affiliate Floating Badge Settings', 'systeme-io-affiliate-floating-badge'); ?>
        </h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('sio_afb_settings_group');
            do_settings_sections('sio_afb_settings_group');
            ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <?php _e('Affiliate ID', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="text" name="sio_afb_settings[affiliate_id]"
                            value="<?php echo esc_attr($settings['affiliate_id']); ?>" class="regular-text" required />
                        <p class="description">
                            <?php _e('Example: sa=affiliate123', 'systeme-io-affiliate-floating-badge'); ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Tracking Code', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="text" name="sio_afb_settings[tracking_code]"
                            value="<?php echo esc_attr($settings['tracking_code']); ?>" class="regular-text" />
                        <p class="description">
                            <?php _e('Example: tk=BadgeAffiliationFacile', 'systeme-io-affiliate-floating-badge'); ?>
                        </p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Language', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <select name="sio_afb_settings[language]" id="sio_afb_language">
                            <option value="fr" <?php selected($settings['language'], 'fr'); ?>>French</option>
                            <option value="en" <?php selected($settings['language'], 'en'); ?>>English</option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Badge Source', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <label>
                            <input type="radio" name="sio_afb_settings[badge_source]" value="built-in" <?php checked($settings['badge_source'], 'built-in'); ?> />
                            <?php _e('Built-in', 'systeme-io-affiliate-floating-badge'); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="sio_afb_settings[badge_source]" value="custom" <?php checked($settings['badge_source'], 'custom'); ?> />
                            <?php _e('Custom', 'systeme-io-affiliate-floating-badge'); ?>
                        </label>
                    </td>
                </tr>

                <tr valign="top" id="built-in-badge-row" <?php echo $settings['badge_source'] === 'custom' ? 'style="display:none;"' : ''; ?>>
                    <th scope="row">
                        <?php _e('Select Built-in Badge', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <select name="sio_afb_settings[built_in_badge]" id="sio_afb_built_in_badge">
                            <!-- Options will be populated via JS or PHP based on language -->
                            <?php
                            $lang = $settings['language'];
                            $badges = array(
                                'fr' => array('badge-fr-1.gif' => 'Default Badge FR', 'badge-fr-2.gif' => 'Minimal Badge FR'),
                                'en' => array('badge-en-1.gif' => 'Default Badge EN', 'badge-en-2.gif' => 'Minimal Badge EN')
                            );
                            foreach ($badges[$lang] as $val => $label) {
                                echo '<option value="' . esc_attr($val) . '" ' . selected($settings['built_in_badge'], $val, false) . '>' . esc_html($label) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr valign="top" id="custom-badge-row" <?php echo $settings['badge_source'] === 'built-in' ? 'style="display:none;"' : ''; ?>>
                    <th scope="row">
                        <?php _e('Custom Image URL', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="text" name="sio_afb_settings[custom_badge_url]"
                            value="<?php echo esc_url($settings['custom_badge_url']); ?>" class="large-text" />
                        <button type="button" class="button" id="sio_afb_upload_btn">
                            <?php _e('Select Image', 'systeme-io-affiliate-floating-badge'); ?>
                        </button>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Position', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <select name="sio_afb_settings[position]">
                            <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>>Bottom
                                Right</option>
                            <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>>Bottom
                                Left</option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Horizontal Offset (px)', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="number" name="sio_afb_settings[h_offset]"
                            value="<?php echo esc_attr($settings['h_offset']); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Vertical Offset (px)', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="number" name="sio_afb_settings[v_offset]"
                            value="<?php echo esc_attr($settings['v_offset']); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <?php _e('Mobile Breakpoint (px)', 'systeme-io-affiliate-floating-badge'); ?>
                    </th>
                    <td>
                        <input type="number" name="sio_afb_settings[mobile_breakpoint]"
                            value="<?php echo esc_attr($settings['mobile_breakpoint']); ?>" />
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const languageSelect = document.getElementById('sio_afb_language');
            const badgeSourceRadios = document.querySelectorAll('input[name="sio_afb_settings[badge_source]"]');
            const builtInRow = document.getElementById('built-in-badge-row');
            const customRow = document.getElementById('custom-badge-row');
            const builtInSelect = document.getElementById('sio_afb_built_in_badge');

            const languageBadges = {
                fr: { 'badge-fr-1.gif': 'Default Badge FR', 'badge-fr-2.gif': 'Minimal Badge FR' },
                en: { 'badge-en-1.gif': 'Default Badge EN', 'badge-en-2.gif': 'Minimal Badge EN' }
            };

            languageSelect.addEventListener('change', function () {
                const lang = this.value;
                builtInSelect.innerHTML = '';
                for (const [val, label] of Object.entries(languageBadges[lang])) {
                    const option = document.createElement('option');
                    option.value = val;
                    option.textContent = label;
                    builtInSelect.appendChild(option);
                }
            });

            badgeSourceRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'built-in') {
                        builtInRow.style.display = '';
                        customRow.style.display = 'none';
                    } else {
                        builtInRow.style.display = 'none';
                        customRow.style.display = '';
                    }
                });
            });

            // Media uploader logic (simplified)
            document.getElementById('sio_afb_upload_btn').addEventListener('click', function (e) {
                e.preventDefault();
                alert('In a real WordPress environment, this would open the Media Library.');
            });
        });
    </script>
    <?php
}
