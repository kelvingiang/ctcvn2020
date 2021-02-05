<?php

class Admin_Member_controler {

    public function __construct() {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-member_columns', array($this, 'ManageColumns'));
        add_action('manage_member_posts_custom_column', array($this, 'RenderColumns'));

        add_filter('manage_edit-member_sortable_columns', array($this, 'SortColumn'));
        add_filter('request', array($this, 'sort_views_column'));
    }

    public function create() {
        $labels = array(
            'name' => __('會員'),
            'singular_name' => __('會員'),
            'add_new' => _x('新增會員', 'suite'),
            'add_new_item' => _x('新增會員', 'suite'),
            'new_item' => __('新增會員'),
            'edit_item' => __('修改會員資料'),
            'all_items' => _x('會員名單', 'suite'),
            'view_item' => __('View'),
            'search_items' => __('Search'),
            'not_found' => __('No Found'),
            'not_found_in_trash' => __('No Found Any Member'),
            'parent_item_colon' => '',
            'menu_name' => __('會員'),
        );
        /*  'capabilities' => array(
          'create_posts' => 'do_not_allow'),  // KHONG CHO PHEP TAO POST MOI
          'map_meta_cap' => true,
         */

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
            'map_meta_cap' => true,
            /*       'capabilities' => array(
              //        'create_posts' => 'do_not_allow'), // KHONG CHO PHEP TAO POST MOI, AN CAI ADD NEW POST DI . */
            'menu_position' => 6,
            'supports' => array('thumbnail')
        );
        register_post_type('Member', $args);
    }

    public function ManageColumns($columns) {
        $date_label = _x('Create Date', 'suite');

        unset($columns['title']); /* cho an cot title mac dinh; */
        unset($columns['date']); /* an cot ngay mac dinh */
        /*  them cot vao bang  */
        $columns['member_user'] = _x('帳號', 'suite');
        $columns['member_image'] = _x('照片', 'suite');
        $columns['member_fullname'] = _x('姓名', 'suite');
        $columns['member_country'] = _x('會員編號', 'suite');
        $columns['member_style'] = _x('會員', 'suite');
        $columns['member_email'] = _x('Email', 'suite');
        $columns['member_phone'] = _x('電話', 'suite');
        $columns['member_status'] = _x('狀態', 'suite');

        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns) {
        global $post;
        $img = get_post_meta($post->ID, 'm_image', true);
        if ($columns == 'member_image') {
            echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . get_image('avata/' . $img) . '">';
        }

        if ($columns == 'member_style') {

            if (get_post_meta($post->ID, 'm_member', true) == "recruit") {
                $member = "招募";
            } elseif (get_post_meta($post->ID, 'm_member', true) == 'apply') {
                $member = "應徵";
            }
            echo '<p>' . $member . '</p>';
        }

        if ($columns == 'member_user') {
            $strMemberUser = get_post_meta($post->ID, 'm_user', true);

            echo '<a href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
            echo $strMemberUser;
            echo '</a>';
        }

        if ($columns == 'member_country') {
            echo '<p>';
            echo '<a href=" ' . admin_url('/edit.php?post_type=member&s=' . get_post_meta($post->ID, 'm_country', true)) . ' ">' . get_country(get_post_meta($post->ID, 'm_country', true)) . '</a>';
            echo '</p>';
        }

        if ($columns == 'member_fullname') {
            echo '<p>';
            echo get_post_meta($post->ID, 'm_fullname', true);
            echo '</p>';
        }

        if ($columns == 'member_email') {
            echo '<p>';
            echo get_post_meta($post->ID, 'm_email', true);
            echo '</p>';
        }

        if ($columns == 'member_phone') {
            echo '<p>';
            echo get_post_meta($post->ID, 'm_phone', true);
            echo '</p>';
        }

        if ($columns == 'member_status') {
            $status = get_post_meta($post->ID, 'm_active', true);

            if ($status == 'on') {
                $class = 'status-active';

            } else {
                $class = 'status-inactive';

            }
            echo '<div class="' . $class . '"></div>';
        }
    }

    public function SortColumn($column) {
        $column['member_country'] = 'setorder';
        $column['member_status'] = 'status';
        return $column;
    }

    public function sort_views_column($vars) {
        if (isset($vars['orderby']) && 'setorder' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => 'm_country',
                'orderby' => 'm_country',
            ));
        } elseif (isset($vars['orderby']) && 'status' == $vars['orderby']) {
            $vars = array_merge($vars, array(
                'meta_key' => 'm_active',
                'orderby' => 'm_active',
            ));
        }

        return $vars;
    }

}
