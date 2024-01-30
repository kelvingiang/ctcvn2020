<?php

class Admin_Metabox_Friend_link {

    public function __construct() {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create() {
        global $post;
        $id = 'friend-meta-box';
        $title = '友誼連接';
        $callback = array($this, 'display');
        $screen = array('friend'); // CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI
        add_meta_box($id, $title, $callback, $screen, 'normal', 'high');
    }

    public function display($post) {
        global $suite;
        /* $editor_settings = Common::$_wpeditor; */
        $p_name = get_post_meta($post->ID, 'p_name', true);
        $p_web = get_post_meta($post->ID, 'p_web', true);
        ?>
        <div class="row-one-clo">
            <div class="cell-one"> <label for="p_name" class="label-admin"><?php _e('公司名稱', 'suite'); ?></label></div>
            <div class="cell-two"> <input type="text" name="p_name"  id="p_name"  class="txt-pro-name" value="<?php echo $p_name ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one">  <label for="p_web" class="label-admin"><?php _e('連接網頁', 'suite'); ?></label></div>
            <div class="cell-two"> <input type="text" name="p_web" id="p_web"  class="txt-pro-name" value="<?php echo $p_web ?>" /></div>
        </div>
        <?php
    }

    public function save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (is_admin()) {
            if (@$_POST['post_type'] == 'friend') {
                if (isset($_POST['p_name'])) {
                    update_post_meta($post_id, 'p_name', esc_attr($_POST['p_name']));
                }

                if (isset($_POST['p_web'])) {
                    update_post_meta($post_id, 'p_web', esc_attr($_POST['p_web']));
                }
            }
        }
        /*TO BACK */
        add_action('redirect_post_location', 'custom_redirect');
    }

}
