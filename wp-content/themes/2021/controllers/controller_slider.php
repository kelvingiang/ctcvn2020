<?php

class Admin_Controller_Slider
{

    public function __construct()
    {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-slide_columns', array($this, 'ManageColumns'));
        add_action('manage_slide_posts_custom_column', array($this, 'RenderColumns'));
    }

    function create()
    {
        $labels = array(
            'name' => __('幻燈片  1000 x 400 '),
            'singular_name' => __('幻燈片'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'edit_item' => __('修改'),
            'new_item' => __('新增'),
            'all_items' => __('全部幻燈片'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
            'parent_item_colon' => '',
            'menu_name' => __('幻燈片')
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
            'menu_position' => 6,
            'supports' => array('title', 'thumbnail')
        );
        register_post_type('slide', $args);
    }

    public function ManageColumns($columns)
    {
        $title_label = __('Title');
        $date_label = __($columns['date']); /* get data form columns defauld; */

        $columns['title'] = $title_label;
        $columns['img'] = __('照片');
        unset($columns['date']);
        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns)
    {
        if ($columns == 'img') {
            if (has_post_thumbnail()) {
                set_post_thumbnail_size(100, 150);
                the_post_thumbnail();
            }
        }
    }
}
