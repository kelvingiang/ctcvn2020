<ul id="flexisel">
    <?php
    $arr = array(
        'post_type' => 'advertising',
        'posts_per_page' => -1,
        'orderby' => 'ID',
        'order' => 'ASC',
    );

    $my_query = new WP_Query($arr);

    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            $objImageData = get_post(get_post_thumbnail_id(get_the_ID()));
            $strAlt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
            ?>
            <li>      
                <a href="<?php echo get_post_meta(get_the_ID(), '_tw_metabox_email', TRUE) ?>" target="_blank">
                    <div class="box">
                        <div style="height: 170px;  margin: auto auto">
                            <img src="<?php echo $images[0]; ?>"  alt="<?php echo $strAlt; ?>" title="<?php echo $objImageData->post_title; ?>" />
                        </div>
                        <div class="nbs-flexisel-title">
                            <?php the_title(); ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php
        }
        wp_reset_postdata();
        wp_reset_query();
    }
    $item = 2;
//    if (is_page()) {
//        $item =2;
//    } else {
//        $item = 1;
//    }
    ?>
</ul>
<div class="clearout"></div>
<script type="text/javascript">
    jQuery("#flexisel").flexisel({
        visibleItems: <?php echo $item ?>,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 3000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        vertical: false,
        responsiveBreakpoints: {
            portrait: {
                changePoint: 480,
                visibleItems: 1
            },
            landscape: {
                changePoint: 640,
                visibleItems: 2
            },
            tablet: {
                changePoint: 768,
                visibleItems: 3
            }
        }
    });
</script>    
