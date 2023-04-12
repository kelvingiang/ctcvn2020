<?php

class Admin_Controller_Supervisor
{

    public function __construct()
    {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-supervisor_columns', array($this, 'ManageColumns'));
        add_action('manage_supervisor_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function Create()
    {
        $labels = array(
            'name' => __('理監事'),
            'singular_name' => __('理監事'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'edit_item' => __('修改'),
            'new_item' => __('新增'),
            'all_items' => __('全部理監事'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
            'parent_item_colon' => '',
            'menu_name' => __('理監事')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => PART_ICON . 'admin16x16.png',
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
    public function ManageColumns($columns)
    {
        $date_label = __('Create Date');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang 
        $columns['image'] = __('照片');
        $columns['order'] = __('排序');
        $columns['date'] = $date_label;

        return $columns;
    }

    // function dua noi dung vao cac cot moi  tạo
    public function RenderColumns($columns)
    {
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
        //        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . PART_IMAGES_AVATA . $img . '">';
        //    }
    }
}
