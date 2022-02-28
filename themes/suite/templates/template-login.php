<?php
// dien kien where de lay du lieu
$arr = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_user', 'value' => @$_SESSION['login'])
    ),
);
?>
<!--  
    phan nay kiem tra bang ajax, code xu ky ajax dc viet tai file js va dc add vao o dau trang (checkajax.js)
-->
<div style="padding-top: 10px; margin-bottom: 20px;">
    <?php if (!isset($_SESSION['login'])) { ?>
        <div class="blue-group">
            <div class="blue-title">
                <label>媒合帳號 <i>Đăng Nhập Tuyển Dụng</i></label>
            </div>
            <div style=" margin-top: 20px">
                <form id="f_login" name="f_login" method="post" action="">
                    <div id="row">
                        <div class="col-md-12"><label class='label-title'><?php _e('User Name or Full Name', 'suite'); ?><i style='color: #666'> Tài Khoản</i></label></div>
                        <div class="col-md-12"><input type="text" required placeholder="Username" id="l_user" name="l_user" autocomplete="off" /></div>
                        <div class='col-md-12' style='height: 10px'></div>
                        <div class="col-md-12"><label class='label-title'><?php _e('Password', 'suite') ?><i style="color: #666"> Mật Khẩu</i></label></div>
                        <div class="col-md-12"><input type="password" required placeholder="Password" id="l_pass" name="l_pass" autocomplete="off" /></div>
                        <div class=' col-md-12'>
                            <p id="strMessageLogin" style=" margin-top:5px; color: red; font-weight: bold"></p>
                        </div>
                        <div style='text-align: center; margin: 10px 20px '>
                            <button type="submit" class="btn-my" name="btn_login" id="btn_submit" style=" margin-right: 10px">
                                <?php _e('Login', 'suite'); ?><br><i>Đăng Nhập</i>
                            </button>

                            <button type="button" class="btn-my" data-toggle="modal" data-target="#ForgetPass">
                                <?php _e('Forget Password', 'suite'); ?><br> <i>Quên Mật Khẩu</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
    } else {
        if ($_SESSION['login']) {
        ?>
            <!-- lay thông tin user -->
            <?php
            $objMember = current(get_posts($arr));
            //$_SESSION['login_id'] = $objMember->ID;
            if ($objMember) {
                $getMeta = get_post_meta($objMember->ID); // lay gia tri tu metabox 
                $m_image = $getMeta['m_image'][0]; //
            }
            ?>
            <div style=" border: 1px solid #B7C1CC; border-radius: 4px;  padding: 15px; background-color:#DBDBDB ">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                        <h5 style="font-weight: bold;  font-size: 15px">
                            <a href="#" data-toggle="modal" data-target="#myModal" style="margin-right: 10px">
                                <img class="avatar" src="<?php echo PART_IMAGES_AVATAR . $m_image; ?>" />
                            </a>
                            <?php echo $getMeta['m_fullname'][0]; ?> <?php _e('您好 ! ', 'suite'); ?>
                        </h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <label style=" font-size: 0.8em">帳號 : <?php echo $_SESSION['login']; ?></label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <label>
                            <a href="<?php echo home_url('/register/') ?>" class="btn btn-primary">
                                帳號資料 <i class="my_i"> thông tin tài khoản</i>
                            </a>
                        </label>
                    </div>
                </div>
                <div class="row" style=" text-align: left; margin-top: 10px">
                    <?php
                    if ($_SESSION['login_type'] == 'recruit') {
                        //wp_redirect( home_url('recruitments'));
                    ?>
                        <div class="col-md-3 col-sm-6 col-xs-3 " style="margin: 0px">
                            <a href="<?php echo home_url('/recruit/?dt=4') ?>" class="btn btn-primary" style="letter-spacing: 3px">
                                <?php _e('dangtuyen', 'suite'); ?>
                            </a>
                        </div>
                    <?php
                    } elseif ($_SESSION['login_type'] == 'apply') {
                        //  wp_redirect(home_url('recruiter'));
                    ?>
                        <div class="col-md-3 col-sm-6 col-xs-3" style="margin:0px">
                            <a href="<?php echo home_url('/recruit/?dt=3') ?>" class="btn btn-primary">
                                履歷 <i class="my_i">lý lịch</i>
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-3 col-sm-6 col-xs-3">
                            <a href="<?php echo home_url('/article/') ?>" class="btn btn-primary" style="letter-spacing: 3px">
                                <?php _e('Article', 'suite'); ?>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-3">
                            <a href="<?php echo home_url('/recruit/?dt=4') ?>" class="btn btn-primary" style="letter-spacing: 3px">
                                <?php _e('dangtuyen', 'suite'); ?>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="col-md-3 col-sm-6 col-xs-3"><a href="<?php echo home_url('/logout/'); ?>" class="btn btn-primary"><?php _e('Logout', 'suite'); ?> <i class="my_i"> đăng xuất</i></a></div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>

<!-- B ----------  phan cap nhat lai hinh hinh avata cua member ---->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form id="f-avata" name="f-avata" action="" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php _e('Ａvatar', 'suite'); ?></h4>
                    <div style=" clear: both"></div>
                </div>
                <div class="modal-body">
                    <div id="default-imgfe"> </div>
                    <div id="upload-image">
                        <div id="show-img"> </div>
                        <div>
                            <label><?php _e('Choose a Image', 'suite'); ?></label>
                            <input type="file" id="myfile" name="myfile" />
                            <label id="mess"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="<?php time() ?>" />
                    <input type="submit" value="<?php _e('Submit', 'suite'); ?>" id="btn_changeImg" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</div>
<!-- E ----------  phan cap nhat lai hinh hinh avata cua member ---->

<!--FORGET PASSWORD-->
<!--  B----------- hien thi popup lay lai password khi bi quen -->
<div class="modal fade" id="ForgetPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="f-getPass" id="f-getPass" action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel"> <?php _e('取回新密碼', 'suite'); ?></h4>
                    <image id="waiting-img" name="waiting-img" src="<?php echo PART_IMAGES . 'loading.gif' ?>" />
                    <div style=" clear: both"></div>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="label-title" style="margin-right: 29px;"><?php _e('帳號 :', 'suite') ?></label>
                        <input type="text" style="width:250px" maxlength="9" placeholder="<?php _e('帳號', 'suite'); ?>" id="g-passport" name="g-passport" />
                        <label id="passportMess" style="margin-left: 10px" class="error-mess"></label>
                    </div>
                    <div style=" margin-top: 5px">
                        <label class="label-title"><?php _e('電郵信箱 :', 'suite') ?></label>
                        <input type="text" style="width:250px" placeholder="<?php _e('電郵信箱', 'suite'); ?>" id="g-email" name="g-email" />
                        <label id="emailMess" style="margin-left: 10px" class="error-mess"></label>
                    </div>
                    <div style=" text-align: center; margin-top: 5px;"><label id="forgetPassMess" style=" font-size: 20px; color: blue" class="error-mess"></label></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit-getPass" class="btn btn-primary"><?php _e('Submit', 'suite'); ?></button>
                    <button type="reset" id="cancel-getPass" class="btn btn-primary"><?php _e('Cancel', 'suite'); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal -->

</div>

<!--  E----------- hien thi popup lay lai password khi bi quen -->

<style>
    .my_i {
        font-size: 12px;
    }
</style>
<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function() {
        jQuery("#myfile").on("change", function() {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function() { // set image data as background of div
                    jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
            }
        });
    });
</script>

<!-- chuyen data den trang ajax  -->
<script type="text/javascript">
    // tại bien de chuyen dg link sang cho js toi file .php de xu va tra ve ket qua sau khi xu ly
    var objLoginData = {
        url: '<?php echo PART_AJAX . 'login.php' ?>'
    };
    // phan quen mat khau xin lai mat khau mmoi    
    var obForgetPass = {
        url: '<?php echo PART_AJAX . 'forgetpass.php' ?>'
    };


    //goi ajax de thay doi hinh avatar cua member
    var objAvatarData = {
        url: '<?php echo PART_AJAX . 'changeavatar.php' ?>'
    };

    jQuery(document).ready(function() {
        jQuery('#btn-registry').click(function() {
            window.location = ('<?php echo home_url('/register/'); ?>');
        });

        // PHAN LAY LAI PASSWORD BI QUEN
        // KHI CLICK SUBMIT CHO SHOW HINIH WIATING
        jQuery('#submit-getPass').click(function() {
            jQuery('#waiting-img').show();
        });
        // KHI NHAP LAI EMAIL XOA CAU THONG BAO
        jQuery('#g-email').keypress(function() {
            jQuery('#forgetPassMess').text('');
            jQuery('#emailMess').text('');
        });
        jQuery('#g-passport').keypress(function() {
            jQuery('#forgetPassMess').text('');
            jQuery('#passportMess').text('');
        });
        //NUT CANCEL
        jQuery('#cancel-getPass').click(function() {
            jQuery('#ForgetPass').modal('hide');
            jQuery('#g-email').val('');
            jQuery('#forgetPassMess').text('');
            jQuery('#emailMess').text('');
            jQuery('#passportMess').text('');
        });


    });
</script>