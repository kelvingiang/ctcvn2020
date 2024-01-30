<?php

function add($error)
{
    if (empty($error)) {
        /* create an "order" in DB and save order details */

        $objNewOrder = array(
            'post_type' => 'member',
            'post_title' => esc_attr($_POST['m_user']),
            'post_author' => 1,
            'post_status' => 'publish'
        );
        $intPostId = wp_insert_post($objNewOrder);

        /* Save order details into Database*/
        update_post_meta($intPostId, 'm_member', 'apply');
        update_post_meta($intPostId, 'm_user', esc_attr($_POST['m_user']));
        update_post_meta($intPostId, 'm_password', md5(esc_attr($_POST['m_pass'])));
        update_post_meta($intPostId, 'm_active', 'on');
        update_post_meta($intPostId, 'm_fullname', esc_attr($_POST['m_fullname']));
        update_post_meta($intPostId, 'm_passport', esc_attr($_POST['m_passport']));
        update_post_meta($intPostId, 'm_birthdate', esc_attr($_POST['m_birthdate']));
        update_post_meta($intPostId, 'm_sex', esc_attr($_POST['m_sex']));
        update_post_meta($intPostId, 'm_email', esc_attr($_POST['m_email']));
        update_post_meta($intPostId, 'm_phone', esc_attr($_POST['m_phone']));
        update_post_meta($intPostId, 'm_address', esc_attr($_POST['m_address']));
        update_post_meta($intPostId, 'm_image', 'm_img.jpg');


        $mailTo       = $_POST['m_email'];
        $name         = $_POST['m_fullname'];
        $user           = $_POST['m_user'];
        $password    = $_POST['m_pass'];

        require_once DIR_CLASS . 'sendmail.php';
        $sendMail = new SendMailClass();
        $sendMail->sendMailMemberRegister($mailTo, $name, $user, $password);
    }
}

if (!empty($_POST)) {
    // kiem neu het loi add vao data base
    // $error = cac loi khi nhap lieu
    $m_error = '';
    if (isset($_POST['m_user'])) {
        $txt_user = $_POST['m_user'];
        $back_user = checkstr($txt_user, 5, 20);
        if (!empty($back_user)) {
            $err_user =  $back_user;
            $m_error = 'user';
        } else {
            $user = $_POST['m_user'];
        }
    }

    $captchaValue = checkcaptcha($_POST['txtCaptcha']);
    if ($captchaValue != 'done') {
        $err_captcha = $captchaValue;
        $m_error = 'captcha';
    }

    $user = $_POST['m_user'];
    $pass = $_POST['m_pass'];
    $passf = $_POST['m_passf'];
    $fullname = $_POST['m_fullname'];
    $birthdate = $_POST['m_birthdate'];
    $email = $_POST['m_email'];
    $phone = $_POST['m_phone'];
    $address = $_POST['m_address'];
    $sex = $_POST['m_sex'];



    add($m_error);
    //////======================================================
?>

<?php } ?>

