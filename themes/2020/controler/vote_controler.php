<?php

class Admin_Vote_Controler {

    public function __construct() {
        add_action('admin_menu', array($this, 'voteToMenu'));
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function voteToMenu() {
        // THEM 1 NHOM MENU MOI VAO TRONG ADMIN MENU
        $page_title = '投票系統'; // TIEU DE CUA TRANG 
        $menu_title = '投票系統';  // TEN HIEN TRONG MENU
// CHON QUYEN TRUY CAP manage_categories DE role ADMINNITRATOR VÀ EDITOR DEU THAY DUOC
        $capability = 'manage_categories'; // QUYEN TRUY CAP DE THAY MENU NAY
        $menu_slug = 'vote'; // TEN slug TEN DUY NHAT KO DC TRUNG VOI TRANG KHAC GAN TREN THANH DIA CHI OF MENU
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
            case 'edit':
                $this->addAction();
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
        require_once (VIEW_DIR . 'vote_view.php');
    }

// THEM MOI ITEM
    public function addAction() {
        $action = $_GET['action'];
// KIEM TRA PHUONG THUC GET HAY POST
        if (isPost()) {
            require_once (MODEL_DIR . 'vote_model.php');
            $model = new Admin_Vote_Model();
            $errors = array();
            $fileName = $_POST['hid_img'];

            if (!empty($_FILES['vote_img']['name'])) {
                // XOA FILE DINH KEM SAU KHI GOI
                if (!empty($_POST['hid_img'])) {
                    unlink(WB_DIR_IMAGES_VOTE . $_POST['hid_img']);
                }
                $file_size = $_FILES['vote_img']['size'];
                $file_tmp = $_FILES['vote_img']['tmp_name'];

                $file_trim = ((explode('.', $_FILES['vote_img']['name'])));
                $trim_type = strtolower($file_trim[1]);

                $extensions = array("jpg", "png", "jpeg", "gif", "pdf");
                if (in_array($trim_type, $extensions) === false) {
                    $errors[] = "上傳照片檔案是 JPEG , PNG , BMP.";
                }
                if ($file_size > 20097152) {
                    $errors[] = '上傳檔案容量不可大於 2 MB';
                }

                if (empty($errors)) {
//                    $path = HCM_DIR_IMAGES . '/vote/';
                    $fileName = date('ymdhis') . '.' . @$trim_type;
                    move_uploaded_file(@$file_tmp, ( WB_DIR_IMAGES_VOTE . $fileName));
                }
            }

            $model->saveItem($_POST, $fileName, array('action' => $action));

            $paged = max(1, $arrParams['paged']);
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
            wp_redirect($url);
        }
        require_once( VIEW_DIR . 'vote_from.php');
//require_once( VIEW_DIR . 'test.php');
    }

    public function uncheckinAction() {
        $arrParams = getParams();
        require_once (MODEL_DIR . 'vote_model.php');
        $model = new Admin_Vote_Model();

        $model->uncheckinItem($arrParams);

        if ($arrParams['check'] == 0 && !is_array($arrParams['id'])) {
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
        require_once (MODEL_DIR . 'vote_model.php');
        $model = new Admin_Vote_Model();
        $model->deleteItem($arrParam);

        $paged = max(1, $arrParam['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

    public function restoreAction() {
        $arrParams = getParams();
        require_once (MODEL_DIR . 'vote_model.php');
        $model = new Admin_Vote_Model();
        $model->restoreItem($arrParams);
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }

    public function trashAction() {
        $arrParams = getParams();

        require_once (MODEL_DIR . 'vote_model.php');
        $model = new Admin_Vote_Model();
        $model->trashItem($arrParams);
        // TRA VE TRANG MAC DINH
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }


}
