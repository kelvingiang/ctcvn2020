<?php

require_once (CONTROLER_DIR . 'main_controler.php');
new Admin_Main_controler();

require_once (METABOX_DIR . 'main.php');
new Admin_metabox();

require_once (CLASS_DIR . 'html.php');
new MyHtml;

include_once (CODES_DIR . 'rewrite-url.php');
new Ctcvn_Rewrite_Url();

/* CHUC NANG SEARCH TU TABLE POSTSMETA */
require_once (CODES_DIR . 'search_by_meta_value.php');
new Admin_Search_By_Meta_Vakue();

include_once (CODES_DIR . 'forum_cmd_ui.php');

