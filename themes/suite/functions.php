<?php
/*
 *  khai bao hang gia tri
 *  @THEME_URL = lay duong dan thu muc theme
 *  @CORE      = lay duong dan thu muc core
 *  */
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set('Asia/Ho_Chi_Minh');

/* * **************************phan cua theme******************************** */
// KHAI BAO HANG SO 
define('THEME_URL', get_stylesheet_directory());  // hang lay path thu muc theme
define('THEME_PART', get_template_directory_uri());

define('DS', DIRECTORY_SEPARATOR);  // phan nay thay doi dau / theo he dieu hanh khac nhau giua window va linx
define('HELPER', THEME_URL . DS . 'helper' . DS);

require_once(HELPER . 'define.php');
require_once(HELPER . 'function.php');
require_once(HELPER . 'style.php');
require_once(HELPER . 'require.php');

/* thiet lap chieu rong cua noi dung */
if (!isset($content_width)) {
    $content_width = 620; // CHIEU RONG DON VI LA PX
}

global $postCount;
$postCount = (int) get_option('posts_per_page');

/*
 * khai bao chuc nang cua theme
 */
if (!function_exists('suite_theme_setup')) {

    // phan thiet lap cac chua nang cho theme nay
    function suite_theme_setup()
    {

        /* thiet lap textdomain ap dung cho viec dich multilanguage */
        $language_folder = THEME_URL . '/languages';
        load_theme_textdomain('suite', $language_folder);

        /* tu dong them link RSS len head */
        add_theme_support('automatic-feed-links');

        /* them post thumbnail , hinh dai dien cho post */
        add_theme_support('post-thumbnails');

        /* post format cac kieu dang cua post  */
        add_theme_support('post-formats', array('image', 'video', 'gallery', 'quote', 'link'));

        /* them title-tag tu them noi dung title vao tag title */
        add_theme_support('title-tag');

        /* them custom backgroup */
        $default_background = array('defualt-color' => '#e8e8e8');
        add_theme_support('custom-background', $default_background);

        /* them menu co phan khai bao thay doi ngon ngu o phan __  thong qua textdomain */
        register_nav_menu('primary-menu', __('Primary name', 'suite')); // goi menu de show
        register_nav_menu('mobile-menu', __('Mobile name', 'suite')); // goi menu de show

        /* tao sidebar */
        $sidebar = array(
            'name' => __('Main Sidebar', 'suite'),
            'id' => 'main-sidebar',
            'descripion' => 'defualt sidebar',
            'class' => 'main-sidebar',
            'before_title' => '<h3  class="wedgettitle">',
            'after_title' => '</h3>',
        );
        register_sidebar($sidebar);
    }

    add_action('init', 'suite_theme_setup'); // INIT SE THUC HIEN MOI KHI TAI LAI TRANG
}


/* ============================================= ===
  LANGUAGE FUNCTION
  =================================================== */

global $language;
function change_translate_text($translated)
{
    if ($_SESSION['languages'] == 'vn') {
        $languages = 'vn';
    } else {
        $languages = 'cn';
    }

    if (is_admin()) {
        $file = dirname(dirname(dirname(__FILE__))) . "/languages/admin_languages/data.php";
        // $file = DIR_LANGUAGES . 'admin_language/data.php';
    } else {
        $file = dirname(dirname(dirname(__FILE__))) . "/languages/{$languages}/data.php";
    }
    include_once $file;

    $data = getTranslate();
    if (isset($data[$translated])) {
        return $data[$translated];
    }
    return $translated;
}

add_filter('gettext', 'change_translate_text', 20);

/* ==============================================================
  THEM CHUC NANG UPLOAD FILE CHO FORM META
  =============================================================== */
add_action('post_edit_form_tag', 'post_edit_form_tag');

function post_edit_form_tag()
{
    echo ' enctype="multipart/form-data"';
}

