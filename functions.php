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
define('FS_THEME_VERSION', '1.0.10');
define('FS_THEME_USE_FONT_AWESOME', false); // Enable this only if BB plugin is active.
define('FS_THEME_USE_CUSTOM_JS', false); // This will enqueue script.js file.
define('FS_THEME_USE_LIGHTBOX_LIB', false); // This will enqueue jquery.lightbox_me.min.js file.

/**
* Include core functions
*/
require_once 'includes/core-functions.php';
require_once 'includes/bb-functions.php';

/**
* Enqueue styles
*/
add_action('wp_enqueue_scripts', 'fs_enqueue_stuff', 10);
function fs_enqueue_stuff()
{
    
    /**
     * Styles
     */
    
    // Enqueue Beaver Builder's Font Awesome librsry file.
    if (FS_THEME_USE_FONT_AWESOME) {
        wp_enqueue_style('font-awesome-5');
    }
    
    // Enqueue this theme's style.css.
    wp_enqueue_style(
        'fs-theme-styles', 
        get_stylesheet_uri(), 
        [], 
        FS_THEME_VERSION, 
        'all'
    );
    
    /**
     * Scripts
     */
    
    // Enqueue lightbox_me.min.js library file.
    if (FS_THEME_USE_LIGHTBOX_LIB) {
        wp_enqueue_script(
            'fs-lightbox',
            "{$ssdu}/assets/js/jquery.lightbox_me.min.js",
            ['jquery'],
            FS_THEME_VERSION,
            true,
        );
    }

    // Enqueue script.js file.
    if (FS_THEME_USE_CUSTOM_JS) {
        wp_enqueue_script(
            'fs-theme-js', 
            get_stylesheet_directory_uri() . '/assets/js/script.js', 
            ['jquery'], 
            FS_THEME_VERSION, 
            true
        );
    }
}

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
function fs_define_bb_button_presets()
{
    $button_presets = array();

    $button_presets['primary'] = array(
        'name' => 'Primary',
        'class' => 'primary-button',
        'settings' => array(
            'bg_color'                  => "dddddd",
            'bg_hover_color'            => "808080",
            'text_color'                => "000000",
            'text_hover_color'          => "000000",
            'padding_top'               => '10',
            'padding_top_medium'        => '10',
            'padding_top_responsive'    => '10',
            'padding_right'             => '20',
            'padding_right_medium'      => '20',
            'padding_right_responsive'  => '20',
            'padding_bottom'            => '10',
            'padding_bottom_medium'     => '10',
            'padding_bottom_responsive' => '10',
            'padding_left'              => '20',
            'padding_left_medium'       => '20',
            'padding_left_responsive'   => '20',
            'typography' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'typography_medium' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'typography_responsive' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'border' => array(
                'style' => "solid",
                'color' => "cccccc",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_medium'     => array(
                'style' => "solid",
                'color' => "cccccc",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_responsive' => array(
                'style' => "solid",
                'color' => "cccccc",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_hover_color' => "808080"
        )
    );

    $button_presets['secondary'] = array(
        'name' => 'Secondary',
        'class' => 'secondary-button',
        'settings' => array(
            'bg_color'                  => "aaaaaa",
            'bg_hover_color'            => "808080",
            'text_color'                => "000000",
            'text_hover_color'          => "ffffff",
            'padding_top'               => '10',
            'padding_top_medium'        => '10',
            'padding_top_responsive'    => '10',
            'padding_right'             => '20',
            'padding_right_medium'      => '20',
            'padding_right_responsive'  => '20',
            'padding_bottom'            => '10',
            'padding_bottom_medium'     => '10',
            'padding_bottom_responsive' => '10',
            'padding_left'              => '20',
            'padding_left_medium'       => '20',
            'padding_left_responsive'   => '20',
            'typography' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'typography_medium' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'typography_responsive' => array(
                'font_size' => array(
                    'length' => '16',
                    'unit' => 'px'
                ),
                'line_height' => array(
                    'length' => '20',
                    'unit' => 'px'
                ),
                'font_weight' => '400',
                'text_align' => 'left'
            ),
            'border' => array(
                'style' => "solid",
                'color' => "999999",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_medium'     => array(
                'style' => "solid",
                'color' => "999999",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_responsive' => array(
                'style' => "solid",
                'color' => "999999",
                'width' => array(
                    'top' => '1',
                    'right' => '1',
                    'bottom' => '1',
                    'left' => '1'
                ),
                'radius' => array(
                    'top_left' => '5',
                    'top_right' => '5',
                    'bottom_left' => '5',
                    'bottom_right' => '5'
                ),
                'shadow' => array(
                    'color' => '',
                    'horizontal' => '',
                    'vertical' => '',
                    'blur' => '',
                    'spread' => ''
                )
            ),
            'border_hover_color' => "808080"
        )
    );

    return $button_presets;

}
