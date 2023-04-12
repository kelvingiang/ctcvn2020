<?php

class Admin_controller_Member
{

    public function __construct()
    {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-member_columns', array($this, 'ManageColumns'));
        add_action('manage_member_posts_custom_column', array($this, 'RenderColumns'));

        add_filter('manage_edit-member_sortable_columns', array($this, 'SortColumn'));
        add_filter('request', array($this, 'sort_views_column'));
    }

    public function Create()
    {
        $labels = array(
            'name' => __('會員'),
            'singular_name' => __('會員'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'new_item' => __('新增'),
            'edit_item' => __('修改'),
            'all_items' => __('全部會員'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
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

    public function ManageColumns($columns)
    {
        $date_label = __('Create Date');

        unset($columns['title']); /* cho an cot title mac dinh; */
        unset($columns['date']); /* an cot ngay mac dinh */
        /*  them cot vao bang  */
        $columns['title'] = __('帳號');
        //$columns['member_user'] = __('帳號');
        // $columns['member_image'] = __('照片');
        $columns['member_full_name'] = __('姓名');
        $columns['member_country'] = __('會員編號');
        $columns['member_style'] = __('會員');
        $columns['member_email'] = __('Email');
        //$columns['member_phone'] = __('電話');
        $columns['member_status'] = __('狀態');

        $columns['date'] = $date_label;

        return $columns;
    }

    public function RenderColumns($columns)
    {
        global $post;
        $img = get_post_meta($post->ID, 'm_image', true);
        if ($columns == 'member_image') {
            echo '<img  style="width:30px; height: 30px; border-radius: 3px; border: 1px #999 solid" class="attachment-post-thumbnail wp-post-image" src="' . PART_IMAGES_AVATAR . $img . '">';
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

        if ($columns == 'member_full_name') {

            echo get_post_meta($post->ID, 'm_fullname', true);
        }

        if ($columns == 'member_email') {

            echo get_post_meta($post->ID, 'm_email', true);
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

    public function SortColumn($column)
    {
        $column['member_country'] = 'setorder';
        $column['member_status'] = 'status';
        return $column;
    }

    public function sort_views_column($vars)
    {
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
