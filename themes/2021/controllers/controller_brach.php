<?php

class Admin_Controller_Brach
{

    public function __construct()
    {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-brach_columns', array($this, 'ManageColumns'));
        add_action('manage_brach_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function create()
    {
        $labels = array(
            'name' => __('分會'),
            'singular_name' => __('分會'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'edit_item' => __('修改'),
            'new_item' => __('新增'),
            'all_items' => __('所有分會'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
            'parent_item_colon' => '',
            'menu_name' => __('分會')
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

    public function ManageColumns($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'Title' => __('分會'),
            'contact' => __('會長'),
            'email' => __('E-mail'),
            'phone' => __('電話'),
            'order_by' => __('排序'),
            'date' => __('日期'),
        );
        return $columns;
    }

    public function RenderColumns($columns)
    {
        global $post;
        switch ($columns) {
                /* If displaying the 'duration' column. */
            case 'email':
                echo get_post_meta($post->ID, 'b_email', true);
                break;
            case 'contact':
                echo get_post_meta($post->ID, 'b_contact', true);
                break;
            case 'phone':
                echo get_post_meta($post->ID, 'b_phone', true);
                break;
            case 'order_by':
                echo get_post_meta($post->ID, '_metabox_order_by', true);
                break;
                /* Just break out of the switch statement for everything else. */
            default:
                break;
        }
    }
}
