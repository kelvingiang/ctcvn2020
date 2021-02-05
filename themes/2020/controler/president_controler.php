<?php

class Admin_President_Controler {

    public function __construct() {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-president_columns', array($this, 'ManageColumns'));
        add_action('manage_president_posts_custom_column', array($this, 'RenderColumns'));

        add_filter('manage_edit-president_sortable_columns', array($this, 'SortColumn'));
        add_filter('request', array($this, 'sort_views_column'));
    }

    public function create() {
        $labels = array(
            'name' => _x('會長', 'suite'),
            'singular_name' => _x('會長', 'suite'),
            'add_new' => _x('新增會長', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'edit_item' => _x('修改', 'suite'),
            'new_item' => _x('新增', 'suite'),
            'all_items' => _x('所有會長', 'suite'),
            'view_item' => _x('顯示會長', 'suite'),
            'search_items' => _x('查询', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No 會長 found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('歷屆會長', 'suite')
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
            'supports' => array('title', 'thumbnail'),
        );
        register_post_type('president', $args);
    }

    // tao function thay doi hien thi mac dinh
    public function ManageColumns($columns) {

        $date_label = _x('Create Date', 'suite');

        $columns['title']; // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        //$columns['content'] = _x('職稱','suite');
        // them cot vao bang 
        $columns['president_image'] = _x('照片', 'suite');
        $columns['president_branch'] = _x('商會', 'suite');
        $columns['president_term'] = _x('屆期', 'suite');
        $columns['president_year'] = _x('年度', 'suite');
        $columns['date'] = $date_label;

        return $columns;
    }

// function dua noi dung vao cac cot moi  tạo
    public function RenderColumns($columns) {

        global $post;
        if ($columns == 'president_image') {
            if (has_post_thumbnail()) {
                the_post_thumbnail(array(80, 80));  // Other resolutions);
                //  set_post_thumbnail_size(50, 50); // 50 pixels wide by 50 pixels tall, resize mode
            }
        }
        if ($columns == 'president_branch') {
            echo get_country(get_post_meta($post->ID, "_president_branch", TRUE));
        }

        if ($columns == 'president_term') {
            echo get_post_meta($post->ID, "_president_term", true);
        }

        if ($columns == 'president_year') {
            echo get_post_meta($post->ID, "_president_year", true);
        }
        //show product thumb
//    $img = get_post_meta($post->ID, 'm_image', true);
//    if ($columns == 'member_image') {
//        echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
//    }
    }

    public function SortColumn($newcolumn) {

        $newcolumn['president_branch'] = 'president_branch';
        return $newcolumn;
    }

    public function sort_views_column($vars) {
//        die('uuuu');
        if (isset($vars['orderby']) && 'president_branch' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => '_president_branch', //Custom field key
                'orderby' => '_president_branch' //Custom field value (number)
                    )
            );
        }

        return $vars;
    }

}