/* cac function themplate */
////////////================================================================================
/* lay thong tin cua trang web */
if (!function_exists('suite_header')) {

    function suite_header()
    {
?>
        <div class="site-name ">
            <?php
            if (is_home()) {
                printf('<h1 ><a style="color:white" href="%1$s" title="%2$s" >%3$s</a></h1>', get_bloginfo('url'), get_bloginfo('description'), get_bloginfo('sitename'));
            } else {
                printf('<h3><a style="color:black" href="%1$s" title="%2$s" >%3$s</a></h3>', get_bloginfo('url'), get_bloginfo('description'), get_bloginfo('sitename'));
            }
            ?>
        </div>
        <div class="site-description"><?php bloginfo('description'); ?></div>
    <?php
    }
}

/* tao menu */
if (!function_exists('suite_menu')) {

    function suite_menu($slug)
    {
        $menu = array(
            'theme_location' => $slug, // chon menu dc thiet lap truoc
            'container' => 'nav', // tap html chua menu nay
            'container_class' => $slug, // class cua mennu
            'items_wrap' => '<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
        );
        wp_nav_menu($menu);
    }
}

if (!function_exists('mobile_menu')) {

    function mobile_menu($slug)
    {
        $menu = array(
            'theme_location' => $slug, // chon menu dc thiet lap truoc
            'container' => 'nav', // tap html chua menu nay
            'container_class' => $slug, // class cua mennu
            'container_id' => $slug, // class cua mennu
            'items_wrap' => '<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
        );
        wp_nav_menu($menu);
    }
}


/* tao phan trang pagination */
if (!function_exists('suite_pagination')) {
    /*
     * Không hiển thị phân trang nếu trang đó có ít hơn 2 trang
     */

    function suite_pagination()
    {
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return '';
        }
    ?>
        <nav class="pagination" role="navigation">
            <?php if (get_next_posts_link()) : ?>
                <div class="prev"><?php next_posts_link(__('Order Post', 'suite')); ?></div>
            <?php endif ?>

            <?php if (get_previous_posts_link()) : ?>
                <div class="next"><?php previous_posts_link(__('Newer Post', 'suite')); ?></div>
            <?php endif ?>
        </nav>
        <?php
    }
}

/* tao function thumbnail hien thi hinh anh trong post */
if (!function_exists('suite_thumbnail')) {

    function suite_thumbnail($size)
    {
        if (!is_single() && has_post_thumbnail() && !post_password_required() || has_post_format('image')) {
        ?>
            <figure class="post-thumbnail"> <?php the_post_thumbnail($size) ?> </figure>

        <?php
        }
    }
}


/* lay tieu de vo link cua post */
if (!function_exists('suite_entry_header')) {

    function suite_entry_header()
    {
        if (is_single()) :
        ?>
            <!-- <h1><a href="<?php // the_permalink()                                           
                                ?>" //title="<?php // the_title();                                            
                                                ?>"><?php // the_title();                                           
                                                    ?>  </a></h1>  -->
            <div class="article-title">
                <label><?php the_title(); ?></label>
            </div>
        <?php else : ?>
            <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
        <?php
        endif;
    }
}

// lay du lieu post 
if (!function_exists('suite_entry_meta')) {

    function suite_entry_meta()
    {
        if (!is_page()) :
        ?>
            <div class="entry-meta">
                <?php
                //          printf(__('<span class="author"> Posted By  %1$s', 'suite'), get_the_author());  // lay ten tac gia bai viet
                //        printf(__('<span class="date-published"> - at  %1$s', 'suite'), get_the_date());  // lay ngay thang dang bai
                //      printf(__('<span class="date-modi"> - Modi Date at  %1$s', 'suite'), get_the_modified_date());  // lay ngay thang sua bai
                //    printf(__('<span class="category"> - In  %1$s', 'suite'), get_the_category_list(','));  // lay gia tri category
                //    printf( __('<span class="date-published"> - Published at  %1$s', 'suite'), get_the_date());  // lay ngay thang dang bai
                /* hien thi binh luon comment,   kiem tra binh luan co dc mo chua  */

                //      if (comments_open()):
                //        echo '<hr> </br> <span class=meta-relay>';
                //        comments_popup_link(
                //         __('Leave a comment', 'suite'), __('One Comment', 'suite'), __('% comment', 'suite'), __('Read all comments', 'suite')
                //       );
                //       echo '</span>';
                //  endif;
                ?>
            </div>
        <?php
        endif;
    }
}

