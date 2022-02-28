<?php
// include WordPress
define('WP_USE_THEMES', false);
require('../../../../wp-load.php');

$email = esc_attr($_POST['g-email']);
$passport = esc_attr($_POST['g-passport']);

$arrEmail = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_email', 'value' => $email),
    )
);

$arrPassport = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_user', 'value' => $passport),
    )
);

$arrForget = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_email', 'value' => $email),
        array('key' => 'm_user', 'value' => $passport),
    )
);

$objEmail = current(get_posts($arrEmail));
if(!$objEmail){$errEmail = '電郵信箱不正確!';}else{$errEmail='';}

$objPassport = current(get_posts($arrPassport));
if(!$objPassport){$errPassport = '帳號不正確';}else{$errPassport = '';}

$objForget = current(get_posts($arrForget));
if ($objForget) {
    $getMeta = get_post_meta($objForget->ID);
    $newPass     = myramdom(); // tao password moi
    $newmd5     = md5($newPass); // tao password moi

  //UPDATE LAI PASSWORD
    update_post_meta($objEmail->ID,'m_password', $newmd5);
  // SEND PASSWORD MOI CHO USER
        $to = $email;
        $subject = 'GET PASSWORD FORM TAIWAN WEB SITE';
        $message  =  '<h4>' . $getMeta['m_user'][0] .' 您好 ! </h4>'; 
        $message .=  '<p> 您的越南台灣商會聯合總會網站的新密碼是 '.  $newPass .'</p>';
// kieu data show trong mail
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        wp_mail($to, $subject, $message);
    $response = array(
        'status' => 'done',
        'message' => __('請檢查郵箱取得新密碼'),
        'md5' => $newmd5,
    );
} else {
    if($errEmail==''){$errEmail='電郵信箱和戶照編號不匹配';}
    if($errPassport==''){$errPassport='帳號和電郵信箱不匹配';}
    $response = array(
        'status'      => 'error',
        'email' => $errEmail,
        'passport'  => $errPassport,
    ); 
}
function myramdom(){
        $length = 8;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        return $randomString;
}
echo json_encode($response);
?>
