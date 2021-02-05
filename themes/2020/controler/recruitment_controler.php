<?php

class Admin_Recruitment_Controler {

    public function __construct() {
        add_action('init', array($this, 'Create'));
        add_action('manage_edit-member_columns', array($this, 'ManageColumns'));
        add_action('manage_member_posts_custom_column', array($this, 'RenderColumns'));

        add_action('init', array($this, 'CreateTaxonomies'));
    }

    public function Create() {
        $labels = array(
            'name' => __('人才招聘'),
            'singular_name' => __('人才招聘'),
            'add_new' => _x('新增招聘', 'suite'),
            'add_new_item' => _x('新增招聘', 'suite'),
            'new_item' => __('新增招聘'),
            'edit_item' => __('修改招聘'),
            'all_items' => _x('招聘名單', 'suite'),
            'view_item' => __('View'),
            'search_items' => __('Search'),
            'not_found' => __('No Found'),
            'not_found_in_trash' => __('No Found Any Recruitment'),
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

    public function ManageColumns($columns) {

        $date_label = _x('Create Date', 'suite');

        unset($columns['date']); /* an cot ngay mac dinh */
        unset($columns['author']);
        unset($columns['ID']);
        /*  $columns['recruit_postby'] = _x('發布人', 'suite');
          $columns['recruit_category'] = _x('類別', 'suite');
          $columns['recruit_status'] = _x('狀態', 'suite'); */
        $columns['date'] = $date_label;
        return $columns;
    }

    public function RenderColumns($columns) {
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

    public function CreateTaxonomies() {
        $labels = array(
            'name' => _x('分類', 'suite'),
            'singular_name' => _x('分類', 'suite'),
            'search_items' => _x('Search Categories', 'suite'),
            'all_items' => _x('分類', 'suite'),
            'parent_item' => _x('父類', 'suite'),
            'parent_item_colon' => _x('父類', 'suite'),
            'edit_item' => _x('修改分類', 'suite'),
            'update_item' => _x('更新分類', 'suite'),
            'add_new_item' => _x('新增分類', 'suite'),
            'new_item_name' => _x('新增分類名稱', 'suite'),
            'menu_name' => _x('招聘分類', 'suite')
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
