<?php

class Admin_Supervisor_Controler {

    public function __construct() {
        add_action('init', array($this, 'supervisorCusPost'));
        add_action('manage_edit-supervisor_columns', array($this, 'supervisorManage_cols'));
        add_action('manage_supervisor_posts_custom_column', array($this, 'supervisorRender_cols'));
    }

    public function supervisorCusPost() {
        $labels = array(
            'name' => _x('理監事成員', 'suite'),
            'singular_name' => _x('理監事成員', 'suite'),
            'add_new' => _x('新增理監事成員', 'suite'),
            'add_new_item' => _x('新增成員', 'suite'),
            'edit_item' => _x('修改成員', 'suite'),
            'new_item' => _x('新成員', 'suite'),
            'all_items' => _x('所有理監事成員', 'suite'),
            'view_item' => _x('顯示理監事成員', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No 理監事成員 found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('理監事成員', 'suite')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => WB_URL_ICON_DIR . 'admin16x16.png',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 11,
            'supports' => array('title', 'thumbnail', 'editor'),
        );
        register_post_type('supervisor', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function supervisorManage_cols($columns) {
        $date_label = _x('Create Date', 'suite');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang 
        $columns['image'] = _x('照片', 'suite');
        $columns['order'] = _x('排序', 'suite');
        $columns['date'] = $date_label;

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function supervisorRender_cols($columns) {
        global $post;
        if ($columns == 'image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(80, 80));  // Other resolutions);
                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }

        if ($columns == 'order') {
            echo get_post_meta($post->ID, '_metabox_order_by', true);
        }
        //show product thumb
//    $img = get_post_meta($post->ID, 'm_image', true);
//    if ($columns == 'member_image') {
//        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
//    }
    }

}
