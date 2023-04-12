<?php

class Admin_metabox
{

    private $_metabox_name = 'metabox_options';
    private $_metabox_options = array();

    public function __construct()
    {
        $defaultoption = array(
            'metabox_order_by' => TRUE,
            'metabox_apply' => TRUE,
            'metabox_join' => TRUE,
            'metabox_brach' => TRUE,
            'metabox_active' => TRUE,
            'metabox_recruitment' => TRUE,
            'metabox_member' => TRUE,
            'metabox_seo' => TRUE,
            'metabox_friend_link' => TRUE,
            'metabox_event' => TRUE,
            'metabox_website' => TRUE,
            'metabox_special' => TRUE,
            'metabox_president' => TRUE,
        );


        $this->_metabox_options = get_option($this->_metabox_name, $defaultoption);
        $this->apply();
        $this->join();
        $this->brach();
        $this->active();
        $this->recruitment();
        $this->member();
        $this->friendLink();
        $this->event();
        $this->website();
        $this->SpecialShow();
        $this->president();
        $this->seo();
        $this->order();
    }

    public function order()
    {
        if ($this->_metabox_options['metabox_order_by'] == true) {
            require_once(DIR_METABOX . 'order.php');
            new Admin_Metabox_Order_By();
        }
    }

    public function apply()
    {
        if ($this->_metabox_options['metabox_apply'] == true) {
            require_once(DIR_METABOX . 'apply.php');
            new Admin_Metabox_Apply();
        }
    }

    public function join()
    {
        if ($this->_metabox_options['metabox_join'] == true) {
            require_once(DIR_METABOX . 'join.php');
            new Admin_Metabox_Join();
        }
    }

    public function brach()
    {
        if ($this->_metabox_options['metabox_brach'] == true) {
            require_once(DIR_METABOX . 'brach.php');
            new Admin_Metabox_Brach();
        }
    }

    public function active()
    {
        if ($this->_metabox_options['metabox_active'] == true) {
            require_once(DIR_METABOX . 'active.php');
            new Admin_Metabox_active();
        }
    }

    public function recruitment()
    {
        if ($this->_metabox_options['metabox_recruitment'] == true) {
            require_once(DIR_METABOX . 'recruitment.php');
            new Admin_Metabox_Recruitment();
        }
    }

    public function member()
    {
        if ($this->_metabox_options['metabox_member'] == true) {
            require_once(DIR_METABOX . 'member.php');
            new Admin_Metabox_Member();
        }
    }

    public function seo()
    {
        if ($this->_metabox_options['metabox_seo'] == true) {
            require_once(DIR_METABOX . 'seo.php');
            new Admin_Metabox_Seo();
        }
    }

    public function friendLink()
    {
        if ($this->_metabox_options['metabox_friend_link'] == true) {
            require_once(DIR_METABOX . 'friendlink.php');
            new Admin_Metabox_Friend_link();
        }
    }

    public function event()
    {
        if ($this->_metabox_options['metabox_event'] == true) {
            require_once(DIR_METABOX . 'event.php');
            new Admin_Metabox_Event();
        }
    }

    public function website()
    {
        if ($this->_metabox_options['metabox_website'] == true) {
            require_once(DIR_METABOX . 'website.php');
            new Admin_Metabox_website();
        }
    }

    public function SpecialShow()
    {
        if ($this->_metabox_options['metabox_special'] == true) {
            require_once(DIR_METABOX . 'special.php');
            new Admin_Metabox_Special();
        }
    }

    public function president()
    {
        if ($this->_metabox_options['metabox_president'] == true) {
            require_once(DIR_METABOX . 'president.php');
            new Admin_Metabox_President();
        }
    }
}