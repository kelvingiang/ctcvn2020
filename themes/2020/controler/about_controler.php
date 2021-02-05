<?php

class Admin_About_Controler {

    public function __construct() {
        add_action('admin_menu', array($this, 'aboutToMenu'));
    }

    public function aboutToMenu() {
        // THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = '關於商會'; // TIEU DE CUA TRANG 
        $menu_title = '關於商會';  // TEN HIEN TRONG MENU
// CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'tw_about'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
// THAM SO THU 5 GOI DEN HAM HIEN THI GIAO DIEN TRONG MENU
        $icon = WB_URL_ICON_DIR . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 17; // VI TRI HIEN THI TRONG MENU

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
                $this->deleteAction();
                break;
            case 'trash':
                $this->trashAction();
                break;
            case 'uncheckin':
                $this->uncheckinAction();
                break;
            case 'restore':
                $this->restoreAction();
                break;
            default :
                $this->displayPage();
                break;
        }
    }

    public function createUrl() {
        echo $url = 'admin.php?page=' . getParams('page');

//filter_status
        if (getParams('filter_branch') != '0') {
            $url .= '&filter_branch=' . getParams('filter_branch');
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
        require_once (VIEW_DIR . 'about_view.php');
    }

// THEM MOI ITEM
    public function addAction() {

// KIEM TRA PHUONG THUC GET HAY POST
        if (isPost()) {
            require_once (MODEL_DIR . 'check_in_model.php');
            $model = new Admin_Check_In_Model();
            $model->saveItem($_POST);
            
            $paged = max(1, $arrParams['paged']);
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
            wp_redirect($url);
        }
        require_once( VIEW_DIR . 'check_in_from.php');
//require_once( VIEW_DIR . 'test.php');
    }

// EDIT SCHEDULE
    public function editAction() {
// HAM isPost() DUNG KIEM TRA DU  LIEU CHUYEN SANG BANG DANG post HAY get
// KHI MOI SHOW TRANG RA O DANG GET CHI THUC HIEN VIEC SHOW DU LIEU
// KHI DC SUBMIT LA O DANG POST PHAI update HAY insert DU LIEU
        if (isPost()) {
            require_once (MODEL_DIR . 'check_in_model.php');
            $model = new Admin_Check_In_Model();
           $model->saveItem($_POST);
        } else {
// CHUA SUBMIT DATA GET
//   echo 'phuong thuc get';
            require_once (MODEL_DIR . 'check_in_model.php');
            $getID = new Admin_Check_In_Model();
            $data = $getID->get_item(getParams());  // bien data nay chuyen chuyen du lieu sang trang form va do du lieu vao cac textbox 
        }
//SHOW PHAN FORM DU LIEU
        require_once( VIEW_DIR . '/check_in_from.php');
    }

    public function uncheckinAction() {
        $arrParams = getParams();
        require_once (MODEL_DIR . 'check_in_model.php');
        $model = new Admin_Check_In_Model();
        $model->uncheckinItem($arrParams);
        
       if($arrParams['check'] == 0 && !is_array($arrParams['id'])){
            $model->checkin($arrParams);
        }
        // TRA VE TRANG MAC DINH
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

// XOA DU LIEU
    public function deleteAction() {
        $arrParam = getParams();
        require_once (MODEL_DIR . 'check_in_model.php');
        $model = new Admin_Check_In_Model();
        $model->deleteItem($arrParam);

        $paged = max(1, $arrParam['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

    public function restoreAction() {
        $arrParams = getParams();
//        if (!is_array($arrParams['id'])) {
//            $action = $arrParams['action'] . '_id_' . $arrParams['id'];
//            
//            check_admin_referer($action, 'security_code');
//        } else {
//            wp_verify_nonce('_wpnonce');
//        }
        require_once (MODEL_DIR . 'check_in_model.php');
        $model = new Admin_Check_In_Model();
        $model->restoreItem($arrParams);
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';

        wp_redirect($url);
    }

    public function trashAction() {
        $arrParams = getParams();
//        if (!is_array($arrParams['id'])) {
//            $action = $arrParams['action'] . '_id_' . $arrParams['id'];
//            
//            check_admin_referer($action, 'security_code');
//        } else {
//            wp_verify_nonce('_wpnonce');
//        }
        require_once (MODEL_DIR . 'check_in_model.php');
        $model = new Admin_Check_In_Model();
        $model->trashItem($arrParams);
        // TRA VE TRANG MAC DINH
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

}

