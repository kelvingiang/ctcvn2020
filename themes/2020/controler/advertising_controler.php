<?php

class Admin_Advertising_Controler {

    public function __construct() {
        add_action('init', array($this, 'advertisingCusPost'));
        add_action('manage_edit-advertising_columns', array($this, 'advertisingManage_cols'));
        add_action('manage_advertising_posts_custom_column', array($this, 'advertisingRender_cols'));
    }

    public function advertisingCusPost() {
        $labels = array(
            'name' => _x('贊助商成員', 'suite'),
            'singular_name' => _x('贊助商成員', 'suite'),
            'add_new' => _x('新增贊助商成員', 'suite'),
            'add_new_item' => _x('新增成員', 'suite'),
            'edit_item' => _x('修改成員', 'suite'),
            'new_item' => _x('新成員', 'suite'),
            'all_items' => _x('所有贊助商成員', 'suite'),
            'view_item' => _x('顯示贊助商成員', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No 贊助商成員 found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('贊助商成員', 'suite')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => WB_URL_ICON_DIR . 'ad16x16.png',
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 12,
            'supports' => array('title', 'thumbnail', 'editor'),
        );
        register_post_type('advertising', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function advertisingManage_cols($columns) {
        $date_label = _x('Create Date', 'suite');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang 
        $columns['logo_image'] = _x('照片', 'suite');
        $columns['email_col'] = _x('網站', 'suite');
        $columns['date'] = $date_label;

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function advertisingRender_cols($columns) {
            global $post;
        if ($columns == 'logo_image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(80, 80));  // Other resolutions);
                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }
        
        if ($columns == 'email_col') {
            echo get_post_meta($post->ID, '_tw_metabox_email', TRUE);
        }
        //show product thumb
//    $img = get_post_meta($post->ID, 'm_image', true);
//    if ($columns == 'member_image') {
//        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
//    }
    }

}
