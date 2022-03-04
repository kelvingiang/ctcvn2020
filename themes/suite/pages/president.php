<?php
/*
  Template Name:  Presidents  Page
 */

ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
global $wpdb;
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <?php
        $args = array(
            'post_type' => 'president',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                'event_start_branch' => array(
                    'key' => '_president_branch',
                    'compare' => 'EXISTS',
                ),
                'event_start_year' => array(
                    'key' => '_president_year',
                    'compare' => 'EXISTS',
                ),
            ),
            'orderby' => array(
                'event_start_branch' => 'ASC',
                'event_start_year' => 'DESC',
            ),
        );
        $wp_query = new WP_Query($args);
        ?>
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> 歷 屆 會 長 </h2>
            </div>
        </div>
        <div>
            <?php
            $currentBranch = '';

            if ($wp_query->have_posts()) :
                $stt = 0;
                while ($wp_query->have_posts()) :
                    $wp_query->the_post();
                    $Branch = get_post_meta(get_the_ID(), '_president_branch', true);
            ?>

                    <?php
                    $myList = new Codes_My_List();
                    if ($Branch != $currentBranch) {
                    ?>
                        <div class="my_list_title" data-target="<?php echo get_post_meta(get_the_ID(), '_president_branch', true) ?>">
                            <label><?php echo $myList->get_country(get_post_meta(get_the_ID(), '_president_branch', true)); ?></label>
                        </div>

                    <?php
                        $currentBranch = $Branch;
                    }
                    ?>
                    <div class="my_list_content <?php echo get_post_meta(get_the_ID(), '_president_branch', true) ?>">
                        <div class="row  my_list  ">
                            <div class=" col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                <label style="margin-left: 10px; font-size: 18px"> <?php the_title(); ?></label>
                            </div>
                            <div class=" col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                <label style="margin-left: 10px"> <?php echo get_post_meta(get_the_ID(), '_president_year', true); ?> 年 度 </label>
                            </div>
                            <div class=" col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                <label style="margin-left: 10px"> 第 <?php echo get_post_meta(get_the_ID(), '_president_term', true); ?> 屆</label>
                            </div>
                        </div>
                    </div>
            <?php
                    $stt++;
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.0001').slideDown();
        jQuery('.my_list_title').click(function() {
            var _showClass = jQuery(this).data('target');
            var ss = "." + _showClass;
            jQuery('.my_list_content').slideUp('slow');
            jQuery(ss).slideDown('slow');
        });
    });
</script>

<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
