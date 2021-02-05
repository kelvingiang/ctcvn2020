<?php

class Admin_Friend_Link_Controler {

    public function __construct() {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-friend_columns', array($this, 'ManageColumns'));
        add_action('manage_friend_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function Create() {
        $labels = array(
            'name' => __('友誼連接'),
            'singular_name' => __('友誼連接'),
            'add_new' => _x('新增', 'suite'),
            'add_new_item' => _x('新增', 'suite'),
            'new_item' => __('新友誼連接'),
            'edit_item' => __('修改友誼連接'),
            'all_items' => _x('友誼連接名單', 'suite'),
            'view_item' => __('View'),
            'search_items' => __('Search'),
            'not_found' => __('No Found'),
            'not_found_in_trash' => __('No Found Any Friendl link'),
            'parent_item_colon' => '',
            'menu_name' => __('友誼連接'),
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
            'menu_position' => 4,
            'supports' => array('')
        );
        register_post_type('friend', $args);
    }

    public function ManageColumns($columns) {
        $name_label = _x('公 司 名 稱', 'suite');
        //$web_label = _x('Web Link', 'suite');
        $date_label = _x('Create Date', 'suite');

        unset($columns['title']); // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang
        $columns['firend_name'] = $name_label;
        $columns['friend_website'] = _x('網 頁', 'suite');
        $columns['order'] = _x('排序', 'suite');
        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns) {
        global $post;

        if ($columns == 'firend_name') {
            $strFriendName = get_post_meta($post->ID, 'p_name', true);
            echo '<a href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
            echo $strFriendName;
            echo '</a>';
        }

        if ($columns == 'friend_website') {
            $strFriendWeb = get_post_meta($post->ID, 'p_web', true);
            echo '<a href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
            echo $strFriendWeb;
            echo '</a>';
        }

        if ($columns == 'order') {
            echo get_post_meta($post->ID, '_metabox_order_by', true);
        }
    }

}
