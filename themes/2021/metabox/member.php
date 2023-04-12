<?php

class Admin_Metabox_Member
{

    public function __construct()
    {
        unset($_SESSION['checkEmail']);
        unset($_SESSION['checkUser']);

        add_action('add_meta_boxes', array($this, 'create'));
        add_action('save_post', array($this, 'save'));
    }

    public function create()
    {
        global $post;
        $id = 'member-meta-box';
        $title = '個人資料';
        $callback = array($this, 'display');
        $screen = array('member'); // CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI
        add_meta_box($id, $title, $callback, $screen, 'normal', 'high');
    }

    public function display($post)
    {

        $m_member = "on";
        global $suite, $m_user, $m_email;
        // $editor_settings = Common::$_wpeditor;
        // get cac thong tin khi sp co san (cho phan chinh sua update)
        $m_user = get_post_meta($post->ID, 'm_user', true);
        $m_password = get_post_meta($post->ID, 'm_password', true);
        $m_member = get_post_meta($post->ID, 'm_member', true);
        $m_company = get_post_meta($post->ID, 'm_company', true);
        $m_fullname = get_post_meta($post->ID, 'm_fullname', true);
        //    $m_enfullname       = get_post_meta($post->ID, 'm_lastname', true) .','.get_post_meta($post->ID, 'm_midename', true).'-'.get_post_meta($post->ID, 'm_firstname', true);
        $m_lastname = get_post_meta($post->ID, 'm_lastname', true);
        $m_midename = get_post_meta($post->ID, 'm_midename', true);
        $m_firstname = get_post_meta($post->ID, 'm_firstname', true);
        $m_position = get_post_meta($post->ID, 'm_position', true);
        $m_sex = get_post_meta($post->ID, 'm_sex', true);
        $m_birthdate = get_post_meta($post->ID, 'm_birthdate', true);
        $m_email = get_post_meta($post->ID, 'm_email', true);
        $m_phone = get_post_meta($post->ID, 'm_phone', true);
        $m_address = get_post_meta($post->ID, 'm_address', true);
        $m_active = get_post_meta($post->ID, 'm_active', true);
        $m_image = get_post_meta($post->ID, 'm_image', true);
        $m_passport = get_post_meta($post->ID, 'm_passport', true);
        $m_tax_company = get_post_meta($post->ID, 'm_tax_company', true);
        $m_tax_code = get_post_meta($post->ID, 'm_tax_code', true);
        $m_tax_address = get_post_meta($post->ID, 'm_tax_address', true);
        $m_country = get_post_meta($post->ID, 'm_country', true);
        if (empty($m_image)) {
            $m_image = 'm_img.jpg';
        }
?>

        <div class="row-one-clo">
            <div class="cell-one"><label for="m_active" class="label-admin" style="font-weight: bold"><?php _e('啟 用', 'suite'); ?></label></div>
            <div class="cell-two"><input type="checkbox" style='margin-top: 10px;' name="m_active" id="m_active" <?php
                                                                                                                    if (!empty($m_active)) {
                                                                                                                        echo checked($m_active, 'on', false);
                                                                                                                    } else {
                                                                                                                        echo 'checked';
                                                                                                                    };
                                                                                                                    ?> />
            </div>
        </div>
        <div class="row-all">
            <label for="m_active" class="label-admin" style="font-weight: bold"><?php _e('總 會 會 員', 'suite'); ?></label>
            <input type="radio" style='margin-top: 10px; margin-right: 50px' name="m_member" id="m_member" value="on" checked />
            <label for="m_active" class="label-admin" style="font-weight: bold"><?php _e('招 募 公 司', 'suite'); ?></label>
            <input type="radio" style='margin-top: 10px; margin-right: 50px' name="m_member" id="m_member" value="recruit" <?php echo $m_member == 'recruit' ? 'checked' : '' ?> />
            <label for="m_active" class="label-admin" style="font-weight: bold"><?php _e('應 徵 者', 'suite'); ?></label>
            <input type="radio" style='margin-top: 10px;' name="m_member" id="m_member" value="apply" <?php echo $m_member == 'apply' ? 'checked' : '' ?> />
        </div>

        <div class="row-all">
            <input type='hidden' name='m_image' id='m_image' value='<?php echo $m_image; ?>' />
            <img src="<?php echo PART_IMAGES_AVATAR . $m_image; ?>" style="width:50px; height: 50px; border-radius: 3px; border: 1px #000 solid" />
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_user" class="label-admin"><?php _e('帳 號', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" required pattern=".{3,}" placeholder="小心輸入,此欄目以後不可修改" title="minlegh 5 chars" name="m_user" id="m_user" <?php echo (($m_user) ? 'readonly' : '') ?> value="<?php echo ((!isset($m_user) || $m_user != '') ? $m_user : ''); ?>" /> </div>
            <label id='user_merss' style='color: red;font-weight: bold;'><?php echo $_SESSION['checkUser']; ?></label>
        </div> <!--   password -->

        <!-- kiem tra role de sua pass cho member -->
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_password" class="label-admin"><?php _e('Password', 'suite'); ?></label></div>
            <div class="cell-two">
                <input type="password" style='width: 382px' required name="m_password" id="m_password" value="<?php echo ((!isset($m_password) || $m_password != '') ? $m_password : ''); ?>" />
            </div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_fullname" class="label-admin"><?php _e('Full Name Chinses', 'suite'); ?></label>
            </div>
            <div class="cell-two"><input type="text" required name="m_fullname" id="m_fullname" value="<?php echo ((!isset($m_fullname) || $m_fullname != '') ? $m_fullname : ''); ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_enfullname" class="label-admin"><?php _e('Full Name English', 'suite'); ?></label></div>
            <div class="cell-two">
                <input type="text" style='width: 120px' name="m_lastname" id="m_lastname" value="<?php echo $m_lastname ?>" /> ,
                <input type="text" style='width: 120px' name="m_midename" id="m_midename" value="<?php echo $m_midename ?>" /> -
                <input type="text" style='width: 120px' name="m_firstname" id="m_firstname" value="<?php echo $m_firstname ?>" />
            </div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one "><label class="label-admin"><?php
                                                                _e('Brach');
                                                                echo $data['country'];
                                                                ?> </label></div>
            <div class="cell-two">
                <select id="m_Country" name="m_country">
                    <?php
                    require_once DIR_CODES . 'my_list.php';
                    $myList = new Codes_My_List();
                    foreach ($myList->countryList() as $key => $val) {
                    ?>
                        <option value='<?php echo $key ?>' <?php echo $m_country == $key ? 'selected' : '' ?>> <?php echo $val ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"> <label for="m_sex" class="label-admin"><?php _e('Sex', 'suite'); ?></label></div>
            <div class="cell-two">
                <select id='m_sex' name='m_sex' style='width: 100px'>
                    <option value='1' <?php echo $m_sex == 1 ? 'selected' : '' ?>>男</option>
                    <option value='2' <?php echo $m_sex == 2 ? 'selected' : '' ?>>女</option>
                </select>
            </div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_passport" class="label-admin"><?php _e('會員編號', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" maxlength="9" class="type-number" name="m_passport" id="m_passport" value="<?php echo ((!isset($m_passport) || $m_passport != '') ? $m_passport : ''); ?>" /></div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"> <label for="m_birthdate" class="label-admin"><?php _e('Birth Of Date', 'suite'); ?></label>
            </div>
            <div class="cell-two"><input type="text" maxlength="10" class="MyDateNoYear" placeholder="dd-mm" name="m_birthdate" id="m_birthdate" value="<?php echo $m_birthdate ?>" /></div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"> <label for="m_company" class="label-admin"><?php _e('Company', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" name="m_company" id="m_company" value="<?php echo ((!isset($m_company) || $m_company != '') ? $m_company : ''); ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"> <label for="m_position" class="label-admin"><?php _e('Position', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" name="m_position" id="m_position" value="<?php echo ((!isset($m_position) || $m_position != '') ? $m_position : ''); ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label for="m_address" class="label-admin"><?php _e('Address', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" name="m_address" id="m_address" value="<?php echo ((!isset($m_address) || $m_address != '') ? $m_address : ''); ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"> <label for="m_email" class="label-admin"><?php _e('Email', 'suite'); ?></label></div>
            <div class="cell-two"><input type="email" style='width: 382px' required placeholder="小心輸入,此欄目以後不可修改" name="m_email" id="m_email" value="<?php echo ((!isset($m_email) || $m_email != '') ? $m_email : ''); ?>" /></div>
            <label id='email_merss' style='color: red;font-weight: bold;'> <?php echo $_SESSION['checkEmail']; ?></label>
            <?php $_COOKIE[""]; ?>
        </div> <!--  email-->

        <div class="row-one-clo">
            <div class="cell-one"><label for="m_phome" class="label-admin"><?php _e('Phone', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" class="type-phone" maxlength="20" name="m_phone" id="m_phone" value="<?php echo ((!isset($m_phone) || $m_phone != '') ? $m_phone : ''); ?>" /></div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"><label for="m_tax_company" class="label-admin"><?php _e('Tax Company', 'suite'); ?></label>
            </div>
            <div class="cell-two"><input type="text" name="m_tax_company" id="m_tax_company" value="<?php echo ((!isset($m_tax_company) || $m_tax_company != '') ? $m_tax_company : ''); ?>" /></div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"><label for="m_tax_code" class="label-admin"><?php _e('Tax Code', 'suite'); ?></label></div>
            <div class="cell-two"><input type="text" name="m_tax_code" id="m_tax_code" value="<?php echo ((!isset($m_tax_code) || $m_tax_code != '') ? $m_tax_code : ''); ?>" /></div>
        </div>

        <div class="row-one-clo">
            <div class="cell-one"><label for="m_tax_address" class="label-admin"><?php _e('Tax Address', 'suite'); ?></label>
            </div>
            <div class="cell-two"><input type="text" name="m_tax_address" id="m_tax_address" value="<?php echo ((!isset($m_tax_address) || $m_tax_address != '') ? $m_tax_address : ''); ?>" /></div>
        </div>

        <!--   JAVASCRIPT-->
        <script type="text/javascript">
            jQuery(document).ready(function() {

                jQuery('#m_user').focusout(function(e) {
                    var urlPath = '<?php echo get_template_directory_uri() . '/ajax/admin/checkuser.php' ?>';
                    jQuery.ajax({
                        url: urlPath, // lay doi tuong chuyen sang dang array
                        type: 'post',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(
                            data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                            if (data.status === 'done') {
                                jQuery('#user_merss').text(data.message);
                                jQuery("#publish").prop('disabled', true);
                            } else if (data.status === 'error') {
                                jQuery('#user_merss').text(data.message);
                                if (jQuery('#email_merss').text() === '') {
                                    jQuery("#publish").prop('disabled', false);
                                }
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.reponseText);
                        }
                    });
                    e.preventDefault();
                });

                jQuery('#m_email').focusout(function(e) {
                    var urlPath = '<?php echo get_template_directory_uri() . '/ajax/admin/checkemail.php' ?>';
                    jQuery.ajax({
                        url: urlPath, // lay doi tuong chuyen sang dang array
                        type: 'post',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(
                            data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                            if (data.status === 'done') {
                                jQuery('#email_merss').text(data.message);
                                jQuery("#publish").prop('disabled', true);
                            } else if (data.status === 'error') {
                                jQuery('#email_merss').text('');
                                if (jQuery('#user_merss').text() === '') {
                                    jQuery("#publish").prop('disabled', false);
                                }
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.reponseText);
                        }
                    });
                    e.preventDefault();
                });

            });
        </script>
<?php
    }

    public function save($post_id)
    {
        global $m_user;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (is_admin()) {
            if (@$_POST['post_type'] == 'member') {


                if (isset($_POST['m_active'])) {
                    update_post_meta($post_id, 'm_active', $_POST['m_active']);
                } else {
                    update_post_meta($post_id, 'm_active', 'off');
                }

                if (isset($_POST['m_member'])) {
                    update_post_meta($post_id, 'm_member', $_POST['m_member']);
                } else {
                    update_post_meta($post_id, 'm_member', 'off');
                }


                if (isset($_POST['m_image'])) {
                    update_post_meta($post_id, 'm_image', $_POST['m_image']);
                }

                if (isset($_POST['m_user'])) {
                    update_post_meta($post_id, 'm_user', trim(esc_attr($_POST['m_user'])));
                }

                if (isset($_POST['m_password'])) {
                    update_post_meta($post_id, 'm_password', trim(esc_attr(md5($_POST['m_password']))));
                }

                if (isset($_POST['m_sex'])) {
                    update_post_meta($post_id, 'm_sex', $_POST['m_sex']);
                }

                if (isset($_POST['m_company'])) {
                    update_post_meta($post_id, 'm_company', esc_attr($_POST['m_company']));
                }
                if (isset($_POST['m_fullname'])) {
                    update_post_meta($post_id, 'm_fullname', esc_attr($_POST['m_fullname']));
                }

                if (isset($_POST['m_lastname'])) {
                    update_post_meta($post_id, 'm_lastname', esc_attr($_POST['m_lastname']));
                }

                if (isset($_POST['m_midename'])) {
                    update_post_meta($post_id, 'm_midename', esc_attr($_POST['m_midename']));
                }

                if (isset($_POST['m_firstname'])) {
                    update_post_meta($post_id, 'm_firstname', esc_attr($_POST['m_firstname']));
                }
                if (isset($_POST['m_address'])) {
                    update_post_meta($post_id, 'm_address', esc_attr($_POST['m_address']));
                }
                if (isset($_POST['m_email'])) {
                    update_post_meta($post_id, 'm_email', trim(esc_attr($_POST['m_email'])));
                }
                if (isset($_POST['m_phone'])) {
                    update_post_meta($post_id, 'm_phone', esc_attr($_POST['m_phone']));
                }
                if (isset($_POST['m_passport'])) {
                    update_post_meta($post_id, 'm_passport', esc_attr($_POST['m_passport']));
                }
                if (isset($_POST['m_birthdate'])) {
                    update_post_meta($post_id, 'm_birthdate', esc_attr($_POST['m_birthdate']));
                }
                if (isset($_POST['m_position'])) {
                    update_post_meta($post_id, 'm_position', esc_attr($_POST['m_position']));
                }
                if (isset($_POST['m_tax_company'])) {
                    update_post_meta($post_id, 'm_tax_company', esc_attr($_POST['m_tax_company']));
                }
                if (isset($_POST['m_tax_code'])) {
                    update_post_meta($post_id, 'm_tax_code', esc_attr($_POST['m_tax_code']));
                }
                if (isset($_POST['m_tax_address'])) {
                    update_post_meta($post_id, 'm_tax_address', esc_attr($_POST['m_tax_address']));
                }
                if (isset($_POST['m_country'])) {
                    update_post_meta($post_id, 'm_country', esc_attr($_POST['m_country']));
                }

                global $wpdb;
                $table = $wpdb->prefix . 'posts';
                $data = array('post_title' => $_POST['m_user']);
                $where = array('ID' => absint($post_id));
                $wpdb->update($table, $data, $where);

                if (get_post_meta($post_id, 'm_active', true) == 'on') {

                    /* SEND MAIL KHI DANG KY MOI
                  //add_action('redirect_post_location', 'custom_redirect'); */
                    $mailTo = $_POST['m_email'];
                    $name = $_POST['m_fullname'];
                    $user = $_POST['m_user'];
                    $password = $_POST['m_password'];

                    require_once DIR_CLASS . 'sendmail.php';
                    $sendMail = new SendMailClass();
                    $sendMail->sendMailMemberRegister($mailTo, $name, $user, $password);
                }
                /* PHAN CHUYEN TRANG */
                add_action('redirect_post_location', 'custom_redirect');
            }
        }
    }
}
