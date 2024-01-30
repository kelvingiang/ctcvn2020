<?php

require_once(DIR_CONTROLLER . 'controller_main.php');
new Admin_Controller_Main();

require_once(DIR_METABOX . 'main.php');
new Admin_metabox();

require_once(DIR_CLASS . 'html.php');
new MyHtml;

include_once(DIR_CODES . 'rewrite-url.php');
new Codes_Rewrite_Url;

/* CHUC NANG SEARCH TU TABLE POSTSMETA */
require_once(DIR_CODES . 'search_by_meta_value.php');
new Admin_Search_By_Meta_Vakue();

include_once(DIR_CODES . 'forum_cmd_ui.php');