<?php
/*----------------------------------------------------------------------------------------------------------------------
Plugin Name: Category Extra Content
Description: Adds additional content to posts in categories
Version: 0.1.0
Author: Matthias Kleine
Author URI: http://mkleine.de/
Plugin URI: http://www.yarpp.com/
----------------------------------------------------------------------------------------------------------------------*/

define('CATEGORY_EXTRA_DIR', dirname(__FILE__));

include_once(CATEGORY_EXTRA_DIR.'/classes/Core.php');

add_action('init', 'category_extra_create_post_type');
function category_extra_create_post_type()
{
    register_post_type(
        'category_extra',
        array(
            'labels' => array(
                'name' => __('Category Extra'),
                'singular_name' => __('Category Extra')
            ),
            'taxonomies' => array('category'),
            'public' => true,
            'has_archive' => true
        )
    );
}

add_filter('the_content', 'category_extra_append_data');
function category_extra_append_data($content)
{
    if (is_single()) {



    }

    return $content;
}