// lay noi dung cua bai post
if (!function_exists('suite_entry_content')) {

    function suite_entry_content()
    {
        if (!is_single() && !is_page()) {
            the_excerpt();
        } else {
        ?>
            <div class="info-bg" style=" margin-top: -18px; padding-top: 20px">
                <?php the_content(); ?>

            </div>
        <?php
            // phan phan trang trong single
            $link_pages = array(
                'before' => __('<p> Page : ', 'suite'),
                'after' => '</p>',
                'nextpagelink' => __('Next Page', 'suite'),
                'previouspagelink' => __('Previous Page', 'suite')
            );
            wp_link_pages($link_pages);
            /* muon hien thi phan phan trang trong single
             * phai trong bai post them doan <!-- next page -->
             */
        }
    }
}

/*
 * Thêm chữ Read More vào excerpt
 */

function suite_readmore()
{
    return '...<a class="read-more" href="' . get_permalink(get_the_ID()) . '">' . __('[ Read More ]', 'suite') . '</a>';
}

add_filter('excerpt_more', 'suite_readmore');

/**
  @ Hàm hiển thị tag của post
  @ thachpham_entry_tag()
 * */
if (!function_exists('suite_entry_tag')) {

    function suite_entry_tag()
    {
        if (has_tag()) :
            echo '<div class="entry-tag">';
            printf(__('Tagged in %1$s', 'suite'), get_the_tag_list('', ', '));
            echo '</div>';
        endif;
    }
}

// xoa tham so tren url
/*
  function remove_all_ver( $src ) {
  if ( strpos( $src, 'action=' ) )
  $src = remove_query_arg( 'action', $src );
  return $src;
  }
  add_filter( 'style_loader_src', 'remove_all_ver', 9999 );
  add_filter( 'script_loader_src', 'remove_all_ver', 9999 );
 */

function remove_submenus()
{
    if (!current_user_can('activate_plugins')) {
        global $submenu;
        unset($submenu['edit.php?post_type=agents'][10]); // Removes 'Add New'.
    }
}

add_action('admin_menu', 'remove_submenus');

/* phan kiem tra noi dung cua article */

// MY CREATE FUNCTION
function checkContent($subject)
{
    // LAY CAC TU  TRONG DANH SACH CHAN 
    // LOAI BO KHOANG TRANG THE VAO DAU |
    //$myfile = fopen("word.txt", "r") or die("Unable to open file!");
    $search = array("<script>", "script", "javascript");
    $replace = ' ';
    $result = str_replace($search, $replace, $subject);
    return $result;
}

function recruitMetaBox($recMeta, $_post)
{

    $editor = checkContent($_post['editor']);
    $orther = checkContent($_post['another']);

    update_post_meta($recMeta, '_recruit_like', 0);
    update_post_meta($recMeta, '_recruit_view', 0);
    update_post_meta($recMeta, '_recruit_postby', $_SESSION['login']);
    update_post_meta($recMeta, '_recruit_status', $_post['chk_status']);
    update_post_meta($recMeta, '_recruit_company_tw', esc_attr($_post['txt_company_tw']));
    update_post_meta($recMeta, '_recruit_company_vn', esc_attr($_post['txt_company_vn']));
    update_post_meta($recMeta, '_recruit_company_en', esc_attr($_post['txt_company_en']));
    update_post_meta($recMeta, '_recruit_address', esc_attr($_post['txt_address']));
    update_post_meta($recMeta, '_recruit_phone', esc_attr($_post['txt_phone']));
    update_post_meta($recMeta, '_recruit_email', esc_attr($_post['txt_email']));
    update_post_meta($recMeta, '_recruit_count', esc_attr($_post['txt_count']));
    update_post_meta($recMeta, '_recruit_summary', $editor);

    update_post_meta($recMeta, '_recruit_lack_job', esc_attr($_post['txt_lack_job']));
    update_post_meta($recMeta, '_recruit_lack_count', esc_attr($_post['txt_lack_count']));
    update_post_meta($recMeta, '_recruit_sex', esc_attr($_post['sel_sex']));
    update_post_meta($recMeta, '_recruit_date_from', esc_attr($_post['txt_date_from']));
    update_post_meta($recMeta, '_recruit_date_to', esc_attr($_post['txt_date_to']));
    update_post_meta($recMeta, '_recruit_level', esc_attr($_post['txt_level']));
    update_post_meta($recMeta, '_recruit_experience', esc_attr($_post['txt_experience']));
    update_post_meta($recMeta, '_recruit_age_from', esc_attr($_post['txt_age_from']));
    update_post_meta($recMeta, '_recruit_age_to', esc_attr($_post['txt_age_to']));
    update_post_meta($recMeta, '_recruit_language', esc_attr($_post['txt_language']));
    update_post_meta($recMeta, '_recruit_work_space', esc_attr($_post['txt_word_space']));
    update_post_meta($recMeta, '_recruit_salary', esc_attr($_post['txt_salary']));
    update_post_meta($recMeta, '_recruit_orther', $orther);
    update_post_meta($recMeta, '_recruit_contact_name', esc_attr($_post['txt_contact_name']));
    update_post_meta($recMeta, '_recruit_contact_phone', esc_attr($_post['txt_contact_phone']));
    update_post_meta($recMeta, '_recruit_contact_email', esc_attr($_post['txt_contact_email']));

    update_post_meta($recMeta, 'seo_title', esc_attr(substr($_post['txt_title'], 0, 20)));
    update_post_meta($recMeta, 'seo_description', esc_attr($_post['editor']));
    update_post_meta($recMeta, 'seo_keywords', esc_attr($_post['txt_title']));

    // ADD NEW 18-05-2020
    update_post_meta($recMeta, '_recruit_place', esc_attr($_post['sel_place']));
    update_post_meta($recMeta, '_recruit_career', esc_attr($_post['sel_career']));
}

