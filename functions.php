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
define('FS_THEME_VERSION', '1.0.9');
define('FS_THEME_USE_FONT_AWESOME', false); // Enable this only if BB plugin is active.
define('FS_THEME_USE_CUSTOM_JS', false); // This will enqueue script.js file.
define('FS_THEME_USE_LIGHTBOX_LIB', false); // This will enqueue jquery.lightbox_me.min.js file.

/**
* Include core functions
*/
require_once 'includes/core-functions.php';

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
