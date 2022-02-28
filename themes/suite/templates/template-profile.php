<!--  lay thong trong database lan dau  -->
<?php
//global $post;
$arr = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_user', 'value' => $_SESSION['login'])
    ),
);
$objMember = current(get_posts($arr));

if ($objMember) {
    $getMeta = get_post_meta($objMember->ID); // lay gia tri tu metabox 

    $user = $getMeta['m_user'][0]; 
    $fullname = $getMeta['m_fullname'][0];
    $address = $getMeta['m_address'][0];
    $lastname = $getMeta['m_lastname'][0];
    $midename = $getMeta['m_midename'][0];
    $firstname = $getMeta['m_firstname'][0];
    $birthdate = $getMeta['m_birthdate'][0];
    $position = $getMeta['m_position'][0];
    $sex = $getMeta['m_sex'][0];
    $company = $getMeta['m_company'][0];
    $email = $getMeta['m_email'][0];
   // $_SESSION['email'] = $getMeta['m_email'][0];
    $phone = $getMeta['m_phone'][0];
    $tax_company = $getMeta['m_tax_company'][0];
    $tax_code = $getMeta['m_tax_code'][0];
    $tax_address = $getMeta['m_tax_address'][0];
}
$m_error = '';
// luu lai thong tin khi duoc chinh sua
if (!empty($_POST)) {

    // $error = cac loi khi nhap lieu
    function add($error) {
        if (empty($error)) {
            // dua va session thiet where lay du lieu
            $objNewOrder = array(
                'post_type' => 'member',
                'meta_query' => array(
                    array('key' => 'm_user', 'value' => $_SESSION['login'])
                )
            );
            // sau khi lay va lay dong du lieu
            $objMember = current(get_posts($objNewOrder));
            $id = $objMember->ID; // lay ID cua du dong du lieu lay dc

            update_post_meta($id, 'm_active', 'on');
            update_post_meta($id, 'm_fullname', esc_attr($_POST['m_fullname']));
            update_post_meta($id, 'm_company', esc_attr($_POST['m_company']));
            update_post_meta($id, 'm_position', esc_attr($_POST['m_position']));
            update_post_meta($id, 'm_lastname', esc_attr($_POST['m_lastname']));
            update_post_meta($id, 'm_midename', esc_attr($_POST['m_midename']));
            update_post_meta($id, 'm_firstname', esc_attr($_POST['m_firstname']));
            update_post_meta($id, 'm_birthdate', esc_attr($_POST['m_birthdate']));
            update_post_meta($id, 'm_sex', esc_attr($_POST['m_sex']));
            update_post_meta($id, 'm_email', esc_attr($_POST['m_email']));
            update_post_meta($id, 'm_phone', esc_attr($_POST['m_phone']));
            update_post_meta($id, 'm_address', esc_attr($_POST['m_address']));
            update_post_meta($id, 'm_tax_company', esc_attr($_POST['m_tax_company']));
            update_post_meta($id, 'm_tax_code', esc_attr($_POST['m_tax_code']));
            update_post_meta($id, 'm_tax_address', esc_attr($_POST['m_tax_address']));
            wp_redirect($_SERVER['REQUEST_URI']);

           // unset($_SESSION['email']);
        }
    }

//========= action =======================================================================

    if (isset($_POST['m_fullname'])) {
        $txt_fullname = $_POST['m_fullname'];
        $back_fullname = checkstr($txt_fullname);
        if (!empty($back_fullname)) {
            $err_fullname = $back_fullname;
            $m_error = $m_error . ', full name';
            $fullname = $_POST['m_fullname'];
        } else {
            $fullname = $_POST['m_fullname'];
        }
    }

    $err_englishName = '';
    if (isset($_POST['m_lastname'])) {
        $txt_lastname = $_POST['m_lastname'];
        $back_lastname = checkstr($txt_lastname);
        if (!empty($back_lastname)) {
            $err_englishName = '英文姓名' . $back_lastname;
            $m_error = $m_error . ', last name';
        } else {
            $lastname = $_POST['m_lastname'];
        }
    }
    if (isset($_POST['m_midename'])) {
        $txt_midename = $_POST['m_midename'];
        $back_midename = checkstr($txt_midename);
        if (!empty($back_midename)) {
            $err_englishName = '英文姓名' . $back_midename;
            $m_error = $m_error . ', mide name';
        } else {
            $midename = $_POST['m_midename'];
        }
    }
    if (isset($_POST['m_firstname'])) {
        $txt_firstname = $_POST['m_firstname'];
        $back_firstname = checkstr($txt_firstname);
        if (!empty($back_firstname)) {
            $err_englishName = '英文姓名' . $back_firstname;
            $m_error = $m_error . ', first name';
        } else {
            $firstname = $_POST['m_firstname'];
        }
    }
    if (isset($_POST['m_birthdate'])) {
        $txt_birthdate = $_POST['m_birthdate'];
        $back_birthdate = checkstr($txt_birthdate);
        if (!empty($back_birthdate)) {
            $err_birthdate = '出生日期' . $back_birthdate;
            $m_error = $m_error . ', birthdate';
        } else {
            $birthdate = $_POST['m_birthdate'];
        }
    }
    if (isset($_POST['m_sex'])) {
        $sex = $_POST['m_sex'];
    }
    if (isset($_POST['m_address'])) {
        $txt_address = $_POST['m_address'];
        $back_address = checkstr($txt_address);
        if (!empty($back_address)) {
            $err_address = $back_address;
            $m_error = $m_error . ', address';
            $address = $_POST['m_address'];
        } else {
            $address = $_POST['m_address'];
        }
    }
    if (isset($_POST['m_company'])) {
        $txt_company = $_POST['m_company'];
        $back_company = checkstr($txt_company);
        if (!empty($back_company)) {
            $err_company = $back_company;
            $m_error = $m_error . ', company';
            $company = $_POST['m_company'];
        } else {
            $company = $_POST['m_company'];
        }
    }
    if (isset($_POST['m_position'])) {
        $txt_position = $_POST['m_position'];
        $back_position = checkstr($txt_position);
        if (!empty($back_position)) {
            $err_position = $back_position;
            $m_error = $m_error . ', position';
            $position = $_POST['m_position'];
        } else {
            $position = $_POST['m_position'];
        }
    }
    if (isset($_POST['m_phone'])) {
        $txt_phone = $_POST['m_phone'];
        $back_phone = checkstr($txt_phone);
        if (!empty($back_phone)) {
            $err_phone = $back_phone;
            $m_error = $m_error . ', phone';
            $phone = $_POST['m_phone'];
        } else {
            $phone = $_POST['m_phone'];
        }
    }
    if (isset($_POST['m_email'])) {
        $txt_email = $_POST['m_email'];
        $back_email = checkemail($txt_email);
        if (!empty($back_email)) {
            $err_email = $back_email;
            $m_error = $m_error . ', emaill';
            $email = $_POST['m_email'];
        } else {
            $email = $_POST['m_email'];
        }
    }

    // kiem tra email co ton tai hay chua
    if ($_POST['m_email'] !== $_SESSION['email']) {
        $checkEmail = checkExists('m_email', $_POST['m_email'], '該 e-mail 地址已註冊, 請選擇其他 !');
        if (!empty($checkEmail)) {
            $m_error = $checkEmail['error'];
            $err_email = $checkEmail['mess'];
        }// kiem tra va gan error tra ve
    }
    //   die();
    add($m_error);
//////======================================================
    

}
?>
<div id="register-content">
    <form id="f-porfile"  name="f-profile" method="post" action="">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('Profile', 'suite'); ?> </h2>
            </div>
        </div>
        <div>
               <!--<a href="<?php // echo home_url('/change-password/')                 ?>">Changed Password</a></div> -->
            <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#changPass"><?php _e('Change Password', 'suite'); ?></a> 
            <a id="editInfo" class="btn btn-primary"  ><?php _e('Edit Profile', 'suite'); ?></a>
        </div>
        <hr/>
        <div class="row row-modify">
            <div class="col-md-4 col-sm-3 col-xs-12"><label class="label-title " for="m_user"><?php _e('User Name', 'suite'); ?>  : </label> </div>
            <div  class="col-md-8 col-sm-9 col-xs-12"><label style="margin-left: 10px; color: #999999"> <?php echo $user ?></label></div>
        </div>
        <div class="row row-modify">
            <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_fullname"><?php _e('Full Name', 'suite'); ?></label></div>
            <div  class="col-md-8 col-sm-9 col-xs-12">
                <input type="text" required   name="m_fullname" id="m_fullname"  class="memberInfo"value="<?php echo $fullname ?>" />
                <label class="mess" id="mes-fullname"><?php echo $err_fullname ?></label>
            </div>
        </div>

        <div class="row row-modify">
            <div class='col-md-4 col-sm-3 col-xs-12'><label class="label-title"><?php _e('Full Name English', 'suite'); ?></label></div>
            <div class='col-md-8 col-sm-9 col-xs-12' >
                <input type="text"  required   class="memberInfo" style='width:30%' oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')"   name="m_lastname" id="m_lastname" value="<?php echo $lastname ?>" />  , 
                <input type="text" required    class="memberInfo" style= 'width:25%'  oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')"  name="m_midename" id="m_midename" value="<?php echo $midename ?>" />  - 
                <input type="text"   required   class="memberInfo" style= 'width:30%' oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')"   name="m_firstname" id="m_firstname" value="<?php echo $firstname ?>" />
                <label class="mess" id="mes-fullname"><?php echo $err_englishName ?></label>
            </div>
        </div>

        <div class="row row-modify">
            <div class='col-md-4 col-sm-3 col-xs-12'><label class="label-title" for="m_birthdate"><?php _e('Birth Of Date', 'suite'); ?> </label></div>
            <div class='col-md-8 col-sm-9 col-xs-12'>
                <input type="text" required class=" MyDate memberInfo" maxlength="10"  name="m_birthdate" id="m_birthdate"value="<?php echo $birthdate ?>">
                <label class="mess" id="mes-fullname"><?php echo $err_birthdate ?></label>
            </div>
        </div> 

        <div class="row row-modify">
            <div class='col-md-4 col-sm-3 col-xs-12'><label class="label-title" for="m_sex"><?php _e('Sex', 'suite'); ?> </label></div>
            <div class='col-md-8 col-sm-9 col-xs-12'>
                <select id="m_sex" name="m_sex" class="selectmenu" style="width: 180px">
                    <option value="1" <?php if ($sex == '1') echo ' selected="selected"'; ?>><?php _e('Male', 'suite'); ?></option>
                    <option value="2" <?php if ($sex == '2') echo ' selected="selected"'; ?>><?php _e('Female', 'suite'); ?></option>
                </select>
            </div>
        </div>
        <div class="row row-modify">
            <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_address"><?php _e('Address', 'suite'); ?> </label></div>
            <div  class="col-md-8 col-sm-9 col-xs-12">
                <input type="text" required placeholder="nhap dia chi" name="m_address" id="m_address" class="memberInfo" style=' width: 80%' value="<?php echo $address ?>"/>
                <label class="mess" id="mes-address"><?php echo $err_address ?></label>
            </div>
        </div>
        <?php if ($_SESSION['login_type'] !== 'apply') { ?>
            <div class="row row-modify">
                <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_company"><?php _e('Company', 'suite'); ?></label></div>
                <div  class="col-md-8 col-sm-9 col-xs-12">
                    <input type="text" required  name="m_company" id="m_company" class="memberInfo" value ="<?php echo $company ?>" />
                    <label class="mess" id="mes-company"><?php echo $err_company ?></label>
                </div>
            </div>

            <div class="row row-modify">
                <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_position"><?php _e('Position', 'suite'); ?></label></div>
                <div  class="col-md-8 col-sm-9 col-xs-12">
                    <input type="text" required  name="m_position" id="m_position" class="memberInfo" value ="<?php echo $position ?>" />
                    <label class="mess" id="mes-postion"><?php echo $err_position ?></label>
                </div>
            </div>
        <?php } ?>
        <div class="row row-modify">
            <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_email"><?php _e('Email', 'suite'); ?></label></div>
            <div  class="col-md-8 col-sm-9 col-xs-12">
                <input type="email"  required placeholder="nhap email"  name="m_email" id="m_email " class="memberInfo" value="<?php echo $email ?>"/>
                <label class="mess" id="mes-email"><?php echo $err_email; ?></label>
            </div>
        </div>

        <div class="row row-modify">
            <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_phone"><?php _e('Phone', 'suite'); ?> </label></div>
            <div  class="col-md-8 col-sm-9 col-xs-12">
                <input type="text" required  pattern="^[0-9 \-]+$"  maxlength="20"  placeholder="nhap so dien thoai "  name="m_phone" id="m_phone" class="memberInfo type-phone" value="<?php echo $phone ?>"/> 
                <label class="mess" id="mes-phone"><?php echo $err_phone ?></label>
            </div>
        </div>
        <hr>
     
        <?php if ($getMeta['m_member'][0] == 'on') { ?> 
            <label style=" color: red; font-weight: bold; font-size: 13px"><?php echo $tax_code == '' ? '請 填 上 紅 發 票 的 資 料' : '' ?></label>
            <div class="row row-modify">
                <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_tax_company"><?php _e('Tax Company', 'suite'); ?> </label></div>
                <div  class="col-md-8 col-sm-9 col-xs-12">
                    <input type="text"  name="m_tax_company" id="m_tax_company" class="memberInfo" value="<?php echo $tax_company == '' ? $company : $tax_company ?>"/> 
                </div>
            </div> 
            <div class="row row-modify">
                <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_tax_code"><?php _e('Tax Code', 'suite'); ?> </label></div>
                <div  class="col-md-8 col-sm-9 col-xs-12">
                    <input type="text"  pattern="^[0-9 \-]+$"  maxlength="20"  placeholder="Tax Code"  name="m_tax_code" id="m_tax_code" class="memberInfo type-phone" value="<?php echo $tax_code ?>"/> 
                </div>
            </div> 
            <div class="row row-modify">
                <div  class="col-md-4 col-sm-3 col-xs-12"><label class="label-title" for="m_tax_address"><?php _e('Tax Address', 'suite'); ?> </label></div>
                <div  class="col-md-8 col-sm-9 col-xs-12">
                    <input type="text"  name="m_tax_address" id="m_tax_address" class="memberInfo" value="<?php echo $tax_address == '' ? $address : $tax_address ?>"/> 
                </div>
            </div> 
        <?php } ?>

        <div class="row changInfo">
            <div  style="text-align: center">
                <input id="btn_reset_new" type="reset" class="btn btn-primary" value="<?php _e('Cancel', 'suite'); ?>" onclick="javascript:window.location = '<?php echo home_url('/register/') ?>';" />
                <input type="submit" class="btn btn-primary"  name="m_submit" id="m_submit" value="<?php _e('Submit', 'suite'); ?>" />
                <input type="reset"  class="btn btn-primary"  name="m_reset" id="m_reset" value="<?php _e('Reset', 'suite'); ?>" />
            </div>
        </div>
    </form>
