<?php

class Admin_Controller_Event
{

    public function __construct()
    {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-event_columns', array($this, 'ManageColumns'));
        add_action('manage_event_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function Create()
    {
        $labels = array(
            'name' => __('商會活動'),
            'singular_name' => __('商會活動'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'edit_item' => __('修改'),
            'new_item' => __('新增'),
            'all_items' => __('全部活動'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
            'parent_item_colon' => '',
            'menu_name' => __('商會活動')
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
            'menu_position' => 2,
            'supports' => array('title', 'thumbnail', 'editor'),
        );
        register_post_type('event', $args);
        flush_rewrite_rules(); // chuyen den trang single cua custom post
    }

    public function ManageColumns($column)
    {

        unset($column['date']); /* an cot ngay mac dinh */
        $column['cb'] = '<input type="checkbox" />';

        //$column['content'] = __('內容');
        $column['show'] = __('首貢');
        // $column['join'] = __('參加活動');
        $column['start-date'] = __('開始日期');
        $column['end-date'] = __('結束日期');
        $column['date'] = '';
        return $column;
    }

    public function RenderColumns($columns)
    {
        global $post;
        switch ($columns) {

            case 'titles':
                echo '<a class="admin-link" href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
                the_title();
                '</a>';
                break;

            case 'content':
                the_content_feed();
                break;

            case 'show':
                $status = get_post_meta($post->ID, 'e_show', true);
                if ($status == 'on') {
                    $class = 'num num-active';
                } else {
                    $class = 'num num-inactive';
                }
                echo '<span class="' . $class . '"></span>';
                break;

            case 'join':
                $status = get_post_meta($post->ID, 'e_join', true);
                if ($status == 'on') {
                    $class = 'num num-active';
                } else {
                    $class = 'num num-inactive';
                }
                echo '<span class="' . $class . '"></span>';
                break;

            case 'start-date':
                $startDate = get_post_meta($post->ID, 'e_start_date', TRUE);
                echo '<span>' . $startDate . '</span>';
                break;

            case 'end-date':
                $endDate = get_post_meta($post->ID, 'e_end_date', TRUE);
                echo '<span>' . $endDate . '</span>';
                break;

            default:
                break;
        }
    }
}
