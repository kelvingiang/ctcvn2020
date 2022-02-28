<?php
$uri = $_SERVER['REQUEST_URI'];  // lay url tai trang hien hanh
// ======KIEM TRA INPUT BANG FUNCTION DUOC VIET TAI FILE RECRUIT==========
$r_error = array();
$status = 'on';
$loginID = $_SESSION['login_id'];

// ================ LAY GIA TRI TIN DA DANG DE EDIT===========================
if (isset($_GET['id'])) {

    $getID = (int) $_GET['id'];
    $arrArgs = array(
        'post_type' => 'recruitment',
        'post__in' => array($getID),
    );
    $objRec = current(get_posts($arrArgs));
    $postMeta = get_post_meta($objRec->ID); // lay cac gia tri trong meta

    $r_id = $_GET['id'];
    $r_title = get_the_title($objRec->ID); // lay title
    $status = $postMeta['_recruit_status'][0];
    $r_fullname = $postMeta['_recruit_fullname'][0];
    $r_birthday = $postMeta['_recruit_birthday'][0];
    $r_sex = $postMeta['_recruit_sex'][0];
    $r_address = $postMeta['_recruit_address'][0];
    $r_email = $postMeta['_recruit_email'][0];
    $r_phone = $postMeta['_recruit_phone'][0];
    $r_level = $postMeta['_recruit_level'][0];
    $r_experience = $postMeta['_recruit_experience'][0];
    $r_another = $postMeta['_recruit_another'][0];
    // add new 09/04/2020
    $r_height = $postMeta['_recruit_height'][0];
    $r_department = $postMeta['_recruit_department'][0];
    $r_work = $postMeta['_recruit_work'][0];
    $r_job = $postMeta['_recruit_job'][0];
    $r_salary = $postMeta['_recruit_salary'][0];
    $r_industry = $postMeta['_recruit_industry'][0];
    $r_language = $postMeta['_recruit_language'][0];
    $r_license = $postMeta['_recruit_license'][0];
    $r_software = $postMeta['_recruit_software'][0];
    $r_drive = $postMeta['_recruit_drive'][0];
    $r_line = $postMeta['_recruit_line'][0];
    $m_img = get_post_meta($loginID, 'm_img', true);
} else {
    // LAY GIA TRI CAN BAN CUA THANH VIEN GAN VAO KHONG TAO MOI
    $r_fullname = get_post_meta($loginID, 'm_fullname', true);
    $r_birthday = get_post_meta($loginID, 'm_birthdate', true);
    $r_address = get_post_meta($loginID, 'm_address', true);
    $r_email = get_post_meta($loginID, 'm_email', true);
    $r_phone = get_post_meta($loginID, 'm_phone', true);
    $r_sex = get_post_meta($loginID, 'm_sex', true);
    $m_img = get_post_meta($loginID, 'm_img', true);
}

//======== INSERT DATE  TO DATABASE========================================
if ($_POST & !isset($_GET['id'])) {

    //======== INSERT NEW INFO TO DATABASE========================================
    //  echo 'loi'.$r_error;
    if (empty($r_error)) {
        $catePost = 9; // SO ID CUA CATEGORY
        $cat = array($catePost);
        //    $editor_settings = Common::$_wpeditor;
        $newRecruit = array(
            'post_title' => esc_attr($_POST['txt_title']),
            'post_content' => $_POST['another'],
            'post_category' => $cat,
            'post_status' => 'publish',
            'post_type' => 'recruitment'
        );
        //add post moi
        $recMeta = wp_insert_post($newRecruit);
        // them catetegory cho post
        wp_set_object_terms($recMeta, $cat, 'recruitment_category');
        // Save phan metabox active //
        recruitmentMetaBox($recMeta, $_POST);
        // insertt xong xao trang cac gia tri input
        $status = "";
        $r_title = "";
        $r_fullname = "";
        $r_birthday = "";
        $r_sex = "";
        $r_address = "";
        $r_email = "";
        $r_phone = "";
        $r_level = "";
        $r_experience = "";
        $r_another = "";
        // add new 09/04/2020
        $r_height = "";
        $r_department = "";
        $r_work = "";
        $r_job = "";
        $r_salary = "";
        $r_industry = "";
        $r_language = "";
        $r_license = "";
        $r_software = "";
        $r_drive = "";
        if (empty($r_error)) {
            wp_redirect(esc_url(remove_query_arg('id', $uri))); // PHAN NAY XOA ID TRAN URL VA CHAN KHONG CO INSERT KHI  REFRESH
        }
    }
}
//}
//======== UPDATE DATE  TO DATABASE========================================
if ($_POST & isset($_GET['id'])) {

    $postID = $_POST['hid_id'];
    $arrUpdate = array(
        'ID' => $postID,
        'post_title' => esc_attr($_POST['txt_title'])
    );

    wp_update_post($arrUpdate);
    $r_error = recruitmentMetaBox($postID, $_POST);
    if (empty($r_error)) {
        wp_redirect(esc_url(remove_query_arg('id', $uri)));
    }
}

