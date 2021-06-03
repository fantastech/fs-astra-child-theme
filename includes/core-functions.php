<?php

/**
 * Function to enable adding of custom post types easily.
 */

/**
 * Create new post type
 *
 * @param  string $cpt_slug the slug of CPT (required)
 * @param  string $cpt_name the name of CPT in singular (required)
 * @param  string $cpt_name_plural the name of CPT in plural (required)
 * @param  array  $args array for register_post_type function (optional)
 *
 * @return null
 */
if (!function_exists('fs_register_post_type')) {
    function fs_register_post_type($cpt_slug, $cpt_name, $cpt_name_plural, $args = [])
    {

        $labels = [
            'name'                => $cpt_name_plural,
            'singular_name'       => $cpt_name,
            'menu_name'           => $cpt_name_plural,
            'parent_item_colon'   => "Parent {$cpt_name}",
            'all_items'           => "All {$cpt_name_plural}",
            'view_item'           => "View {$cpt_name}",
            'add_new_item'        => "Add New {$cpt_name}",
            'add_new'             => 'Add New',
            'edit_item'           => "Edit {$cpt_name}",
            'update_item'         => "Update {$cpt_name}",
            'search_items'        => "Search {$cpt_name}",
            'not_found'           => "No {$cpt_name_plural} Found",
            'not_found_in_trash'  => "No {$cpt_name_plural} found in Trash"
        ];

        $args = wp_parse_args($args, [
            'label'               => $cpt_slug,
            'description'         => "{$cpt_name_plural} Post Type",
            'labels'              => $labels,
            'supports'            => [ 'title', 'editor', 'thumbnail', 'revisions'],
            'public'              => true,
            'hierarchical'        => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'has_archive'         => true,
            'can_export'          => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'capability_type'     => 'post'
        ]);

        register_post_type($cpt_slug, $args);
    }
}

/**
* Create new taxonomy for a post type
*
* @param  string $taxonomy_slug the slug of custom taxonomy (required)
* @param  string $taxonomy_name the name of custom taxonomy in singular (required)
* @param  string $taxonomy_name_plural the name of custom taxonomy in plural (required)
* @param  string $cpt_slug the slug of CPT (required)
* @param  array  $args array for register_taxonomy function (optional)
*
* @return null
*/
if (!function_exists('fs_register_taxonomy')) {
    function fs_register_taxonomy($taxonomy_slug, $taxonomy_name, $taxonomy_name_plural, $cpt_slug, $args = [])
    {

        $labels = [
            'name' => $taxonomy_name_plural,
            'singular_name' => $taxonomy_name,
            'search_items' =>  "Search {$taxonomy_name_plural}",
            'all_items' => "All {$taxonomy_name_plural}",
            'parent_item' => "Parent {$taxonomy_name}",
            'parent_item_colon' => "Parent {$taxonomy_name}:",
            'edit_item' => "Edit {$taxonomy_name}",
            'update_item' => "Update {$taxonomy_name}",
            'add_new_item' => "Add New {$taxonomy_name}",
            'new_item_name' => "New {$taxonomy_name} Name",
            'menu_name' => $taxonomy_name_plural,
        ];

        $args =  wp_parse_args($args, [
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_in_rest' => true,
            'rewrite' => [ 'slug' => $taxonomy_slug ]
        ]);

        register_taxonomy($taxonomy_slug, [ $cpt_slug ], $args);
    }
}

/**
* White Labeling Astra
*/

add_filter('astra_addon_get_white_labels', 'fs_modify_theme_labels');
function fs_modify_theme_labels($labels){
	$labels = array(
		'astra-agency' => array(
			'author'        => 'Fantastech',
			'author_url'    => 'https://fantastech.co/',
			'licence'       => '',
			'hide_branding' => true,
		),
		'astra'        => array(
			'name'        => 'FS Core',
			'description' => 'This is the main parent theme of your website. Do not delete.',
			'screenshot'  => get_stylesheet_directory_uri() . '/assets/images/screenshot-parent.png',
		),
		'astra-pro'    => array(
			'name'        => 'FS Core',
			'description' => 'This is the core plugin required by FS Core theme to function properly.',
		),
	);
	return $labels;
}

/**
* To change default small
* screen break point to 767px
*/
add_filter('astra_mobile_breakpoint', function () {
    return 767;
});

/**
* To change default tablet
* screen break point to 992px
*/
add_filter('astra_tablet_breakpoint', function () {
    return 992;
});

/**
* To change default header
* breakpoint for hamburger icons
*/
add_filter('astra_header_break_point', function () {
    return 992;
});

/**
 * Social share function. Use with
 * add_action to inject on frontend
 */
function fs_social_share_icons()
{
    $post_id = get_the_ID();
    $shareURL = rawurlencode(get_permalink($post_id));
    $shareTitle = str_replace(' ', '%20', get_the_title($post_id));
    $shareThumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');

    // Email Vars.
    $mailSubject = $shareTitle;
    $mailBody =  $shareTitle . '<br />' . $shareURL;

    // Construct sharing URL without using any script.
    $twitterURL = add_query_arg([
        'text' => $shareTitle,
        'url' => $shareURL,
    ], 'https://twitter.com/intent/tweet');

    $facebookURL = add_query_arg([
        'u' => $shareURL,
    ], 'https://www.facebook.com/sharer/sharer.php');
    
    $googleURL = add_query_arg([
        'url' => $shareURL,
    ], 'https://plus.google.com/share');
    
    $linkedInURL = add_query_arg([
        'mini' => 'true',
        'url' => $shareURL,
        'title' => $shareTitle,
    ], 'https://www.linkedin.com/shareArticle');
    
    $whatsappURL = add_query_arg([
        'text' => "{$shareTitle} {$shareURL}",
    ], 'whatsapp://send');
    
    $pinterestURL = add_query_arg([
        'url' => $shareURL,
        'media' => $shareThumbnail[0],
        'description' => $shareTitle,
    ], 'https://pinterest.com/pin/create/button/');

    ?>
    <div class="social-share-box">
        <a
            class="social-share-box-link social-share-email"
            href="mailto:?subject=<?php echo esc_attr($mailSubject); ?>&amp;body=<?php echo esc_attr($mailBody); ?>"
        >
            <span class="fa-stack fa-sm icon-envelope">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-envelope fa-stack-1x" title="Share on Gmail"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-facebook"
            href="<?php echo esc_url($facebookURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-facebook">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-facebook fa-stack-1x" title="Share on facebook"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-twitter"
            href="<?php echo esc_url($twitterURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-twitter">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-twitter fa-stack-1x" title="Share on Twitter"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-google-plus"
            href="<?php echo esc_url($googleURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-gplus">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-google-plus fa-stack-1x" title="Share on google plus"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-linkedin"
            href="<?php echo esc_url($linkedInURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-linkedin">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-linkedin fa-stack-1x" title="Share on LinkedIn"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-whatsapp"
            href="<?php echo esc_url($whatsappURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-whatsapp">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-whatsapp fa-stack-1x" title="Share on Whatsapp"></i>
            </span>
        </a>

        <a
            class="social-share-box-link social-share-pinterest"
            href="<?php echo esc_url($pinterestURL); ?>"
            target="_blank"
        >
            <span class="fa-stack fa-sm icon-pinterest">
                <i class="fa fa-square fa-stack-2x"></i>
                <i class="fa fa-pinterest fa-stack-1x" title="Share on pinterest"></i>
            </span>
        </a>

    </div>
    <?php
}
