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
define('FS_THEME_VERSION', '2.0.0');
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

    // Enqueue Beaver Builder's Font Awesome librsry file.
    if (FS_THEME_USE_FONT_AWESOME) {
        wp_enqueue_style('font-awesome-5');
    }

    // Enqueue this theme's style.css.
    wp_enqueue_style(
        'fs-theme-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.css',
        [],
        $version,
        'all'
    );

    // Enqueue script.js file.
    if (FS_THEME_USE_CUSTOM_JS) {
        wp_enqueue_script(
            'fs-theme-js',
            get_stylesheet_directory_uri() . '/assets/js/script.js',
            ['jquery'],
            $version,
            true
        );
    }
}, 10);

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
        'class' => 'primary-button',
        'settings' => $default_settings
    ];

    $button_presets['secondary'] = [
        'name' => 'Secondary',
        'class' => 'secondary-button',
        'settings' => fs_wp_parse_args_recursive([
            'bg_color' => '000000',
            'bg_hover_color' => 'ffffff',
            'text_color' => 'ffffff',
            'text_hover_color' => '000000',
            'border' => [
                'color' => '000000'
            ]
        ], $default_settings),
    ];

    return $button_presets;
}

/**
 * Create custom row presets for BB to add respective class to the rows.
 *
 * @see /includes/bb-functions.php
 * @see /resources/styles/common/_utilities.scss
 */
function fs_get_row_presets()
{
    $row_presets = [
        'default' => 'Default',
        'homepage-banner-row' => 'Homepage Banner Row',
        'page-banner-row' => 'Hero Banner Row',
    ];
    return $row_presets;
}

/**
 * Create custom row background presets for BB to add respective class to the rows.
 *
 * @see /includes/bb-functions.php
 * @see /resources/styles/common/_utilities.scss
 */
function fs_get_background_presets()
{
    $bg_presets = [
        'default' => 'No Preset Background',
        'grey-background' => 'Grey Background',
        'white-background' => 'White Background'
    ];
    return $bg_presets;
}
