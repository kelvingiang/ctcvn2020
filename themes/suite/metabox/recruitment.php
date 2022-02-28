<?php

class Admin_Metabox_Recruitment
{

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create()
    {
        global $post;
        $id = 'recruitment-meta-box';
        $title = __('recruit', 'suite');
        $callback = array($this, 'display');
        $screen = array('recruitment'); /* CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI */
        add_meta_box($id, $title, $callback, $screen, 'normal', 'high');
    }

    public function display($post)
    {
        $terms = get_the_terms($post->ID, array('recruitment_category'));

        foreach ($terms as $ss) {
            $term = $ss->slug;
        }
        if ($term == "ungtuyen") {
            $u_status = get_post_meta($post->ID, '_recruit_status', true);
            $u_fullname = get_post_meta($post->ID, '_recruit_fullname', true);
            $u_birthday = get_post_meta($post->ID, '_recruit_birthday', true);
            $u_sex = get_post_meta($post->ID, '_recruit_sex', true);
            $u_address = get_post_meta($post->ID, '_recruit_address', true);
            $u_email = get_post_meta($post->ID, '_recruit_email', true);
            $u_phone = get_post_meta($post->ID, '_recruit_phone', true);
            $u_level = get_post_meta($post->ID, '_recruit_level', true);
            $u_experience = get_post_meta($post->ID, '_recruit_experience', true);
            $u_another = get_post_meta($post->ID, '_recruit_another', true);
        } elseif ($term == "dangtuyen") {
            $d_status = get_post_meta($post->ID, '_recruit_status', true);
            $d_company_tw = get_post_meta($post->ID, '_recruit_company_tw', true);
            $d_company_en = get_post_meta($post->ID, '_recruit_company_en', true);
            $d_company_vn = get_post_meta($post->ID, '_recruit_company_vn', true);
            $d_address = get_post_meta($post->ID, '_recruit_address', true);
            $d_email = get_post_meta($post->ID, '_recruit_email', true);
            $d_phone = get_post_meta($post->ID, '_recruit_phone', true);
            $d_count = get_post_meta($post->ID, '_recruit_count', true);
            $d_summary = get_post_meta($post->ID, '_recruit_summary', true);
            $d_lack_job = get_post_meta($post->ID, '_recruit_lack_job', true);
            $d_lack_count = get_post_meta($post->ID, '_recruit_lack_count', true);
            $d_sex = get_post_meta($post->ID, '_recruit_sex', true);
            $d_date_from = get_post_meta($post->ID, '_recruit_date_from', true);
            $d_date_to = get_post_meta($post->ID, '_recruit_date_to', true);
            $d_level = get_post_meta($post->ID, '_recruit_level', true);
            $d_experience = get_post_meta($post->ID, '_recruit_experience', true);
            $d_age_from = get_post_meta($post->ID, '_recruit_age_from', true);
            $d_age_to = get_post_meta($post->ID, '_recruit_age_to', true);
            $d_language = get_post_meta($post->ID, '_recruit_language', true);
            $d_work_space = get_post_meta($post->ID, '_recruit_work_space', true);
            $d_salary = get_post_meta($post->ID, '_recruit_salary', true);
            $d_orther = get_post_meta($post->ID, '_recruit_orther', true);
            $d_contact_name = get_post_meta($post->ID, '_recruit_contact_name', true);
            $d_contact_phone = get_post_meta($post->ID, '_recruit_contact_phone', true);
            $d_contact_email = get_post_meta($post->ID, '_recruit_contact_email', true);
        }

        require_once DIR_CODES . 'common.php';
        $editor_settings = Common::$_wpeditor;
        /* get cac thong tin khi sp co san (cho phan chinh sua update)
          //  $r_postbby = get_post_meta($post->ID, 'r_postby',true); */
?>
<?php
        if ($term == "ungtuyen") {
        ?>
<div id="ungtuyen_spase">
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Active', 'suite'); ?></label></div>
        <div class="cell-two"><input style="margin-top: 6px" type="checkbox" name="d_status" id="u_status"
                <?php echo $u_status == 'on' ? 'checked' : '' ?> /></div>
    </div>
    <div class="row-one-clo">
        <div class="cell-one">
            <label class="label-admin" style="font-weight: bold"><?php _e('Full Name', 'suite'); ?></label><br />
        </div>
        <div class="cell-two">
            <input type="text" name="u_fullname" id="u_fullname" readonly value="<?php echo $u_fullname ?>">
        </div>
    </div>
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Brith of date', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_birthday" id="u_birthday" readonly
                value="<?php echo $u_birthday ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin" style="font-weight: bold"><?php _e('Sex', 'suite'); ?> </label>
        </div>
        <div class="cell-two"> <?php echo $u_sex == '1' ? _e('Male', 'suite') : _e('Female', 'suite'); ?></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"> <label class="label-admin"
                style="font-weight: bold"><?php _e('Address', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_address" id="u_adress" value="<?php echo $u_address ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Email', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_email" id="u_email" value="<?php echo $u_email ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"> <label class="label-admin"
                style="font-weight: bold"><?php _e('Phone', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_phone" id="u_phone" value="<?php echo $u_phone ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Level', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_level" id="u_level" value="<?php echo $u_level ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Experiences', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="u_experience" id="u_experience"
                value="<?php echo $u_experience ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label for="r_experience" class="label-admin"
                style="font-weight: bold"><?php _e('Another', 'suite'); ?></label></div>
        <div class="cell-two">
            <?php wp_editor($u_another, 'u_another', array('wpautop' => TRUE, 'editor_height' => '350px')); ?></div>
    </div>

</div>
<?php } elseif ($term == "dangtuyen") { ?>
<div id="dangtuyen_space">
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold; font-size: 20px"><?php _e('Active', 'suite'); ?></label></div>
        <div class="cell-two"><input style="margin-top: 6px" type="checkbox" name="d_status" id="d_status"
                <?php echo $d_status == 'on' ? 'checked' : '' ?> /></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Company TW', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_company_tw" id="d_company_tw"
                value="<?php echo $d_company_tw ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Company EN', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_company_en" id="d_company_en"
                value="<?php echo $d_company_en ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"> <label class="label-admin"
                style="font-weight: bold"><?php _e('Company VN', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_company_vn" id="d_company_vn"
                value="<?php echo $d_company_vn ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Address', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_address" id="d_address" value="<?php echo $d_address ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Phone', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_phone" id="d_phone" value="<?php echo $d_phone ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Email', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_email" id="d_email" value="<?php echo $d_email ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('number of employees of the company', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_count" id="d_count" value="<?php echo $d_count ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Summary', 'suite'); ?></label></div>
        <div class="cell-two"><?php wp_editor($d_summary, 'd_summary', $editor_settings); ?></div>
    </div>

    <hr>
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('人事聯絡', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_contact_name" id="d_contact_name"
                value="<?php echo $d_contact_name ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('人事聯絡電話', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_contact_phone" id="d_contact_phone"
                value="<?php echo $d_contact_phone ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('人事聯絡電郵', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_contact_email" id="d_contact_email"
                value="<?php echo $d_contact_email ?>"></div>
    </div>

    <div style="height:20px;">
        <hr style="border: 2px solid  #005082">
    </div>


    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('職缺名稱', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_lack_job" id="d_lack_job" value="<?php echo $d_lack_job ?>">
        </div>
    </div>
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('職缺人數', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" name="d_lack_count" id="d_lack_count"
                value="<?php echo $d_lack_count ?>"></div>
    </div>
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Sex', 'suite'); ?></label></div>
        <div class="cell-two">
            <select id="sel_sex" name="sel_sex" style="width: 180px">
                <option value="3" <?php echo $d_sex == 3 ? 'selected="selected"' : '' ?>>
                    <?php _e('Male/Female', 'suite'); ?></option>
                <option value="1" <?php echo $d_sex == 1 ? 'selected="selected"' : '' ?>><?php _e('Male', 'suite'); ?>
                </option>
                <option value="2" <?php echo $d_sex == 2 ? 'selected="selected"' : '' ?>><?php _e('Female', 'suite'); ?>
                </option>
            </select>
        </div>
    </div>

    <div class="row-four-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('有效日期', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="MyDate" maxlength="10" name="d_date_from" id="d_date_from"
                value="<?php echo $d_date_from ?>"> </div>
        <div class="cell-three"><label class="label-admin"><?php _e('To', 'suite'); ?></label></div>
        <div class="cell-four"><input type="text" class="MyDate" maxlength="10" name="d_date_to" id="d_date_to"
                value="<?php echo $d_date_to ?>"> </div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Level', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="form-control" name="d_level" id="d_level"
                value="<?php echo $d_level ?>"></div>
    </div>
    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Experiences', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="form-control" name="d_experience" id="d_experience"
                value="<?php echo $d_experience ?>"></div>
    </div>

    <div class="row-four-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Age', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="type-number" maxlength="2" name="d_age_from" id="d_age_from"
                value="<?php echo $d_age_from ?>"></div>
        <div class="cell-three"><label class="label-admin"><?php _e('To', 'suite'); ?></label></div>
        <div class="cell-four"><input type="text" class="type-number " maxlength="2" name="d_age_to" id="d_age_to"
                value="<?php echo $d_age_to ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Foreign Languages', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="form-control" name="d_language" id="d_language"
                value="<?php echo $d_language ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"><?php _e('Work Space', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="form-control" name="d_work_space" id="d_work_space"
                value="<?php echo $d_work_space ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"> <label class="label-admin"><?php _e('Salary', 'suite'); ?></label></div>
        <div class="cell-two"><input type="text" class="form-control" name="d_salary" id="d_salary"
                value="<?php echo $d_salary ?>"></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one"><label class="label-admin"
                style="font-weight: bold"><?php _e('Another', 'suite'); ?></label></div>
        <div class="cell-two">
            <?php wp_editor($d_orther, 'd_orther', array('wpautop' => TRUE, 'editor_height' => '350px')); ?></div>
    </div>

</div>

<?php } ?>

<!-- =================================================================== -->

<div style="clear: both; height: 20px"></div>


<script type="text/javascript">
jQuery(document).ready(function() {
    var action = '<?php echo $_GET['action'] ?>';
    var g = '<?php echo $_GET['g'] ?>';
    if (action !== '' & g === '') {
        $('#li-ungtuyen').removeClass('current');
        $('#li-dangtuyen').addClass('current');
        $('#tap-ungtuyen').removeClass('content-current');
        $('#tap-dangtuyen').addClass('content-current');
    }

});
</script>
<?php
    }

    public function save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (is_admin()) {
            if (@$_POST['post_type'] == 'recruitment') {
                // phan ung tuyen
                if (isset($_POST['u_status'])) {
                    update_post_meta($post_id, '_recruit_status', $_POST['u_status']);
                } else {
                    update_post_meta($post_id, '_recruit_status', '');
                }

                if (isset($_POST['u_address'])) {
                    update_post_meta($post_id, '_recruit_address', esc_attr($_POST['u_address']));
                }
                if (isset($_POST['u_email'])) {
                    update_post_meta($post_id, '_recruit_email', esc_attr($_POST['u_email']));
                }
                if (isset($_POST['u_phone'])) {
                    update_post_meta($post_id, '_recruit_phone', esc_attr($_POST['u_phone']));
                }
                if (isset($_POST['u_level'])) {
                    update_post_meta($post_id, '_recruit_level', esc_attr($_POST['u_level']));
                }
                if (isset($_POST['u_experience'])) {
                    update_post_meta($post_id, '_recruit_experience', esc_attr($_POST['u_experience']));
                }
                if (isset($_POST['u_another'])) {
                    update_post_meta($post_id, '_recruit_another', $_POST['u_another']);
                }

                //========= PHAN DANG TUYEN ======
                //            echo '<pre>';
                //            print_r($_POST);
                //            echo '</pre>';
                //            die();
                if (isset($_POST['d_status'])) {
                    update_post_meta($post_id, '_recruit_status', $_POST['d_status']);
                } else {
                    update_post_meta($post_id, '_recruit_status', '');
                };

                if (isset($_POST['d_company_tw'])) {
                    update_post_meta($post_id, '_recruit_company_tw', esc_attr($_POST['d_company_tw']));
                }

                if (isset($_POST['d_company_en'])) {
                    update_post_meta($post_id, '_recruit_company_en', esc_attr($_POST['d_company_en']));
                }

                if (isset($_POST['d_company_vn'])) {
                    update_post_meta($post_id, '_recruit_company_vn', esc_attr($_POST['d_company_vn']));
                }

                if (isset($_POST['d_address'])) {
                    update_post_meta($post_id, '_recruit_address', esc_attr($_POST['d_address']));
                }
                if (isset($_POST['d_phone'])) {
                    update_post_meta($post_id, '_recruit_phone', esc_attr($_POST['d_phone']));
                }
                if (isset($_POST['d_email'])) {
                    update_post_meta($post_id, '_recruit_email', esc_attr($_POST['d_email']));
                }
                if (isset($_POST['d_count'])) {
                    update_post_meta($post_id, '_recruit_count', esc_attr($_POST['d_count']));
                }
                if (isset($_POST['d_summary'])) {
                    update_post_meta($post_id, '_recruit_summary', $_POST['d_summary']);
                }

                if (isset($_POST['d_contact_name'])) {
                    update_post_meta($post_id, '_recruit_contact_name', esc_attr($_POST['d_contact_name']));
                }
                if (isset($_POST['d_contact_phone'])) {
                    update_post_meta($post_id, '_recruit_contact_phone', esc_attr($_POST['d_contact_phone']));
                }
                if (isset($_POST['d_contact_email'])) {
                    update_post_meta($post_id, '_recruit_contact_email', esc_attr($_POST['d_contact_email']));
                }

                if (isset($_POST['d_lack_job'])) {
                    update_post_meta($post_id, '_recruit_lack_job', esc_attr($_POST['d_lack_job']));
                }
                if (isset($_POST['d_lack_count'])) {
                    update_post_meta($post_id, '_recruit_lack_count', esc_attr($_POST['d_lack_count']));
                }


                if (isset($_POST['sel_sex'])) {
                    update_post_meta($post_id, '_recruit_sex', esc_attr($_POST['sel_sex']));
                }

                if (isset($_POST['d_date_from'])) {
                    update_post_meta($post_id, '_recruit_date_from', esc_attr($_POST['d_date_from']));
                }
                if (isset($_POST['d_date_from'])) {
                    update_post_meta($post_id, '_recruit_date_to', esc_attr($_POST['d_date_to']));
                }

                if (isset($_POST['d_level'])) {
                    update_post_meta($post_id, '_recruit_level', esc_attr($_POST['d_level']));
                }
                if (isset($_POST['d_experience'])) {
                    update_post_meta($post_id, '_recruit_experience', esc_attr($_POST['d_experience']));
                }
                if (isset($_POST['d_language'])) {
                    update_post_meta($post_id, '_recruit_language', esc_attr($_POST['d_language']));
                }

                if (isset($_POST['d_work_space'])) {
                    update_post_meta($post_id, '_recruit_work_space', esc_attr($_POST['d_work_space']));
                }

                if (isset($_POST['d_salary'])) {
                    update_post_meta($post_id, '_recruit_salary', esc_attr($_POST['d_salary']));
                }
                if (isset($_POST['d_age_from'])) {
                    update_post_meta($post_id, '_recruit_age_from', esc_attr($_POST['d_age_from']));
                }
                if (isset($_POST['d_age_to'])) {
                    update_post_meta($post_id, '_recruit_age_to', esc_attr($_POST['d_age_to']));
                }
                if (isset($_POST['d_orther'])) {
                    update_post_meta($post_id, '_recruit_orther', stripcslashes($_POST['d_orther']));
                }

                add_action('redirect_post_location', 'custom_redirect');
            }
        }
    }
}