function recruitmentMetaBox($recMeta, $_post)
{

    if (!empty($_FILES['file_upload']['name'])) {
        $loginID = $_SESSION['login_id'];
        $uploadReturn = uploadFile($loginID, $_FILES);
        update_post_meta($loginID, 'm_img', $uploadReturn);
        update_post_meta($recMeta, '_recruit_img', $uploadReturn);
    };

    if (is_array($uploadReturn)) {
        return $uploadReturn;
    } else {
        $orther = checkContent($_post['another']);
        update_post_meta($recMeta, '_recruit_like', 0);
        update_post_meta($recMeta, '_recruit_view', 0);
        update_post_meta($recMeta, '_recruit_postby', $_SESSION['login']);
        update_post_meta($recMeta, '_recruit_status', $_post['chk_status']);
        update_post_meta($recMeta, '_recruit_fullname', esc_attr($_post['txt_fullname']));
        update_post_meta($recMeta, '_recruit_birthday', esc_attr($_post['txt_birthday']));
        update_post_meta($recMeta, '_recruit_sex', esc_attr($_post['sel_sex']));
        update_post_meta($recMeta, '_recruit_address', esc_attr($_post['txt_address']));
        update_post_meta($recMeta, '_recruit_email', esc_attr($_post['txt_email']));
        update_post_meta($recMeta, '_recruit_phone', esc_attr($_post['txt_phone']));
        update_post_meta($recMeta, '_recruit_level', esc_attr($_post['txt_level']));
        update_post_meta($recMeta, '_recruit_experience', esc_attr($_post['txt_experience']));
        update_post_meta($recMeta, '_recruit_another', $orther);
        //===== add new 09/04/2020
        update_post_meta($recMeta, '_recruit_height', esc_attr($_post['txt_height']));
        update_post_meta($recMeta, '_recruit_department', esc_attr($_post['txt_department']));
        update_post_meta($recMeta, '_recruit_work', esc_attr($_post['txt_work']));
        update_post_meta($recMeta, '_recruit_job', esc_attr($_post['txt_job']));
        update_post_meta($recMeta, '_recruit_salary', esc_attr($_post['txt_salary']));
        update_post_meta($recMeta, '_recruit_industry', esc_attr($_post['txt_industry']));
        update_post_meta($recMeta, '_recruit_language', esc_attr($_post['txt_language']));
        update_post_meta($recMeta, '_recruit_license', esc_attr($_post['txt_license']));
        update_post_meta($recMeta, '_recruit_software', esc_attr($_post['txt_software']));
        update_post_meta($recMeta, '_recruit_drive', esc_attr($_post['chk_drive']));
        update_post_meta($recMeta, '_recruit_line', esc_attr($_post['txt_line']));

        update_post_meta($recMeta, 'seo_title', esc_attr(substr($_post['txt_title'], 0, 20)));
        update_post_meta($recMeta, 'seo_description', esc_attr($_post['txt_title']));
        update_post_meta($recMeta, 'seo_keywords', esc_attr($_post['txt_title']));
    }
}