</div>


<!-- =================================================== change password -->
<div  id="changPass" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="f_changepass"  method="post" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"  data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <?php _e('Change Password', 'suite'); ?> </h4>
                    <div style=" clear: both"></div>
                </div>
                <div class="modal-body">
                    <div class='row'>
                        <div class='col-md-3'><label class="label-title"><?php _e('Old Password', 'suite') ?></label></div> 
                        <div class='col-md-9'><input type="password" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')" placeholder="<?php _e('Old Password', 'suite') ?>"  id="o_pass" name="o_pass" required /> <label  id="lblOldPass" ></label> </div>
                    </div>
                    <div class='col-md-12' style='height: 10px'></div>
                    <div class='row'>
                        <div class='col-md-3'><label class="label-title"><?php _e('New Password', 'suite') ?></label></div> 
                        <div class='col-md-9'><input type="password" required  oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')" placeholder="<?php _e('New Password', 'suite') ?>" id="n_pass" name="n_pass" required /> <label id="lblNewPass" ></label></div>
                    </div>
                    <div class='col-md-12' style='height: 10px'></div>
                    <div class='row'>
                        <div class='col-md-3'><label class="label-title"><?php _e('Comfirm New Password', 'suite') ?></label></div> 
                        <div class='col-md-9'><input type="password" required oninvalid="this.setCustomValidity('<?php _e('Requied', 'suite'); ?>')"  onchange="this.setCustomValidity('')" placeholder="<?php _e('Comfirm New Password', 'suite') ?>" id="n_passf" name="n_passf" required /><label id="lblNewPassf"></label></div>
                    </div>
                    <div><label id="strChangePassMessage"></label> </div>
                    <div>    </div>
                </div>
                <a href="../../../../../../../C:/Users/web/Desktop/template-profile.php"></a>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary"  data-dismiss="modal" value="<?php _e('Cancel', 'suite'); ?>" name="btn_cancel" id="btn_cancel"/>
                    <input type="submit" class="btn btn-primary" value="<?php _e('Submit', 'suite'); ?>" name="btn_submit" id="btn_submit"/>
                </div>
            </div>
        </form>
    </div>
