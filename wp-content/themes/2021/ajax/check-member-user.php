<?php

define('WP_USE_THEMES', false);
require('../../../../wp-load.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$user = $_POST['id'];


if (!empty($user)) {
    global $wpdb;
    $table = $wpdb->prefix . 'postmeta';
    $sql = "SELECT  COUNT(*) as `count` FROM $table WHERE `meta_value` = '$user'";
    $row = $wpdb->get_row($sql, ARRAY_A);



    if ($row['count'] == 0) {
        $response = array('status' => 'done', 'message' => $row);
    } else {
        // $_SESSION['checkinID'] = '0000';
        $response = array('status' => 'error', 'message' => 'da co nguoi su dung');
    }
}
echo json_encode($response);
