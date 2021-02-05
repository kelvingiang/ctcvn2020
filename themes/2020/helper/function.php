<?php

require_once ( HELPER . 'function-post-list.php');
/* ======  GET  HINH THEO PATH ========= */

function get_member_img($img = '') {
    return WB_URL_IMAGES_MEMBER . $img;
}

function get_qrcode_img($barcode = '') {
    return WB_URL_IMAGES_QRCODE . $barcode . '.png';
}

/* KIEM TRA CO SUBMIT FROM KHONG */

function isPost() {
    $flag = ($_SERVER['REQUEST_METHOD'] == 'POST') ? TRUE : FALSE;
    return $flag;
}

/* NHAN ID TRA VE TEN CAC PHAN HOI */

function get_country($countryCode) {
    switch ($countryCode) {
        case '0001':
            $country = '越南總會';
            break;
        case '0080':
            $country = '胡志明分會';
            break;
        case '0390':
            $country = '河靜分會';
            break;
        case '0640':
            $country = '頭頓分會';
            break;
        case '0081':
            $country = '新順分會';
            break;
        case '0241':
            $country = '北寧分會';
            break;
        case '0660':
            $country = '西寧分會';
            break;
        case '0720':
            $country = '隆安分會';
            break;
        case '0650':
            $country = '平陽分會';
            break;
        case '0610':
            $country = '同奈分會';
            break;
        case '0630':
            $country = '林同分會';
            break;
        case '0511':
            $country = '峴港分會';
            break;
        case '0310':
            $country = '海防分會';
            break;
        case '0360':
            $country = '太平分會';
            break;
        case '0040':
            $country = '河內分會';
            break;
    }
    return $country;
}

/* KIEM TRA DU LIEU CO CHINH XAC VA LOI KHONG */

function getValidate($filename = '', $dir = '') {
    $obj = new stdClass();
    $file = VALIDATE_DIR . $dir . DS . $filename . '.php';
    if (file_exists($file)) {
        require_once $file;
        $validateName = 'Admin_' . $filename . '_Validate';
        $obj = new $validateName ();
    }
    return $obj;
}

/*  GET  A THAM SO TREN THANH URL */

function getParams($name = null) {
    if ($name == null || empty($name)) {
        return $_REQUEST; // TRA VE GIA TRI REQUEST
    } else {
        // TRUONG HOP name DC CHUYEN VAO 
        // KIEM TRA name CO TON TAI TRA VE name NGUOI ''
        $val = (isset($_REQUEST[$name])) ? $_REQUEST[$name] : ' ';
        return $val;
    }
}

function get_lib($name = '') {
    return get_template_directory() . '/lib/' . $name;
}

/* * ********************
 * GET SRC OF IMAGES
 * ******************* */

/* === get url ==============  */

function get_image($name = '') {
    return WB_URL_IMAGES . $name;
}

function get_icon($name = '') {
    return WB_URL_ICON_DIR . $name;
}

function get_lib_uri($name = '') {
    return get_template_directory_uri() . '/class/' . $name;
}

function get_workshop_uri($name = '') {
    return get_template_directory_uri() . '/lib/PHPImageWorkshop/' . $name;
}

function get_avata($name) {
    return WB_DIR_IMAGES_AVATA . $name;
}

function custom_redirect($location) {
    global $post_type;
    $location = admin_url('edit.php?post_type=' . $post_type);
    return $location;
}

function get_page_permalink($name) {
    if (!empty($name)) {
        $dataPage = get_page_by_title($name);
        $id = $dataPage->ID;
        return get_page_link($id);
    }
    return false;
}

//====== functions  ===================================================
// kiem tra doi tuong da ton tai chu
// $filed = ten filed trong database
// $value = gia tri tim kiem trong $field
// $error_mess = noi dung cau thong bao tra ve
function checkExists($field, $value, $error_mess) {
    $strField = $field;
    $strValue = $value;

    $arrArgs = array(
        'post_type' => 'member',
        'meta_query' => array(
            array(
                'key' => $strField,
                'value' => $strValue
            )
        )
    );

    $arrUsers = get_posts($arrArgs);

    if (count($arrUsers) > 0) {
        $return['error'] = 'exists';
        $return['mess'] = $error_mess;
        return $return;
    }
}

// kiem tra string
// $element = doi tuong input can kiem tra
// $min = so ky tu nho nhat
// $max = so ky tu lon nhat
function checkstr($element, $min = 2, $max = 5000) {
    $length = strlen($element);
    if (empty($length)) {
        return __('plaese require this', 'suite');
    } elseif ($length < $min) {
        return __('min', 'suite') . $min . __('characters', 'suite');
    } elseif ($length > $max) {
        return __('max', 'suite') . $max . __('characters', 'suite');
    }
//   return true;
}

// kiem tra email
function checkemail($element) {
    if ($element == '') {
        return __('plaese require this', 'suite');
    } else if (!filter_var($element, FILTER_VALIDATE_EMAIL)) {
        return __('this email exists', 'suite');
    }
}

// kiem tra captcha
function checkcaptcha($elenment) {
    if ($elenment == '') {
        return __('Requied', 'suite');
    } elseif ($elenment !== $_SESSION['captcha']) {
        return __('Capcha Not Matching', 'suite');
    }
}

/* ================================================
  SEND MAIL FUNTION
  =================================================== */

