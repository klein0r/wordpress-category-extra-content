<?php

class CategoryExtraContent
{
    public function __construct()
    {
        add_action('init', array($this, 'add_custom_post_type'));

        add_filter('the_content', array($this, 'the_content'), 1100);
        #add_filter('the_content_feed', array($this, 'the_content_feed'), 500);
        #add_filter('the_excerpt_rss', array($this, 'the_excerpt_rss'), 500);
    }

    /**
     * Register the new extra category post type
     */
    public function add_custom_post_type()
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

    public function the_content($content) {
        /* this filter doesn't handle feeds */
        if (is_feed()) return $content;

        if ($extraContent = $this->display_basic()) {
            $content .= $extraContent;
        }

        return $content;
    }

    protected function display_basic() {
        /* if it's not an auto-display post type, return */
        if (get_post_type() == 'post') {

            if (!is_singular() && (is_archive() || is_home())) {
                return null;
            }

            #query_posts( 'cat=33,44,55,66' );
            $extraQuery = new WP_Query('post_type=category_extra');

            foreach(get_the_category() as $category)
            {
                $extraQuery->is_category($category);
            }

            $extraPosts = $extraQuery->get_posts();

            // Workaround - save post temporarily
            $originalPost = $GLOBALS['post'];

            $extraContent = array();
            /** @var $extraPost WP_Post */
            foreach ($extraPosts as $extraPost)
            {
                // Change global to avoid recursion when apply filters to content
                $GLOBALS['post'] = $extraPost;

                $content = $extraPost->post_content;
                $content = apply_filters( 'the_content', $content );
                $content = str_replace( ']]>', ']]&gt;', $content );

                $extraContent[] = $content;
            }

            $GLOBALS['post'] = $originalPost;

            return join('', $extraContent);
        }

        return null;
    }
}