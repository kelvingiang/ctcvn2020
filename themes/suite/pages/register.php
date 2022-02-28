<?php
/*
  Template Name: Register Page
 */
?>

<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
            get_template_part('templates/template', 'profile');
        } else {
            get_template_part('templates/template', 'register');
        }
        ?>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
 




