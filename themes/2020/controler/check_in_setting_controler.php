<?php

class Admin_Check_In_Setting_Controler {

    public function __construct() {
        add_action('admin_menu', array($this, 'CheckInSettingAdminMenu'));
    }

    // PHAN TAO MENU CON TRONG MENU CHA CUNG LA POST TYPE
    public function CheckInSettingAdminMenu() {
        $parent_slug = 'tw_checkin';
        $page_title = __('Check In Setting');
        $menu_title = __('Check In Setting');
        $capability = 'manage_categories';
        $menu_slug = 'checkinsetting';
        $icon = WB_URL_ICON_DIR . '/staff-icon.png';  // THAM SO THU 6 LA LINK DEN ICON DAI DIEN
        $position = 18; 
        add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, array($this, 'dispatchActive'),$icon, $position );
    }

    public function dispatchActive() {
//        echo __METHOD__;
        $action = getParams('action');
        switch ($action) {
            case 'export_checkin':
                $this->ExportCheckInAction();
                break;
            case 'export_member_post':     
                $this->ExportMemberPostAction();
                break;
            case 'export_member_table':
                $this->ExportMemberTableAction();
                break;
            case 'export_guests':
                $this->ExportGuestsAction();
                break;
            case 'import_guests':
                $this->ImportGuestsAction();
                break;
            case 'import_member':
                $this->ImportMemberAction();
                break;
            case 'reset_checkin':
                $this->ResetCheckInAction();
                break;
            case 'batch_qrcode':
                $this->BatchQRCodeAction();
                break;
            case 'set_qrcode_name':
                $this->SetQRCodeNameAction();
                break;
            case 'set_qrcode_register':
                $this->SetQRCodeRegister();
                break;
            default :
                $this->displayPage();
                break;
        }
    }

    public function displayPage() {
        require_once ( VIEW_DIR . 'check_in_setting_view.php');
    }
    
// Export Group Function
    public function ExportCheckInAction() {
       require_once (MODEL_DIR.'check_in_setting_model.php');
       $model = new Admin_Check_In_Setting_model();
       $model->ExCheckInToExcel();
    }

    public function ExportMemberPostAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportMemberPost();
    }
    
    public function ExportMemberTableAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportMemberTable();
    }
    
     public function ExportGuestsAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ExportGuests();
    }

// Import Group Function 
    public function ImportGuestsAction(){
        if(isPost()){
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = WP_CONTENT_DIR . DS . 'themes' . DS . 'suite' . DS . 'file' . DS;
                move_uploaded_file($file_tmp, ( $path . $file_name));

                $excelList = $path . $file_name;
                require_once (MODEL_DIR .'check_in_setting_model.php');
                $model = new Admin_Check_In_Setting_model();
                $model->ImportGuests($excelList);
                
          $paged = max(1, $arrParams['paged']);
          $url = 'admin.php?page=' . 'tw_checkin' . '&paged=' . $paged . '&msg=1';
            //$url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
           wp_redirect($url);
        }
     }
        require_once (VIEW_DIR . 'guests_import_view.php');
    }
    
    public function ImportMemberAction(){
        if(isPost()){
            $errors = array();
            $file_name = $_FILES['myfile']['name'];
            $file_size = $_FILES['myfile']['size'];
            $file_tmp = $_FILES['myfile']['tmp_name'];
            $file_type = $_FILES['myfile']['type'];

            $file_trim = ((explode('.', $_FILES['myfile']['name'])));
            $trim_name = strtolower($file_trim[0]);
            $trim_type = strtolower($file_trim[1]);
            //$name = $_SESSION['login'];
            // $cus_name = 'avatar-'.$name . '.' . $trim_type;  //tao name moi cho file tranh trung va mat file

            $extensions = array("xls", "xlsx");
            if (in_array($trim_type, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a excel file.";
            }
            if ($file_size > 20097152) {
                $errors[] = 'File size must be excately 20 MB';
            }
            if (empty($errors)) {
                $path = WP_CONTENT_DIR . DS . 'themes' . DS . 'suite' . DS . 'file' . DS;
                move_uploaded_file($file_tmp, ( $path . $file_name));

                $excelList = $path . $file_name;
                require_once (MODEL_DIR .'check_in_setting_model.php');
                $model = new Admin_Check_In_Setting_model();
                $model->ImportMember($excelList);
                
                $paged = max(1, $arrParams['paged']);
                $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=1';
            //$url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
                wp_redirect($url);
            }
        }
        require_once (VIEW_DIR . 'member_import_view.php');
    }
    
// Create Group QRCode    
    public function ResetCheckInAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->ResetCheckIn();
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=1';
          //  $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }
    
    public function BatchQRCodeAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->BatchCreateQRCode();
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=1';
          //  $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }
    
    public function SetQRCodeNameAction(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->SetQRCodeName();
        $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=1';
          //  $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url);
    }
    
    public function  SetQRCodeRegister(){
        require_once (MODEL_DIR.'check_in_setting_model.php');
        $model = new Admin_Check_In_Setting_model();
        $model->SetQRCodeRegister();
      //  $paged = max(1, $arrParams['paged']);
        $url = 'admin.php?page=' . 'checkinsetting' . '&paged=' . $paged . '&msg=2';
          //  $url = 'admin.php?page=' . $_REQUEST['page'] . '&paged=' . $paged . '&msg=1';
        wp_redirect($url); 
    }
}

