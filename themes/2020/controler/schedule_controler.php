<?php

class Admin_Schedule_Controler {

    public function __construct() {
        add_action('admin_menu', array($this, 'scheduleToMenu'));
    }

    public function scheduleToMenu() {
// THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = '行事曆'; // TIEU DE CUA TRANG 
        $menu_title = '行事曆 ';  // TEN HIEN TRONG MENU
// CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'tw_schedule'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
// THAM SO THU 5 GOI DEN HAM HIEN THI GIAO DIEN TRONG MENU
        $icon = WB_URL_ICON_DIR . '/schedule16x16.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 16; // VI TRI HIEN THI TRONG MENU

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'), $icon, $position);
    }

// Phan dieu huong 
    public function dispatchActive() {
        $action = getParams('action');
        switch ($action) {
            case 'add':
                $this->addAction();
                break;
            case 'edit':
                $this->editAction();
                break;
            case 'delete':
                $this->deteleAction();
                break;
            case 'sendMail':
                $this->sendMailAction();
                break;
            case 'active':
            case 'inactive':
                $this->statusAction();
                break;
            default :
                $this->displayPage();
                break;
        }
    }

    public function createUrl() {
        echo $url = 'admin.php?page=' . getParams('page');

//filter_status
        if (getParams('filter_status') != '0') {
            $url .= '&filter_status=' . getParams('filter_status');
        }

        if (mb_strlen(getParams('s'))) {
            $url .= '&s=' . getParams('s');
        }

        return $url;
    }

//---------------------------------------------------------------------------------------------
// Cmt CAC CHUC NANG THEM XOA SUA VA HIEN THI
//---------------------------------------------------------------------------------------------
// CAC DISPLAY PAGE
    public function displayPage() {
// LOC DU LIEU KHI action = -1 CO NGHIA LA DANG LOI DU LIEU (CHO 2 TRUONG HOP search va filter)
        if (getParams('action') == -1) {
            $url = $this->createUrl();
            wp_redirect($url);
        }
// NEN TACH ROI HTML VA CODE WP RA CHO DE QUAN LY
        require_once (VIEW_DIR . 'schedule_view.php');
    }

// THEM MOI ITEM
    public function addAction() {

// KIEM TRA PHUONG THUC GET HAY POST
        if (isPost()) {
// KHI POST KIEM TRA LOI NHAP LIEU
            $validates = getValidate('schedule');
            if ($validates->isValidate() == FALSE) {
                if (getParams('security_code') != ' ') {
//echo '</br> HIEN THI THONG BAO ERROR';
                    $error = $validates->getFormError();
                    $data = $validates->getFormdata();
                }
            } else {
// HET LOI insert DU LIEU VAO database
// echo '</br>CAP NHAT VAO DATABASE';
                $formaData = $validates->getFormdata();

                require_once (MODEL_DIR . 'schedule_model.php');
                $save = new Admin_Schedule_Model();
                $save->save_item($formaData);
             //   $page = getParams('page');
              //  $linkSendMail = admin_url('admin.php?page=' . $page . '&action=sendMail');
               // $linkBack = admin_url('admin.php?page=' . $page);
                // SESION NAY TAI DE LAY DATA SEND MAIL CHO CAC THANH VIEN
               // $_SESSION['sendMailContent'] = $formaData;
              //  if (!isset($_GET['send'])) {
                    ?>
<!--                    <script type="text/javascript">
                        if (confirm("此內容是否寄Email給會員們!") === true) {
                            //   jQuery.cookie('send-mail', null, {expires: -1});
                            //  jQuery.cookie('send-mail', 'true');
                            window.location.replace("<?php// echo $linkSendMail ?>")
                        } else {
                            window.location.replace("<?php// echo $linkBack ?>")
                            //   jQuery.cookie('send-mail', null, {expires: -1});
                            //   jQuery.cookie('send-mail', 'flase');
                        }
                        //window.location.reload();
                        // location.reload();
                        console.log(jQuery.cookie('send-mail'));
                    </script>-->
                    <?php
              //  }

// SAU KHI INSERT XONG CHUYEN VE TRANG SHOW
//    $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
//   wp_redirect($url);
            }
        }
        require_once( VIEW_DIR . 'schedule_from.php');
//require_once( VIEW_DIR . 'test.php');
    }

// EDIT SCHEDULE
    public function editAction() {
// HAM isPost() DUNG KIEM TRA DU  LIEU CHUYEN SANG BANG DANG post HAY get
// KHI MOI SHOW TRANG RA O DANG GET CHI THUC HIEN VIEC SHOW DU LIEU
// KHI DC SUBMIT LA O DANG POST PHAI update HAY insert DU LIEU
        if (isPost()) {
// DA SEND DATA POST
// GOI FUNCTION isValidate DE KIEM TRA LOI DU LIEU NHAP VAO
// NEU CO LOI THONG BAO DANG LOI textbox SE BI RONG,  CAC textbox CO DU LIEU DUNG SE DC GIU LAI
            $validates = getValidate('schedule');
            if ($validates->isValidate() == FALSE) {
                if (getParams('security_code') != ' ') {
                    $error = $validates->getFormError();
                    $data = $validates->getFormdata();
                }
            } else {
// KHI HET LOI SE update DU LIEU VAO DATABASE
                require_once (MODEL_DIR . '/schedule_model.php');
                $formaData = $validates->getFormdata();
// GOI DE function save_item DE UPDATE DU LLEU
                $save = new Admin_Schedule_Model();
                $save->save_item($formaData);
                // PHAN DIEU KIEN SEND MAIL
               // $page = getParams('page');
              //  $linkSendMail = admin_url('admin.php?page=' . $page . '&action=sendMail');
              //  $linkBack = admin_url('admin.php?page=' . $page);
              //  $_SESSION['sendMailContent'] = $formaData;
               // if (!isset($_GET['send'])) {
                    ?>
<!--                   <script type="text/javascript">
                    //    if (confirm("此內容是否寄Email給會員們!") === true) {
                            //   jQuery.cookie('send-mail', null, {expires: -1});
                            //  jQuery.cookie('send-mail', 'true');
                            window.location.replace("<?php  //echo $linkSendMail ?>");
                        } else {
                            window.location.replace("<?php //echo $linkBack ?>");
                            //   jQuery.cookie('send-mail', null, {expires: -1});
                            //   jQuery.cookie('send-mail', 'flase');
                        }
                        //window.location.reload();
                        // location.reload();
                        console.log(jQuery.cookie('send-mail'));
                    </script>-->
                    <?php
//                }
// SAU KHI UPDATE XONG CHUYEN VE TRANG SHOW
                //   $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
                // wp_redirect($url);
            }
        } else {
// CHUA SUBMIT DATA GET
//   echo 'phuong thuc get';
            require_once (MODEL_DIR . '/schedule_model.php');
            $getID = new Admin_Schedule_Model();
            $data = $getID->get_item(getParams());  // bien data nay chuyen chuyen du lieu sang trang form va do du lieu vao cac textbox 
        }
//SHOW PHAN FORM DU LIEU
        require_once( VIEW_DIR . '/schedule_from.php');
    }

