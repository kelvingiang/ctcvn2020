<?php
/*
  Template Name: About Main Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <div class='head-title'>
            <div class="title">
                <h2> <?php _e('越南台灣商會聯合總會章程') ?> </h2>
            </div>
        </div>
        <div class="info-bg">
            <?php echo get_post_meta('1', '_charter_chamber', true) ?>
        </div>  
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
