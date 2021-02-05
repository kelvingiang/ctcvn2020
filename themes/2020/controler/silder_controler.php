<?php

class Admin_Silder_Controler {

    public function __construct() {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-slide_columns', array($this, 'ManageColumns'));
        add_action('manage_slide_posts_custom_column', array($this, 'RenderColumns'));
    }

    function create() {
        $labels = array(
            'name' => _x('幻燈片', 'suite'),
            'singular_name' => _x('幻燈片', 'suite'),
            'add_new' => _x('新增幻燈片', 'suite'),
            'add_new_item' => _x('新增幻燈片', 'suite'),
            'edit_item' => _x('修改幻燈片', 'suite'),
            'new_item' => _x('新增幻燈片', 'suite'),
            'all_items' => _x('幻燈片名單', 'suite'),
            'view_item' => _x('View Slide', 'suite'),
            'search_items' => _x('Search Slides', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No slides found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('幻燈片 994x300 ', 'suite')
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

    public function ManageColumns($columns) {
        $title_label = _x('Title', 'suite');
        $date_label = _x($columns['date'], 'suite'); /* get data form columns defauld; */

        $columns['title'] = $title_label;
        $columns['slide_img'] = _x('Thumbnail', 'suite');
        unset($columns['date']);
        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns) {
        if ($columns == 'slide_img') {
            if (has_post_thumbnail()) {
                /*   set_post_thumbnail_size(100,100); */
                the_post_thumbnail(array(50, 50));
            }
        }
    }

}
