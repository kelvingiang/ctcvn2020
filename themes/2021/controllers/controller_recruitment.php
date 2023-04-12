<?php

class Admin_Controller_Recruitment
{

    public function __construct()
    {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-member_columns', array($this, 'ManageColumns'));
        add_action('manage_member_posts_custom_column', array($this, 'RenderColumns'));

        add_action('init', array($this, 'CreateTaxonomies'));
    }

    public function Create()
    {
        $labels = array(
            'name' => __('人才招聘'),
            'singular_name' => __('人才招聘'),
            'add_new' => __('新增'),
            'add_new_item' => __('新增'),
            'new_item' => __('新增'),
            'edit_item' => __('修改'),
            'all_items' => __('全部會長'),
            'view_item' => __('顯示'),
            'search_items' => __('搜尋'),
            'not_found' => __('搜不到任何資料'),
            'not_found_in_trash' => __('回收桶是空.'),
            'parent_item_colon' => '',
            'menu_name' => __('人才招聘'),
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
            'map_meta_cap' => true,
            //     'capabilities' => array(
            //       'create_posts' => 'do_not_allow'), // KHONG CHO PHEP TAO POST MOI, AN CAI ADD NEW POST DI .
            'menu_position' => 7,
            'supports' => array('thumbnail', 'title', 'author')
        );
        register_post_type('recruitment', $args);
    }

    public function ManageColumns($columns)
    {

        $date_label = __('Create Date');

        unset($columns['date']); /* an cot ngay mac dinh */
        unset($columns['author']);
        unset($columns['ID']);
        /*  $columns['recruit_postby'] = __('發布人');
          $columns['recruit_category'] = __('類別');
          $columns['recruit_status'] = __('狀態'); */
        $columns['date'] = $date_label;
        return $columns;
    }

    public function RenderColumns($columns)
    {
        global $post;
        $group = get_post_meta($post->ID, 'r_birthday', true);

        if ($columns == 'recruit_postby') {
            $strPostby = get_post_meta($post->ID, 'r_postby', true);
            echo $strPostby === '' ? 'Admin' : $strPostby;
        }

        if ($columns == 'recruit_category') {
            $terms = wp_get_post_terms($post->ID, 'recruitment_category');
            if (count($terms) > 0) {
                $parent = array();
                foreach ($terms as $key => $term) {
                    if ($term->parent == 0) {
                        $parent[] = $term;
                        unset($terms[$key]);
                    }
                }

                foreach ($parent as $key => &$item) {
                    foreach ($terms as $i => $term) {
                        if ($term->parent == $item->term_id) {
                            $item->childs[] = $term;
                        }
                    }
                }

                $arrShowCat = array();
                foreach ($parent as $p => $val) {
                    $strShowCat = $val->name;
                    $strShowSlug = $val->slug;
                    $strShowTaxonomy = $val->taxonomy;

                    if (count($val->childs) > 0) {
                        foreach ($val->childs as $child) {
                            $strShowCat = $strShowCat . '/' . $child->name;
                            //   $arrShowCat[] = $strShowCat;
                            $arrShowCat[] = array('cat' => $strShowCat, 'slug' => $child->slug, 'taxonomy' => $strShowTaxonomy);
                            // $strShowCat = $val->name;
                        }
                    } else {
                        // $arrShowCat[] = $strShowCat;
                        $arrShowCat[] = array('cat' => $strShowCat, 'slug' => $strShowSlug, 'taxonomy' => $strShowTaxonomy);
                    }
                }

                foreach ($arrShowCat as $cat) {
                    // echo $cat . '<br>';
                    echo '<a href=' . custom_redirect($cat['slug']) . '&' . $cat['taxonomy'] . '=' . $cat['slug'] . '>' . $cat['cat'] . '</a></br>';
                }
            }
        }

        if ($columns == 'recruit_status') {
            $status = get_post_meta($post->ID, '_recruit_status', true);

            if ($status == 'on') {
                $class = 'num num-active';
            } else {
                $class = 'num num-inactive';
            }
            echo '<span class="' . $class . '"></span>';
        }
    }

    public function CreateTaxonomies()
    {
        $labels = array(
            'name' => __('分類'),
            'singular_name' => __('分類'),
            'search_items' => __('Search Categories'),
            'all_items' => __('分類'),
            'parent_item' => __('父類'),
            'parent_item_colon' => __('父類'),
            'edit_item' => __('修改'),
            'update_item' => __('更新'),
            'add_new_item' => __('新增分類'),
            'new_item_name' => __('新增'),
            'menu_name' => __('分類')
        );
        register_taxonomy('recruitment_category', 'recruitment', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'taxonomy' => 'category',
            'rewrite' => array(
                'slug' => 'recruitment-category',
                'hierarchical' => true,
            )
        ));
    }
}