// XOA DU LIEU
    public function deteleAction() {

        $arrParam = getParams();
        if (!is_array($arrParam['id'])) {
            $action = 'delete_id' . $arrParam['id'];
            check_admin_referer($action, 'security_code');
        } else {
            wp_verify_nonce('_wpnonce');
        }
        require_once (MODEL_DIR . 'schedule_model.php');
        $model = new Admin_Schedule_Model();
        $model->deleteItem($arrParam);
        $paged = max(1, $arrParam['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
        wp_redirect($url);
    }

    public function statusAction() {
        $arrParam = getParams();

// VONG KIEM TR BAO MAT
        if (!is_array($arrParam['id'])) {
            $action = $arrParam['action'] . '_id_' . $arrParam['id'];
            check_admin_referer($action, 'security_code'); // KIEM TRA CODE BAO MAT
        } else {
            wp_verify_nonce('_wpnonce');
        }

// GOI DEN MODEL 
        require_once (MODEL_DIR . '/schedule_model.php');
        $model = new Admin_Schedule_Model();
        $model->changeStatus($arrParam);

        $paged = max(1, $arrParam['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

    public function sendMailAction() {
        require_once (MODEL_DIR . '/schedule_model.php');
        $model = new Admin_Schedule_Model();
        // SESION DUOC TAO TREN HAM addAction
        $model->sendMail($_SESSION['sendMailContent']);
    }

}

