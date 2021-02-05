<?php
if (isset($_SESSION['login'])) {
    $login_type = $_SESSION['login_type'];
}
?>
<style>
    .menu-item-66, .menu-item-71, .menu-item-2038, .menu-item-2039{
        display: none;
    }
</style>

<!--HIEN THI MENU TREN WEB-->
<div id="menu-computer" ><?php suite_menu('primary-menu') ?></div>
<!--HIEN THI MENU TREN MOBILE-->
<div  id="menu-moblie" >
    <div id="show_menu" > 選 項 </div>
    <?php suite_menu('mobile-menu') ?> 
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
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
            jQuery('.menu-item-2039').css('display', 'noen');
            jQuery('.menu-item-2038').css('display', 'block');
        }

        jQuery('.mobile-menu').css('display', 'none');
        jQuery('#show_menu').click(function () {
            jQuery('.mobile-menu').toggle("slow");
        });
    });
</script>