</div>

<style type="text/css">
    .ui-datepicker-year {
       /*display: none;*/
    }
</style>

<!-- cac ky tu key code cho phep nhap  -->
<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery('#n_passf').on('keyup', function () {
            if (jQuery('#n_pass').val() !== jQuery('#n_passf').val()) {
                jQuery('#lblNewPassf').html('Not Matching').css('color', 'red');
                jQuery('#btn_submit').prop("disabled", true);
            } else {
                jQuery('#lblNewPassf').html('');
                jQuery('#btn_submit').prop("disabled", false);
            }
        });

        jQuery('#f_changepass').submit(function (e) {
            //    var objInfo = objchangeData; // lay gia tri dc chuyen sang tu file yeu cau
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/changepass.php' ?>', //objInfo.url,  
                type: 'post',
                data: jQuery(this).serialize(),
                dataType: 'json',
                success: function (data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'done') {
                        //    location.reload(); //load lai trang
                        //   window.location.replace("<?php // echo add_query_arg(array('action' => 'logout'), home_url());          ?>");
                        window.location.replace("<?php echo home_url('/logout/'); ?>");
                        // wp_redirect( home_url());//  add_query_arg(array('action' => 'logout'), $_SERVER['REQUEST_URI']);
                    } else if (data.status === 'error') {
                        jQuery('#strChangePassMessage').text(data.message);
                        jQuery('#lblOldPass').text(data.oldPass).css('color', 'red');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.reponseText);
                }
            });
            e.preventDefault();

        });

// thiet lap cac style cho input info
        //    $('.memberInfo').prop("disabled", true).addClass('hide-info');
        //     $('.changInfo').hide();

        var error = '<?php echo $m_error ?>';
        // console.log(error);

        if (error === "") {
            ('.memberInfo').prop("disabled", true).addClass('hide-info');
            jQuery('.changInfo').hide();
        } else {
            jQuery('.memberInfo').prop("disabled", false).removeClass('hide-info');
            jQuery('.changInfo').show();
        }

        // khi click edit
        jQuery('#editInfo').click(function () {
            jQuery('.memberInfo').prop("disabled", false);
            jQuery('.memberInfo').removeClass('hide-info');
            jQuery('.changInfo').show('fast');
        });

    });
</script>