<form id="f-register" name="f-register" method="post" action="">

    <div class='head-title'>
        <div class="title">
            <h2 class="head"> <?php _e('學生註冊表 - Đăng ký Cho Sinh Viên'); ?> </h2>
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('User Name'); ?><br>
                <?php _e('Tên Đăng Nhập'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label id='user-error' class=" error-text"><?php echo $err_user; ?></label>
            <input type="text" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('User Name', 'suite'); ?>" pattern=".{2,}" title="minlegh 2 chars" name="m_user" id="m_user" value="<?php echo $user; ?>">
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Password'); ?><br>
                <?php _e('Mật Khẩu'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label class="error-text"><?php echo $err_pass ?></label>
            <input type="password" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Password', 'suite'); ?>" name="m_pass" id="m_pass" value="<?php echo $pass ?>" />
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Password Confirm') ?><br>
                <?php _e('Xác Nhận Mật Khẩu') ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label class="error-text" id="mes-passf"><?php echo $err_passf ?></label>
            <input type="password" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Password Confirm', 'suite'); ?>" name="m_passf" id="m_passf" value="<?php echo $passf ?>" />
        </div>
    </div>
    <hr /> <!-- =========    -->

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Full Name'); ?><br>
                <?php _e('Họ Và Tên'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label class="error-text"><?php echo $err_fullname ?></label>
            <input type="text" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Full Name', 'suite'); ?>" name="m_fullname" id="m_fullname" value="<?php echo $fullname ?>" />
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Birth Of Date'); ?>
                <br>
                <?php _e('Ngày Tháng Năm Sinh'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label class="error-text"><?php echo $err_birthdate ?></label>
            <input type="text" class="MyDate" maxlength="10" required name="m_birthdate" id="m_birthdate" value="<?php echo $birthdate ?>">
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Sex'); ?> <br>
                <?php _e('Giới Tính'); ?>
            </label>
        </div>
        <div class='col-md-9' style="margin-top: 2rem;">
            <label class="error-text"></label>
            <select id="m_sex" name="m_sex" class="selectmenu" style="width: 180px;">
                <option value="1" <?php if ($sex == '1') echo ' selected="selected"'; ?>><?php _e('男 - Nam'); ?>
                </option>
                <option value="2" <?php if ($sex == '2') echo ' selected="selected"'; ?>><?php _e('女 - Nữ'); ?>
                </option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class=' col-md-3'>
            <label class="label-title">
                <?php _e('Email'); ?><br>
                <?php _e('E-mail'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label id="email-error" class="error-text"><?php echo $err_email; ?></label>
            <input type="email" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied or Email', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Email', 'suite'); ?>" name="m_email" id="m_email" value="<?php echo $email ?>" />
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Phone'); ?> <br>
                <?php _e('Điện Thoại'); ?>
            </label>
        </div>
        <div class=' col-md-9'>
            <label class="error-text"><?php echo $err_phone ?></label>
            <input type="text" required class="form-control type-phone" maxlength="20" oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" pattern="^[0-9 \-]+$" placeholder="<?php _e('Phone', 'suite'); ?> " name="m_phone" id="m_phone" value="<?php echo $phone ?>" />
        </div>
    </div>

    <div class="row">
        <div class='col-md-3'>
            <label class="label-title">
                <?php _e('Address'); ?> <br>
                <?php _e('Địa Chỉ'); ?>
            </label>
        </div>
        <div class='col-md-9'>
            <label class="error-text"><?php echo $err_address ?></label>
            <input type="text" class="form-control" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Address', 'suite'); ?> " name="m_address" id="m_address" value="<?php echo $address ?>" />
        </div>
    </div>


    <div class="row">
        <div class=' col-md-3'>
            <label class="label-title">
                <?php _e('Captcha') ?><br>
                <?php _e('Mã Xác Nhận') ?>
            </label>
        </div>
        <div class=' col-md-4'>
            <label class="error-text"><?php echo $err_captcha; ?></label><br>
            <input type="text" maxlength="5" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')" onchange="this.setCustomValidity('')" placeholder="<?php _e('Captcha', 'suite') ?>" id="txtCaptcha" name="txtCaptcha" value="<?php echo $captcha ?>">
        </div>
        <div class=" col-md-5">
            <img src="<?php echo PART_CLASS . 'captcha/captcha.php'; ?>" onclick="this.src = '<?php echo  PART_CLASS . 'captcha/captcha.php?reset=true&' ?>' + Math.random();" style="cursor:pointer" />
        </div>
    </div>

    <div class="row-register">
        <div style="text-align: center">
            <input type="submit" class="btn btn-primary" name="m_submit" id="m_submit" value="<?php _e('提交 - Gởi '); ?>" />
            <input type="reset" class="btn btn-primary" name="m_reset" id="m_reset" value="<?php _e('重寫 - Việt Lại'); ?>" />
        </div>
    </div>

</form>



<div id="div-popup">
    <div id="div-alertInfo">
        <div id="alert-title">
            <?php _e('Notice', 'suite');  ?>
            <input type="button" id="btn-close" name="btn-close" value="X" />
        </div>
        <div id="alert-content">
            <h2><?php _e('congratulation your register success !', 'suite'); ?> </h2>
        </div>
        <div id="alert-footer"></div>
    </div>
    <div id="div-bg"></div>
</div>

<!-- cac ky tu key code cho phep nhap  -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        // ===B ===== EVENT OF POPUP ======================
        var error = "<?php echo $m_error; ?>";

        var post = "<?php echo $_POST['m_user'] ?>";
        if (error === '' && post !== '') {
            jQuery('#div-popup').fadeIn('slow');
            jQuery('#div-alertInfo').css('top', '150px');
            setTimeout(closePopup, 5000);
        }

        function closePopup() {
            jQuery('#div-popup').fadeOut('slow');
            jQuery('#div-alertInfo').css('top', '0px');
            jQuery('#div-alertInfo').css('opacity', '0');
            window.location = '<?php echo home_url('member-login') ?>';
        }

        // dong pupop
        jQuery('#div-bg').click(function() {
             closePopup();
        });

        jQuery('#btn-close').click(function() {
             closePopup();
        });
        // ===E ==== EVENT OF POPUP ======================          
        // kiem tra password va comfirm password
        jQuery('#m_passf').on('keyup', function() {
            if (jQuery('#m_pass').val() !== jQuery('#m_passf').val()) {
                jQuery('#mes-passf').html('<?php _e('Not Matching', 'suite');  ?>').css('color', 'red');
            } else {
                jQuery('#mes-passf').html('');
            }
        });


        jQuery('#m_user').on('focusout', function() {
            var user = jQuery('#m_user').val();
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/check-member-user.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post', //                data: $(this).serialize(),
                data: {
                    id: user
                },
                dataType: 'json',
                success: function(
                    data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'error') {
                        jQuery('#user-error').text('賬號已註冊請選擇其他 - Tài Khoản có Đăng Ký Chọn Tài Khoản Khác ');
                        jQuery('#m_submit').prop('disabled', true);
                    } else {
                        jQuery('#user-error').text('');
                        jQuery('#m_submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.reponseText);
                    console.log(data.status);
                }
            });
        });


        jQuery('#m_email').on('focusout', function() {
            var user = jQuery('#m_email').val();
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/check-member-email.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post', //                data: $(this).serialize(),
                data: {
                    id: user
                },
                dataType: 'json',
                success: function(
                    data) { // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'error') {
                        jQuery('#email-error').text('電郵已註冊請選擇其他 - E-mail có Đăng Ký Chọn E-mail Khác ');
                        jQuery('#m_submit').prop('disabled', true);
                    } else {
                        jQuery('#email-error').text('');
                        jQuery('#m_submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    console.log(data.status);
                }
            });
        });

    });
</script>