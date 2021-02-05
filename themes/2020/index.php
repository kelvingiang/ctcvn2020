<?php
// lay phan header
get_header();
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row" style="padding: 0px 10px 0px 10px">

    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12" >
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 index-silder-index" style="margin-bottom: 20px; margin-top: 15px">
            <?php get_template_part('templates/template', 'silder'); ?>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="index-advertising-speac" >
                    <?php get_template_part('templates/template', 'advertising'); ?>
                </div>

                <div class="" >
                    <image src="<?php echo get_image('map.jpg') ?>" alt ="ctcvn" title="ctcvn" style="width: 100%; margin: 20px 0px" /> 
                </div>

                <div  class="index-friend-speac">
                    <?php get_template_part('templates/template', 'friendlink') ?>
                </div>
            </div>
            <div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12" style="background-color: #dcdfe1 ; padding-top: 20px">
                <div class="index-event-speac">
                    <?php get_template_part('templates/template', 'event') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <?php get_sidebar(); ?>
        <div  class="index-friend-speac-sidebar">
            <?php get_template_part('templates/template', 'friendlink') ?>
        </div>
    </div>
</div>


<?php
// lay phan footer
get_footer();