// ================ XOA TIN DA DANG ===========================            
if (!$_GET['del'] == '') {
    wp_trash_post($_GET['del']);
    wp_redirect(esc_url(remove_query_arg('del', $uri)));
}

// ================ LAY VA TIN DA DANG BOI USER DANG NHAP===========================
$arrRec = array(
    'post_type' => 'recruitment',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'recruitment_category' => 'ungtuyen',
    'meta_query' => array(
        array(
            'key' => '_recruit_postby',
            'value' => $_SESSION['login'],
        )
    )
);
$myQuery = new WP_Query($arrRec);
?>

<style>
#add_new {
    cursor: pointer;
    color: #005082;
    font-size: 1.1em;
    border: 1px #999 solid;
    border-radius: 3px;
    padding: 5px 5px;
    text-align: center;
    font-weight: bold;
    background-color: #ddd;
    opacity: 0.7;
}

#add_new i {
    font-size: 0.8em;
}

#add_new:hover {
    opacity: 1;
}

.add_new_space {
    display: none;
}

.e {
    color: #c68953;
}

.v {
    color: #858586;
}

.row_end {
    border-bottom: 1px #e2e1e1 dotted;
    height: 1px;
    margin: 5px;
}
</style>

<div>
    <div class='head-title'>
        <div class="title">
            <h2 class="head"> <?php _e('求職資料表', 'suite'); ?> </h2>
        </div>
    </div>
    <div>
        <?php if (!isset($_GET['id'])) { ?>
        <div style=" letter-spacing: 1px"> <label id="add_new">新增履歷<i> thêm lý lịch </i></label></div>
        <?php } ?>
        <div class="add_new_space">
            <form id="f_recruit_ungtuyen" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $r_id ?>" />
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <lable for="status" class="label-title" style="margin-right: 30px; font-weight: bold">
                            <?php _e('Active', 'suite') ?>,
                            <i class="e">Active</i>,
                            <i class="v">Kích Hoạt</i>
                        </lable>
                        <input type="checkbox" name="chk_status" id="chk_status"
                            <?php echo $status === 'on' ? 'checked' : ""; ?> />
                    </div>
                    <div class="col-md-12"><label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_title"><?php _e('Title', 'suite'); ?>,
                            <i class="e">Title</i>,
                            <i class="v">Tiêu Đề</i></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" required name="txt_title" id="txt_title"
                            value="<?php echo $r_title ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row ">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_fullname"><?php _e('Full Name', 'suite'); ?>,
                            <i class="e">Full Name</i>,
                            <i class="v">Họ và Tên</i></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" required name="txt_fullname" id="txt_fullname"
                            value="<?php echo $r_fullname ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>

                </div>
                <div class="row" style=" display: block">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="label-title"><?php _e('照片上傳', 'suite'); ?>,
                            <i class="e">Upload Image</i>,
                            <i class="v">Hình Đại Diện </i></label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <input type="file" name="file_upload" id="file_upload" accept="image/*" />
                    </div>
                    <div class='col-md-3 col-sm-3 col-xs-12'>
                        <?php if (!empty($m_img)) { ?>
                        <img src="<?php echo PART_IMAGES_APPLY . $m_img ?>" width="100px" />
                        <?php } ?>
                    </div>
                    <div class='col-md-2 col-sm-2 col-xs-12'>
                        <?php foreach ($r_error as $va) { ?>
                        <label style="color: red"> <?php echo $va ?></label><br>
                        <?php } ?>
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_birthday"><?php _e('Brith of date', 'suite'); ?>,
                            <i class="e">Birth of date</i>,
                            <i class="v">Ngày sinh</i></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" maxlength="10" required class="MyDate" name="txt_birthday" id="txt_birthday"
                            value="<?php echo $r_birthday ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title"><?php _e('Sex', 'suite'); ?>,
                            <i class="e"> Gender</i>,
                            <i class="v">Giới Tính</i></label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="sel_sex" name="sel_sex" class="selectmenu" style="width: 180px">
                            <option value="1" <?php echo $r_sex == 1 ? 'selected="selected"' : ''; ?>>
                                <?php _e('Male', 'suite'); ?></option>
                            <option value="2" <?php echo $r_sex == 2 ? 'selected="selected"' : ''; ?>>
                                <?php _e('Female', 'suite'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <input type="checkbox" name="chk_drive" id=" chk_drive"
                            <?php echo $r_drive == 'on' ? 'checked' : ''; ?> style=" margin-right: 10px">
                        <label class="label-title"><?php _e('具備駕駛執照', 'suite'); ?>,
                            <i class="e">Driving License </i>,
                            <i class="v">Bằng Lái Xe</i> </label>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-12">

                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_height"><?php _e('Height and weight', 'suite'); ?><br>
                            <i class="e"> Height - weight</i><br>
                            <i class="v">Chiều cao - cân nặng</i></label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_height" id="txt_height"
                            value="<?php echo $r_height ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_address"><?php _e('Address', 'suite'); ?>,
                            <i class="e"> Address </i>,
                            <i class="v"> Địa Chỉ </i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_address" id="txt_address"
                            value="<?php echo $r_address ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_email"><?php _e('Email', 'suite'); ?>,
                            <i class="e"> E-mail</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="email" class="form-control" name="txt_email" id="txt_email"
                            value="<?php echo $r_email ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_phone"><?php _e('Phone', 'suite'); ?>,
                            <i class="e">Phone</i>,
                            <i class="v">Điện Thoại</i>
                        </label>
                    </div>
                    <div class=" col-md-9 col-sm-9 col-xs-12">
                        <input type="text" maxlength="20" class="form-control type-phone" name="txt_phone"
                            id="txt_phone" value="<?php echo $r_phone ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_line"><?php _e('Line ID', 'suite'); ?></label>
                    </div>
                    <div class=" col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_line" id="txt_line"
                            value="<?php echo $r_line ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_level"><?php _e('Level', 'suite'); ?><br>
                            <i class="e">Education</i><br>
                            <i class="v">Trình Độ Văn Hoá</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" maxlength="20" class="form-control" name="txt_level" id="txt_level"
                            value="<?php echo $r_level ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_department"><?php _e('School Department', 'suite'); ?><br>
                            <i class="e"> School Department</i><br>
                            <i class="v">Ngành Học</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" maxlength="20" class="form-control" name="txt_department" id="txt_department"
                            value="<?php echo $r_department ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_experience"><?php _e('Experiences', 'suite'); ?><br>
                            <i class="e">Work Experiences</i><br>
                            <i class="v">Kinh Nghiệm</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_experience" id="txt_experience"
                            value="<?php echo $r_experience ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_work"><?php _e('最快可上班日', 'suite'); ?>,<br>
                            <i class="e">The fastest working day</i>,<br>
                            <i class="v">Ngày có thể đi làm sớm nhất</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" maxlength="10" class="MyDate" name="txt_work" id="txt_work"
                            value="<?php echo $r_work ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_job"><?php _e('希望職務類別', 'suite'); ?><br>
                            <i class="e"> Job Objective</i><br>
                            <i class="v">Chức vụ mong muốn</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_job" id="txt_job"
                            value="<?php echo $r_job ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_salary"><?php _e('希望薪資待遇', 'suite'); ?><br>
                            <i class='e'> Expected Salary</i><br>
                            <i class="v">Mức lương mong muốn</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_salary" id="txt_salary"
                            value="<?php echo $r_salary ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_industry"><?php _e('希望從事的產業別', 'suite'); ?><br>
                            <i class='e'>The industry wants to work</i><br>
                            <i class='v'>Ngành nghề mong muốn </i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_industry" id="txt_industry"
                            value="<?php echo $r_industry ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_language"><?php _e('語言能力', 'suite'); ?><br>
                            <i class="e">Languages Proficiency</i><br>
                            <i class="v">Ngôn Ngữ</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_language" id="txt_language"
                            value="<?php echo $r_language ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_license"><?php _e('證照資格', 'suite'); ?><br>
                            <i class="e">Certificates or Licenses</i><br>
                            <i class="v">Văn Bằng</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_license" id="txt_license"
                            value="<?php echo $r_license ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <label class="label-title" for="txt_software"><?php _e('擅長軟體', 'suite'); ?><br>
                            <i class="e">Skills</i><br>
                            <i class="v">Sử dụng tốt phần mềm</i>
                        </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input type="text" class="form-control" name="txt_software" id="txt_software"
                            value="<?php echo $r_software ?>">
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 row_end'> <label></label></div>
                </div>
                <div class="row">
                    <div class=" col-md-3 col-sm-3 col-xs-12"> <label class="label-title"><?php _e('自傳', 'suite'); ?>,
                            <i class='e'>Autobiography</i>,
                            <i class='v'>Ghi chú</i>
                        </label>
                    </div>
                    <!--  phan su dung ckeditor chua duoc      -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <textarea id="another" name="another" style="min-height: 300px">
                            <?php echo $r_another ?>
                        </textarea>
                        <script>
                        var editor = CKEDITOR.replace('another', {
                            customConfig: 'custom-config_no-img.js'
                        });
                        CKFinder.setupCKEditor(another, '<?php echo PART_CLASS . 'ckfinder/' ?>');
                        </script>
                    </div>
                </div>
                <div style=" text-align: center; padding: 25px">
                    <input id="btn-submit" type="submit" class="btn btn-primary"
                        value="<?php echo isset($_GET['id']) ? _e('Update', 'suite') : _e('Submit', 'suite'); ?> Gởi" />
                    <?php if (isset($_GET['id'])) { ?>
                    <input id="btn_reset" type="reset" class="btn btn-primary"
                        value="<?php _e('Cancel', 'suite'); ?> Huỷ"
                        onclick="javascript:window.location = '<?php echo home_url('recruit/?dt=1') ?>';" />
                    <?php } else { ?>
                    <input id="btn-reset" type="reset" class="btn btn-primary"
                        value='<?php _e('Reset', 'suite'); ?> Viết lại' />
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <hr style="border: 5px solid #666666">
    <?php
    global $post;
    if ($myQuery->have_posts()) :
        echo '<div class="list-item">';
        while ($myQuery->have_posts()) :
            $myQuery->the_post();
            $postMeta = get_post_meta($post->ID);
            // $active = $postMeta['r_active'][0];
    ?>
    <div class="row-item">
        <span>
            <label style="font-size: 16px; font-weight: bold; color: #666666"><?php the_title() ?></label>
        </span>
        <span style=" float: right">
            <a href="<?php the_permalink() ?>" target="_blank"><?php _e('View', 'suite'); ?> <i>xem</i></a> |
            <a class="edit-item" href="<?php echo esc_attr(add_query_arg('id', $post->ID)) ?>">
                <?php _e('Edit', 'suite'); ?><i> Sửa</i> </a> |
            <a href="#" class="del" data-id="del-<?php echo $post->ID ?>"
                data-href="<?php echo esc_attr(add_query_arg('del', $post->ID)) ?>"
                data-title=" <?php echo get_the_title($post->ID); ?>" data-toggle="modal" data-target="#confirm-delete">
                <?php _e('Delete', 'suite'); ?> <i>xoá</i> </a>
        </span>
    </div>

    <?php
        endwhile;
        echo '</div>';
    endif;
    wp_reset_postdata();
    ?>
</div>
<hr>

<?php
// PHAN LAY PARAM CUA URL CHUYEN CHO JAVASCRIPT DE TAO HIEU UNG SCROLL
if (isset($_GET['id'])) {
    $getid = $_GET['id'];
} else {
    $getid = 001;
}
?>
<script>
jQuery(document).ready(function() {

    if ('<?php echo $getID ?>' !== '') {
        jQuery(".add_new_space").slideDown('slow');
    }


    jQuery("#add_new").on("click", function() {
        jQuery(".add_new_space").toggle('slow');
        var dd = jQuery('.add_new_space').css('height');
        if (dd === '1px') {
            jQuery("#add_new").html('取消 <i>Huỷ</i>');
        } else {
            jQuery("#add_new").html('新增履歷<i> thêm lý lịch </i>');
        }
    });


    // LAY GIA TRI ID TAO HIEU UNG CUON
    var id = <?php echo $getid ?>;
    if (id !== '' && id !== 1) {
        jQuery('body,html').stop(false, false).animate({
            scrollTop: 790
        }, 1000);
    };
});
</script>