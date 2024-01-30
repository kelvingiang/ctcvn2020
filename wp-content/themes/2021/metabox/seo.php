<?php

class Admin_Metabox_Seo {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        global $post;
        $id = 'seo-meta-box';
        $title = 'SEO Information';
        $callback = array($this, 'display');
        $screen = array('orders', 'friend', 'post'); // CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI
        add_meta_box($id, $title, $callback, $screen, 'normal', 'high');
    }

    public function display($post) {

        $custom = get_post_custom($post->ID);

        if (isset($custom['seo_title'][0])) {
            $seo_title = $custom['seo_title'][0];
        }
        if (isset($custom['seo_description'][0])) {
            $seo_description = $custom['seo_description'][0];
        }
        if (isset($custom['seo_keywords'][0])) {
            $seo_keywords = $custom['seo_keywords'][0];
        }
        wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');


        if (!empty($seo_title)) {
            $seo_title_val = $seo_title;
        }
        if (!empty($seo_keywords)) {
            $seo_keywords_val = $seo_keywords;
        }
        if (!empty($seo_description)) {
            $seo_description_val = $seo_description;
        }
        ?>
        <div class="row-one-clo">
            <div class="cell-one"><label for="seo_title" class="label-admin"><?php _e('Title SEO') ?></label></div>
            <div class="cell-two"><input type="text" id="seo_title" name="seo_title" value="<?php echo $seo_title_val ?>"/></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="seo_description" class="label-admin"><?php _e('Description SEO') ?></label></div>
            <div class="cell-two"><textarea id="seo_description" name="seo_description" style="display: block; width: 100%"><?php echo $seo_description_val; ?></textarea></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label  for="seo_keywords" class="label-admin"><?php _e('Keywords SEO') ?></label></div>
            <div class="cell-two"><textarea id="seo_keywords" name="seo_keywords" style="display: block; width: 100%"><?php echo $seo_keywords_val; ?></textarea></div>
        </div>
        <?php
    }

    public function save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['seo_title'])) {
            update_post_meta($post_id, 'seo_title', $_POST['seo_title']);
        }

        if (isset($_POST['seo_description'])) {
            update_post_meta($post_id, 'seo_description', $_POST['seo_description']);
        }

        if (isset($_POST['seo_keywords'])) {
            update_post_meta($post_id, 'seo_keywords', $_POST['seo_keywords']);
        }
    }

}