/*
 * // phan nay an di phan quan tri xoa post
  function hide_that_stuff() {
  if ('member2' == get_post_type())
  echo '<style type="text/css">
  #favorite-actions {display:none;}
  .add-new-h2{display:none;}
  .tablenav{display:none;}
  </style>';
  }

  add_action('admin_head', 'hide_that_stuff');
 */

/* them cac phan meta box */

function pagination_nav()
{
    global $wp_query;

    if ($wp_query->max_num_pages > 1) {
        ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php next_posts_link('&larr; Older posts'); ?></div>
            <div class="nav-next"><?php previous_posts_link('Newer posts &rarr;'); ?></div>
        </nav>
        <?php
    }
}

function pagination_bar()
{
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}

function change_mce_options($init)
{
    $init["forced_root_block"] = false;
    $init["force_br_newlines"] = true;
    $init["force_p_newlines"] = false;
    $init["convert_newlines_to_brs"] = true;
    return $init;
}

add_filter('tiny_mce_before_init', 'change_mce_options');

function suite_seo()
{
    global $suite;
    $suite = array(
        'txtTitleSeo' => '越南台灣商會聯合總',
        'strDescriptionSeo' => '越南台灣商會聯合總 Phòng CR2-15-107 tôn Dật Tiên, Phường :Tân Phú, Quận 7, TpHCM',
        'strKeywordsSeo' => '越南台灣商會聯合總,台灣商會 '
    );
    if (is_home() == true) {

        /* THE DOI GIA TRI CUA TITLE WP_HEAD */

        function custom_title($title)
        {
            global $suite;
            return $suite['txtTitleSeo'];
        }

        add_filter('wp_title', 'custom_title');

        echo '<meta name="description" content="' . $suite['strDescriptionSeo'] . '" />';
        echo '<meta name="keywords" content="' . $suite['strKeywordsSeo'] . '" />';
    } else if (is_single() || is_page()) {

        global $post;

        $strSeoTitle = get_post_meta($post->ID, 'seo_title', true);
        $strSeoDescription = get_post_meta($post->ID, 'seo_description', true);
        $strSeoKeywords = get_post_meta($post->ID, 'seo_keywords', true);

        global $strTitle;
        if (empty($strSeoTitle) != false) {
            $strTitle = $suite['txtTitleSeo'];
        } else {
            $strTitle = $suite['txtTitleSeo'] . ' - ' . $strSeoTitle;
        }

        // THE DOI GIA TRI CUA TITLE WP_HEAD
        function custom_title($title)
        {
            global $strTitle;
            return $strTitle;
        }

        add_filter('wp_title', 'custom_title');
        //  echo '<title>' . $strTitle . '</title>';
        echo '<meta name="description" content="' . $strSeoDescription . '" />';
        echo '<meta name="keywords" content="' . $strSeoKeywords . '" />';
    } else if (is_tax() || is_tag() || is_category()) {
        global $taxonomy, $term;
        $term = get_term_by('slug', $term, $taxonomy);
        $term_id = $term->term_id;
        $term_meta = get_option("taxonomy_$term_id");

        $strSeoTitle = $term_meta['txtTitleSeo'];
        $strSeoDescription = $term_meta['strDescriptionSeo'];
        $strSeoKeywords = $term_meta['seo_keywords'];

        if (empty($strSeoTitle) != false) {
            $strTitle = $suite['txtTitleSeo'];
        } else {
            $strTitle = $suite['txtTitleSeo'] . ' - ' . $strSeoTitle;
        }

        /*  THE DOI GIA TRI CUA TITLE WP_HEAD */

        function custom_title($title)
        {
            global $strTitle;
            return $strTitle;
        }

        add_filter('wp_title', 'custom_title');
        echo '<meta name="description" content="' . $strSeoDescription . '" />';
        echo '<meta name="keywords" content="' . $strSeoKeywords . '" />';
    }
    echo '<meta name="robots" content="INDEX,FOLLOW" />';
    echo '<meta http-equiv="REFRESH" content="1800" />';
}

