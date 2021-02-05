<?php
/*
  Template Name: Download Page
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
                        <h2 class="head"> <?php _e('下載區')?> </h2>
                    </div>
            </div>
        <?php
            $arrRec1 = array(
             'post_type' => 'download',
             'post_status' => 'publish',
             'posts_per_page' =>  -1,
         );
                $myQuery1 = new WP_Query($arrRec1);
?>
                <div>
                    <?php
                    if ($myQuery1->have_posts()):
                        while ($myQuery1->have_posts()):
                            $myQuery1->the_post();
                             $postMeta = get_post_meta($post->ID);
                            ?>
                            <div style="padding: 10px 5px;  font-weight: bold; border-bottom: 1px solid gray" >
                                <a style=" display: block; text-decoration: none" href="<?php echo $postMeta['d_path'][0]?>"><?php the_title(); ?></a> 
                            </div>
                            <?php
                        endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>  
        
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
 ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
 
 ?>
