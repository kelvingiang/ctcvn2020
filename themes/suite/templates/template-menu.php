<?php
if (isset($_SESSION['login'])) {
    $login_type = $_SESSION['login_type'];
}
?>
<style>
    .menu-item-66,
    .menu-item-71,
    .menu-item-2038,
    .menu-item-2039 {
        display: none;
    }
</style>

<!--MAIN MENU FOR COMPUTER-->

<div id="menu-computer">
    <?php
    switch ($_SESSION['languages']) {
        case 'cn':
            suite_menu('company-menu-cn');
            break;
        case 'en':
            suite_menu('company-menu-en');
            break;
        case 'en':
            suite_menu('company-menu-vn');
            break;
    }
    ?>
</div>

<!--MAIN MENU FOR MOBILE-->
<div id="menu-mobile">
    <div id="show_menu"> 選 項 </div>
    <?php suite_menu('mobile-menu') ?>
    <div style="clear: both"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var login_type = "<?php echo $login_type ?>";

        if (login_type === "apply") {
            jQuery('.menu-item-66').css('display', 'block');
            jQuery('.menu-item-71').css('display', 'none');
            jQuery('.menu-item-2039').css('display', 'block');
            jQuery('.menu-item-2038').css('display', 'none');
        }

        if (login_type === "recruit" || login_type === "on") {
            jQuery('.menu-item-66').css('display', 'none');
            jQuery('.menu-item-71').css('display', 'block');
            jQuery('.menu-item-2039').css('display', 'none');
            jQuery('.menu-item-2038').css('display', 'block');
        }

        jQuery('#menu-mobile-menu').css('display', 'none');

        jQuery('#show_menu').click(function() {

            var ss = jQuery('#menu-mobile-menu').css('display');
            if (ss == 'none') {
                jQuery('#menu-mobile-menu').slideDown('slow');
            } else {
                jQuery('#menu-mobile-menu').slideUp('fast');
            }
        });
    });
</script>