<?php
/*
  Template Name: Info Main Page
 */
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
$caterogy = 'main-info';
$post_count = 5;
$_SESSION['caterogy'] = $caterogy;
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12" style ="margin-bottom: 10px">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('總會信息', 'suite'); ?> </h2>
            </div>
        </div>
         <?php Post_list_style($caterogy, $post_count) ?>
    </div> 
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>




<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
 
