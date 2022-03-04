<?php


/* them menu co phan khai bao thay doi ngon ngu o phan __  thong qua textdomain */
register_nav_menu('company-menu-cn', __('Company Menu Chinese', 'suite')); // goi menu de show
register_nav_menu('company-menu-en', __('Company Menu English', 'suite')); // goi menu de show
register_nav_menu('company-menu-vn', __('Company Menu Vietnamese', 'suite')); // goi menu de show
register_nav_menu('mobile-menu', __('Mobile name', 'suite')); // goi menu de show





function suite_menu($slug)
{
    $menu = array(
        'theme_location' => $slug, // chon menu dc thiet lap truoc
        'container' => 'nav', // tap html chua menu nay
        'container_class' => 'primary-menu', // class cua mennu
        'items_wrap' => '<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>'
    );
    wp_nav_menu($menu);
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
