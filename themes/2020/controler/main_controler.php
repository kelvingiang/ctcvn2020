<?php

class Admin_Main_controler {

    private $_controler_name = 'tw_controler_options';
    private $_controler_options = array();

    public function __construct() {
        $defaultoption = array(
            'download_controler' => TRUE,
            'silder_controler' => TRUE,
            'brach_controler' => TRUE,
            'apply_controler' => TRUE,
            'join_controler' => TRUE,
            'forum_controler' => TRUE,
            'recruitment_controler' => TRUE,
            'member_controler' => TRUE,
            'friend_link_controler' => TRUE,
            'event_controler' => TRUE,
            'event_report_controler' => TRUE,
            'about_controler' => TRUE,
            'advertising_controler' => TRUE,
            'supervisor_controler' => TRUE,
            'schedule_controler' => TRUE,
            'checkin_controler' => TRUE,
            'checkin_report_controler' => TRUE,
            'checkin_setting_controler' => get_current_user_id() == 1 ? TRUE : FALSE,
            'president_controler' => TRUE,
            'vote_controler' => TRUE,
            'vote_setting_controler' => TRUE,
        );

        $this->_controler_options = get_option($this->_controler_name, $defaultoption);
        $this->download_page();
        $this->silder_post();
        $this->brach_post();
        $this->apply_post();
        $this->join_post();
        $this->forum_post();
        $this->recruitment_post();
        $this->member_post();
        $this->advertising_post();
        $this->supervisor_post();
        $this->schedule_page();
        $this->check_in_page();
        $this->check_in_report_page();
        $this->president_post();
        $this->check_in_setting_page();
        $this->about_page();
        $this->vote_page();
        $this->vote_setting();
        $this->event_post();
        $this->event_report_post();
        $this->friend_link_post();

        add_action('admin_init', array($this, 'do_output_buffer'));
    }

    /* FUNCTION NAY GIAI VIET CHUYEN TRANG BI LOI  */

    public function do_output_buffer() {
        ob_start();
    }

    public function download_page() {
        if ($this->_controler_options['download_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'download_controler.php');
            new Admin_Download_Controler();
        }
    }

    public function silder_post() {
        if ($this->_controler_options['silder_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'silder_controler.php');
            new Admin_Silder_Controler();
        }
    }

    public function brach_post() {
        if ($this->_controler_options['brach_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'brach_controler.php');
            new Admin_Brach_Controler();
        }
    }

    public function apply_post() {
        if ($this->_controler_options['apply_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'apply_controler.php');
            new Admin_Apply_Controler();
        }
    }

    public function recruitment_post() {
        if ($this->_controler_options['recruitment_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'recruitment_controler.php');
            new Admin_Recruitment_Controler();
        }
    }

    public function join_post() {
        if ($this->_controler_options['join_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'join_controler.php');
            new Admin_Join_controler();
        }
    }

    public function forum_post() {
        if ($this->_controler_options['forum_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'forum_controler.php');
            new Admin_Forum_Controler();
        }
    }

    public function member_post() {
        if ($this->_controler_options['member_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'member_controler.php');
            new Admin_Member_controler();
        }
    }

    public function friend_link_post() {
        if ($this->_controler_options['friend_link_controler'] == true) {
            require_once (CONTROLER_DIR . 'friend_link_controler.php');
            new Admin_Friend_Link_Controler();
        }
    }

    public function event_post() {
        if ($this->_controler_options['event_controler'] == true) {
            require_once (CONTROLER_DIR . 'event_controler.php');
            new Admin_Event_Controler();
        }
    }

    public function event_report_post() {
        if ($this->_controler_options['event_report_controler'] == true) {
            require_once (CONTROLER_DIR . 'event_report_controler.php');
            new Admin_Event_Report_Controler();
        }
    }

    public function vote_setting() {
        if ($this->_controler_options['vote_setting_controler'] == true) {
            require_once (CONTROLER_DIR . 'vote_setting_controler.php');
            new Admin_Vote_Setting_Controler();
        }
    }

    public function vote_page() {
        if ($this->_controler_options['vote_controler'] == true) {
            require_once (CONTROLER_DIR . 'vote_controler.php');
            new Admin_Vote_Controler();
        }
    }

    public function about_page() {
        if ($this->_controler_options['about_controler'] == true) {
            require_once (CONTROLER_DIR . 'about_controler.php');
            new Admin_About_Controler();
        }
    }

    public function advertising_post() {
        if ($this->_controler_options['advertising_controler'] == true) {
            require_once (CONTROLER_DIR . 'advertising_controler.php');
            new Admin_Advertising_Controler();
        }
    }

    public function supervisor_post() {
        if ($this->_controler_options['supervisor_controler'] == true) {
            require_once (CONTROLER_DIR . 'supervisor_controler.php');
            new Admin_Supervisor_Controler();
        }
    }

    public function schedule_page() {
        if ($this->_controler_options['schedule_controler'] == true) {
            require_once(CONTROLER_DIR . 'schedule_controler.php');
            new Admin_Schedule_Controler();
        }
    }

    public function check_in_page() {
        if ($this->_controler_options['checkin_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_controler.php');
            new Admin_Check_In_Controler();
        }
    }

    public function check_in_report_page() {
        if ($this->_controler_options['checkin_report_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_report_controler.php');
            new Admin_Check_In_Report_Controler();
        }
    }

    public function check_in_setting_page() {
        if ($this->_controler_options['checkin_setting_controler'] == TRUE) {
            require_once(CONTROLER_DIR . 'check_in_setting_controler.php');
            new Admin_Check_In_Setting_Controler();
        }
    }

    public function president_post() {
        if ($this->_controler_options['president_controler'] == TRUE) {
            require_once (CONTROLER_DIR . 'president_controler.php');
            new Admin_President_Controler();
        }
    }

}
