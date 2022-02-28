<?php
/*
  Template Name:  Supervisor  Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
global $post;
//===1  phan trang E ==========
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
      <!-- lay cac tin trong forum va phan trang -->
            <?php
// lay cac tin trong ban 
            $argsforum = array(
                'post_type' => 'event',
             //   'posts_per_page' => $intNumArticlePerPage,
           //     'offset' => $intCurrentPage * $intNumArticlePerPage,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $myQuery = new WP_Query($argsforum);
            if ($myQuery->have_posts()):
                while ($myQuery->have_posts()):
                    $myQuery->the_post();
                    ?>
            <div>
              <!--  <a style=" font-size: 25px " href="<?php// the_permalink(); ?>"> <?php //the_title(); ?>  </a> -->
            <div class='head-title'>
                    <div class="title">
                        <h2 class="head"> <?php the_title(); ?> </h2>
                    </div>
            </div>
           <!--      <div >
               <label>
                        at : <?php // echo $post->post_date . '</br>'; ?>
                    </label> 
                    <label>
                        --  modified :
                        <?php // echo $post->post_modified . '</br>'; ?>
                    </label> 
                    <label id="mess"></label>
                </div> -->
                <div>
                    <label style=" font-size: 14px; color: #BFBFBF">
                        <?php 
                            if(get_post_meta($post->ID, 'e_end_date', TRUE)!=='')   
                                  $endDate = get_post_meta($post->ID, 'e_end_date', TRUE). ' -- ' ; 
                           else
                                  $endDate='' ;   
                           if(get_post_meta($post->ID,'e_end_time',true) !=='')
                                   $endTime = '&nbsp;'.get_post_meta($post->ID,'e_end_time',true);
                            else 
                                   $endTime =''
                           ?>
                         從  <?php echo get_post_meta($post->ID, 'e_start_date', TRUE); ?>
                        -- <?php echo get_post_meta($post->ID, 'e_start_time', TRUE); ?>
                        至  <?php echo $endDate; ?>  <?php echo $endTime ?> 

                    </label>
                </div>
            <p style="font-size: 15px; line-height: 1.5  "><?php  the_content();?></p> 
            </div> 
                            
                 <?php
                endwhile;
            endif;
            wp_reset_query();
            wp_reset_postdata();
        ?>

    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
?>
<script type="text/javascript">
    $(document).ready(function() {
//         $('#join-event').click(function(){
   //          $('#join').slideToggle("slow");
   //      });
     });
</script>