function registrySendMail($mailTo, $name, $user, $password) {
    $subject = '越南台灣商會聯合總會-會員註冊';
    $message = '<h2>' . $name . ': 您好 ! </h2> <br>';
    $message .= '<h3> 歡迎您成為"越南台灣商會聯合總會"網頁的會員 </h3>';
    $message .= '<p> 您註冊帳號 :' . $user . ' </p>';
    $message .= '<p> 帳號密碼    :' . $password . ' </p>';
    $message .= '<a href ="http://ctcvn.vn" target="_blank"> 越南台灣商會聯合總會網頁</a><br>';
    $message .= '<a href ="http://ctcvn.vn" target="_blank"> ctcvn.vn</a><br>';
    $message .= '謝謝';
    wp_mail($mailTo, $subject, $message);
}

function uploadFile($name, $File) {
    if (!empty($File['file_upload']['name'])) {
        $errors = array();
        $file_name = $File['file_upload']['name'];
        $file_size = $File['file_upload']['size'];
        $file_tmp = $File['file_upload']['tmp_name'];
        $file_type = $File['file_upload']['type'];

        $file_trim = ((explode('.', $File['file_upload']['name'])));
        $trim_name = strtolower($file_trim[0]);
        $trim_type = strtolower($file_trim[1]);

        $cus_name = $name . '.' . $trim_type;
        $extensions = array("jpeg", "jpg", "png", "bmp");
        if (in_array($trim_type, $extensions) === false) {
            $errors[] = "上傳照片檔案是 JPEG, PNG, BMP.";
        }
        if ($file_size > 2097152) {
            $errors[] = '上傳檔案容量不可大於 2 MB';
        }
        $path = WP_CONTENT_DIR . DS . 'themes' . DS . 'suite' . DS . 'images' . DS . 'apply' . DS; /* get function path upload img dc khai bao tai file hepler */

        if (empty($errors) == true) {

            if (is_file(WB_DIR_APPLY . $name)) {
                unlink(WB_DIR_APPLY . $name);
            }
            move_uploaded_file($file_tmp, ( $path . $cus_name));
            return $cus_name;
        } else {
            return $errors;
        }
    }
}

//Remove JQuery migrate

function remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
// Check whether the script has any dependencies

            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}

add_action('wp_default_scripts', 'remove_jquery_migrate');
/* ================================================
  VOTE ALL FUNCTION
  =================================================== */

function VoteTotalLishi() {
    $tt = get_option('_vote_total_lishi') + 1;
    update_option('_vote_total_lishi', $tt);
    /* return get_option('_vote_total_lishi'); */
}

function VoteTotalLishifail() {
    $tt = get_option('_vote_total_lishi_fail') + 1;
    update_option('_vote_total_lishi_fail', $tt);
    /* return get_option('_vote_total_lishi'); */
}

function VoteTotalJianshi() {
    $tt = get_option('_vote_total_jianshi') + 1;
    update_option('_vote_total_jianshi', $tt);
    /* return get_option('_vote_total_jianshi'); */
}

function VoteTotalJianshifail() {
    $tt = get_option('_vote_total_jianshi_fail') + 1;
    update_option('_vote_total_jianshi_fail', $tt);
    /*  return get_option('_vote_total_lishi'); */
}

function voteTotal($kid) {
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT  sum(vote_total) as 'total' FROM $table WHERE `kind` = $kid";
    $row = $wpdb->get_row($sql, ARRAY_A);
    return $row;
}

function getVoteResult($kid) {
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `kind` = $kid AND `status` = 1 ORDER BY `agree` DESC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteFinalResult() {
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `position` != '0' AND `status` = 1 ORDER BY `position`, `is_order` ASC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteOrder($kid) {
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `kind` = $kid AND `status` = 1 ORDER BY `vote_total` DESC";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function getVoteListByKid($kid) {
    global $wpdb;
    $table = $wpdb->prefix . 'vote';
    $sql = "SELECT * FROM $table WHERE `kind` = $kid AND `status` = 1";
    $row = $wpdb->get_results($sql, ARRAY_A);
    return $row;
}

function updateVoteCount($id) {
    global $wpdb;
    /* PLUS VOTE COUNT */
    $table = $wpdb->prefix . 'vote';
    $updateSql = "UPDATE $table SET total=total + 1 WHERE ID=$id";
    $wpdb->query($updateSql);
}

function userVoteSuccess() {
    global $wpdb;
    /* SET USER VOTED */
    $table = $wpdb->prefix . 'guests';
    $updateSql = "UPDATE $table SET check_in = 1 WHERE ID = " . $_SESSION['voteLogin']['ID'];
    $wpdb->query($updateSql);

    unset($_SESSION['voteLogin']);
}

function kid_name($id) {
    /* $arr = array('1' => '理事', '2' => '監事'); */
    if ($id == 1) {
        $val = "總會長";
    } elseif ($id == 2) {
        $val = '監事長';
    }
    return $val;
}

function voteLogin($user, $pass) {
    global $wpdb;
    $table = $wpdb->prefix . 'guests';
    $sql = "SELECT ID, full_name, barcode, stt FROM $table WHERE `stt` = $user AND `barcode` = $pass AND `status` = 1 AND `check_in` = 0";
    $row = $wpdb->get_row($sql, ARRAY_A);
    if (!empty($row)) {
        $_SESSION['voteLogin'] = $row;
        wp_redirect(home_url('vote'));
    } else {
        return "登入失敗-請檢查帳號或密碼";
    }
}
