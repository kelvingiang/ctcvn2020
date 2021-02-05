<?php

class Admin_Event_Controler {

    public function __construct() {
        add_action('init', array($this, 'create'));
        add_action('manage_edit-event_columns', array($this, 'ManageColumns'));
        add_action('manage_event_posts_custom_column', array($this, 'RenderColumns'));
    }

    public function create() {
        $labels = array(
            'name' => _x('商會活動', 'suite'),
            'singular_name' => _x('商會活動', 'suite'),
            'add_new' => _x('新增活動', 'suite'),
            'add_new_item' => _x('新增活動', 'suite'),
            'edit_item' => _x('修改活動', 'suite'),
            'new_item' => _x('New event', 'suite'),
            'all_items' => _x('所有活動', 'suite'),
            'view_item' => _x('View Post', 'suite'),
            'search_items' => _x('Search Post', 'suite'),
            'not_found' => _x('No slides found.', 'suite'),
            'not_found_in_trash' => _x('No Forum found in Trash.', 'suite'),
            'parent_item_colon' => '',
            'menu_name' => _x('商會活動', 'suite')
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

    public function ManageColumns($column) {

        unset($column['date']); /* an cot ngay mac dinh */
        $column['cb'] = '<input type="checkbox" />';

        $column['content'] = __('內容', 'suite');
        $column['show'] = __('首貢顯示');
        $column['join'] = __('參加活動');
        $column['start-date'] = __('開始日期', 'suite');
        $column['end-date'] = __('結束日期', 'suite');
        $column['date'] = '';
        return $column;
    }

    public function RenderColumns($columns) {
        global $post;
        switch ($columns) {

            case 'titles' :
                echo '<a class="admin-link" href="' . get_admin_url() . 'post.php?post=' . $post->ID . '&action=edit">';
                the_title();
                '</a>';
                break;

            case 'content' :
                the_content_feed();
                break;

            case 'show' :
                $status = get_post_meta($post->ID, 'e_show', true);
                if ($status == 'on') {
                    $class = 'num num-active';
                } else {
                    $class = 'num num-inactive';
                }
                echo '<span class="' . $class . '"></span>';
                break;

            case 'join' :
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
                echo '<span class="' . $class . '">' . $startDate . '</span>';
                break;

            case 'end-date' :
                $endDate = get_post_meta($post->ID, 'e_end_date', TRUE);
                echo '<span class="' . $class . '">' . $endDate . '</span>';
                break;

            default :
                break;
        }
    }

}
