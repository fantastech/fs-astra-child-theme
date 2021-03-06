<?php
/**
 * To prevent accessing the file directly.
 */

if (! defined('ABSPATH')) {
    return;
}

/**
* Define Constants
*/
define('FS_THEME_VERSION', '2.1');
define('FS_DEV_MODE', false);
define('FS_THEME_USE_FONT_AWESOME', false); // Enable this only if BB plugin is active.
define('FS_THEME_USE_CUSTOM_JS', false); // This will enqueue script.js file.

/**
* Include core functions
*/
require_once 'includes/core-functions.php';
require_once 'includes/bb-functions.php';

/**
* Enqueue styles
*/
add_action('wp_enqueue_scripts', function () {
    $version = FS_DEV_MODE ? time() : FS_THEME_VERSION;

    // Enqueue Beaver Builder's Font Awesome library file.
    if (FS_THEME_USE_FONT_AWESOME) {
        wp_enqueue_style('font-awesome-5');
    }

    // Enqueue this theme's style.css.
    wp_enqueue_style(
        'fs-theme-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        [],
        $version,
    );

    // Enqueue script.js file.
    if (FS_THEME_USE_CUSTOM_JS) {
        wp_enqueue_script(
            'fs-theme-js',
            get_stylesheet_directory_uri() . '/assets/js/script.js',
            ['jquery'],
            $version,
            true,
        );
    }
});

/**
* Define custom image sizes
*/
add_action('after_setup_theme', function () {
    add_image_size('homepage-banner', 1920, 1280);
    add_image_size('page-banner', 1920, 800);
    add_image_size('post-item-thumbnail', 400, 300);
});

/**
* Add custom image sizes to Beaver Builder sekector
*/
add_filter('image_size_names_choose', function ($sizes) {
    global $_wp_additional_image_sizes;
    if (empty($_wp_additional_image_sizes)) {
        return $sizes;
    }

    foreach ($_wp_additional_image_sizes as $id => $data) {
        if (!isset($sizes[$id])) {
            $sizes[$id] = ucfirst(str_replace('-', ' ', $id));
        }
    }

    return $sizes;
}, 15, 1);

/**
 * Create custom post types (if needed)
 * Delete the function or the lines if not needed
 *
 * @see /includes/core-functions.php for available paramters.
 */
function fs_define_post_types_taxonomies()
{
    fs_register_post_type('book', 'Book', 'Books');
    fs_register_taxonomy('book_cat', 'Book Category', 'Book Categories', 'book');
}
// Uncomment the lines below to add custom post type and taxonomies.
// phpcs:ignore Squiz.Commenting.InlineComment.InvalidEndChar
// add_action('init', 'fs_define_post_types_taxonomies', 0);

/**
 * Gets and returns the generated config from SCSS variables.
 *
 * @return array
 */
function fs_get_theme_style_config()
{
    return json_decode(file_get_contents(get_stylesheet_directory() . '/assets/palette.json'));
}

/**
 * Create custom button presets for BB Button module.
 *
 * @see /includes/bb-functions.php
 */
function fs_get_bb_button_presets()
{
    $button_presets = [];
    $default_border_settings = [
        'style' => 'solid',
        'color' => 'cccccc',
        'width' => [
            'top' => '1',
            'right' => '1',
            'bottom' => '1',
            'left' => '1',
        ],
        'radius' => [
            'top_left' => '5',
            'top_right' => '5',
            'bottom_left' => '5',
            'bottom_right' => '5',
        ],
        'shadow' => [
            'color' => '',
            'horizontal' => '',
            'vertical' => '',
            'blur' => '',
            'spread' => '',
        ],
    ];
    $default_typography_settings = [
        'font_size' => [
            'length' => '16',
            'unit' => 'px',
        ],
        'line_height' => [
            'length' => '20',
            'unit' => 'px',
        ],
        'font_weight' => '400',
        'text_align' => 'left',
        'text_decoration' => 'none',
        'font_family' => 'Default'
    ];
    $default_settings = [
        'bg_color' => 'eeeeee',
        'bg_hover_color' => 'cccccc',
        'text_color' => '000000',
        'text_hover_color' => '000000',
        'padding_top' => '10',
        'padding_top_medium' => '10',
        'padding_top_responsive' => '10',
        'padding_right' => '20',
        'padding_right_medium' => '20',
        'padding_right_responsive' => '20',
        'padding_bottom' => '10',
        'padding_bottom_medium' => '10',
        'padding_bottom_responsive' => '10',
        'padding_left' => '20',
        'padding_left_medium' => '20',
        'padding_left_responsive' => '20',
        'typography' => $default_typography_settings,
        'typography_medium' => $default_typography_settings,
        'typography_responsive' => $default_typography_settings,
        'border' => $default_border_settings,
        'border_medium' => $default_border_settings,
        'border_responsive' => $default_border_settings,
        'border_hover_color' => '808080',
    ];

    $button_presets['primary'] = [
        'name' => 'Primary',
        'class' => 'button-primary',
        'settings' => $default_settings,
    ];

    $button_presets['secondary'] = [
        'name' => 'Secondary',
        'class' => 'button-secondary',
        'settings' => fs_wp_parse_args_recursive([
            'bg_color' => '000000',
            'bg_hover_color' => 'ffffff',
            'text_color' => 'ffffff',
            'text_hover_color' => '000000',
            'border' => [
                'color' => '000000',
            ],
        ], $default_settings),
    ];

    return $button_presets;
}

/**
 * Returns a list of classes for use as "row presets" in Beaver Builder.
 *
 * @see /includes/bb-functions.php
 * @see /resources/styles/common/_utilities.scss
 *
 * @return array
 */
function fs_get_row_preset_class_names()
{
    return [
        'row-preset-default' => 'Default',
        'row-preset-homepage-banner' => 'Homepage Banner',
        'row-preset-page-banner' => 'Hero Banner',
    ];
}

/**
 * Gets a list of classes available for use as background colours.
 *
 * @see /includes/bb-functions.php
 * @see /resources/styles/common/_utilities.scss
 *
 * @return array
 */
function fs_get_background_class_names()
{
    return [
        'bg-default' => 'Default',
        'bg-grey-dark' => 'Dark grey',
        'bg-grey-light' => 'Light grey',
        'bg-white' => 'White',
    ];
}