if (!is_admin()) {

    // custom admin login logo
    function custom_login_logo()
    {
        echo '<style type="text/css">
	h1 a { background-image: url(' . PART_IMAGES . 'logo.png' . ') !important; }
	</style>';
    }

    add_action('login_head', 'custom_login_logo');
} else {
    // KIEM NEU ROLE KHONG PHAI LA ADMIN SE AN PHAN PAGE;
    add_action('in_admin_footer', 'check_role_behide_page');

    function check_role_behide_page()
    {
        //kiem tra neu khac admin se an muc paga
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $role = $roles[0];
        if ($role !== 'administrator') {
        ?>
            <script type="text/javascript">
                document.getElementById("menu-pages").style.display = "none";
            </script>

            <?php
        }
    }
}

/* KIEM TRA KHI POST VA EVENT THI SEND EMIAL DE CAC THANH VIEN ( UPDATE VA ADD NEW DEU SEND ); */

function tw_add_post_send_mail()
{
    global $post;
    if ($post->post_type == 'post' || $post->post_type == 'event') {
        if (isset($_GET['message'])) {
            if (isset($_GET['send'])) {
                $arrMember = array(
                    'post_type' => 'member',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'm_active',
                            'value' => 'on',
                        )
                    )
                );
                $memQuery = new WP_Query($arrMember);
                // LAY NOI DUNG BAI VIET THONG QUA ID TREN URL
                if (isset($_GET['post'])) {
                    $postID = (int) $_GET['post'];
                    $post = get_post($postID);
                    $postName = $post->post_name;
                    setup_postdata($post);
                    $title = get_the_title();
                    $content = '<h3>' . $title . '</h3>' . get_the_content() . '<br> <a href="' . home_url($postName) . '">越南台灣商會聯合總</a>';
                    wp_reset_postdata();
                }
                $arrEmail = array();
                if ($memQuery->have_posts()) :
                    while ($memQuery->have_posts()) :
                        $memQuery->the_post();
                        $postMeta = get_post_meta($post->ID);
                        $fullname = $postMeta['m_fullname'][0];
                        $arrEmail[] = $postMeta['m_email'][0];
                    endwhile;
                endif;

                wp_reset_postdata();
                // PHAN SEND EMAIL
                $subj = '越南台灣商會聯合總訊息';
                //$body = 'This is the body of the email';
                wp_mail($arrEmail, $subj, $content);
            } else {
            ?>
                <!--                <script type="text/javascript">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                if (confirm("此內容是否寄Email給會員們!") === true) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    var newURL = window.location.href;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    newURL += '&send=1';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    alert(newURL);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    window.location = newURL;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    window.location='//<?php //echo home_url()                                       
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    // alert(5);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </script>-->
<?php
            }
        }
    }
}

/* DOC CAC THE HTML TRONG NOI DUNG MAIL */
add_filter('wp_mail_content_type', 'set_content_type');

function set_content_type($content_type)
{
    return 'text/html';
}

// TAO ROLE QUYEN MOI LA CUSTOM_MENU_ACCESS DE MENU CON HIEN TREN THANH ADMIN MENU
$subs = get_role('administrator');
$editor = get_role('editor');

$subs->add_cap('custom_menu_access');
$editor->add_cap('custom_menu_access');


// an thanh bardang nhap cua admin
add_filter('show_admin_bar', '__return_false');

// KIEM DU LIEU CHUYEN QUA BANG PHUONG POST HAY GET
// THEM QUYEN HAN CHO GRUOP ROLE
//$group_role= get_role('editor');
////$group_role->remove_cap('manage_options');
//$group_role->add_cap('manage_option');
//echo '<pre>';
//  print_r($group_role);
//  echo '</pre>';
//add_filter( 'posts_search', '__search_by_title_only', 500, 2 );


flush_rewrite_rules(false);
