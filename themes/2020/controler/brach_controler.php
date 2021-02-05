<?php

class Admin_Brach_Controler {

    public function __construct() {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-brach_columns', array($this, 'ManageColumns'));
        add_action('manage_brach_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function create() {
        $labels = array(
            'name' => _x('商會分會', 'suite'),
            'singular_name' => _x('商會分會', 'suite'),
            'add_new' => _x('新增商會分會', 'suite'),
            'add_new_item' => _x('新增商會分會', 'suite'),
            'edit_item' => _x('修改商會分會', 'suite'),
            'new_item' => _x('新增商會分會', 'suite'),
            'all_items' => _x('商會分會名單', 'suite'),
            'view_item' => _x('View Brach', 'suite'),
            'search_items' => _x('Search Brach', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No Forum found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('商會分會', 'suite')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 2,
            /*  'capabilities' => array(
              //       'create_posts' => 'do_not_allow'), */
            'supports' => array('title', 'editor', 'thumbnail'),
        );
        register_post_type('brach', $args);
        //flush_rewrite_rules();
    }

    public function ManageColumns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'Title' => __(' 分 會', 'suite'),
            'contact' => __('會 長', 'suite'),
            'email' => __('E-mail', 'suite'),
            'phone' => __('電 話', 'suite'),
            'order_by' => __('排 序', 'suite'),
            'date' => __('日 期', 'suite'),
        );
        return $columns;
    }

    public function RenderColumns($columns) {
        global $post;
        switch ($columns) {
            /* If displaying the 'duration' column. */
            case 'email' :
                echo get_post_meta($post->ID, 'b_email', true);
                break;
            case 'contact' :
                echo get_post_meta($post->ID, 'b_contact', true);
                break;
            case 'phone' :
                echo get_post_meta($post->ID, 'b_phone', true);
                break;
            case 'order_by' :
                echo get_post_meta($post->ID, '_metabox_order_by', true);
                break;
            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }

}
