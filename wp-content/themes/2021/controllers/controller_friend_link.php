<?php

class Admin_Controller_Friend_Link
{

    public function __construct()
    {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-friend_columns', array($this, 'ManageColumns'));
        add_action('manage_friend_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function Create()
    {
        $labels = array(
            'name' => __('友誼連接'),
            'singular_name' => __('友誼連接'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'new_item' => __('新增'),
            'edit_item' => __('修改'),
            'all_items' => __('全部友誼連接'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
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

    public function ManageColumns($columns)
    {
        $name_label = __('公司名稱');
        //$web_label = __('Web Link');
        $date_label = __('日期');

        unset($columns['title']); // cho an cot title mac dinh;
        unset($columns['date']); // an cot ngay mac dinh
        // them cot vao bang
        $columns['name'] = $name_label;
        $columns['website'] = __('網頁');
        $columns['order'] = __('排序');
        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns)
    {
        global $post;

        if ($columns == 'name') {
            $strFriendName = get_post_meta($post->ID, 'p_name', true);
            echo '<a href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
            echo $strFriendName;
            echo '</a>';
        }

        if ($columns == 'website') {
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
