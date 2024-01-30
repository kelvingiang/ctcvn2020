<!-- slider -->
<style type="text/css">
    .container_skitter .image_main {
        width: 100%;
        height: 500px;
    }

    .box_skitter {
        width: 100%;
    }

    .box_skitter img {
        width: 100%;
    }
</style>
<!--  KHOI TAO VIEC CHAY SLIDER -->
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function() {
        jQuery('.box_skitter_large').skitter({
            theme: 'clean',
            numbers_align: 'right',
            progressbar: true,
            dots: true,
            preview: true,
            interval: 8000 // thoi gian chuyen hinh]
        });
    });
</script>
<?php
//PHAN GO BO CLASS MAC CUA WP CHO IMG 'wp-post-image'
//        function wps_post_thumbnail_remove_class($output) {
//                $output = preg_replace('/wp-post-image/', '', $output);
//                return $output;
//        }
//        add_filter('post_thumbnail_html', 'wps_post_thumbnail_remove_class');
//        
//        function wps_post_thumbnail_remove_width($output) {
//                $output = preg_replace('/width=".*?"/', 'width="100%"', $output);
//                return $output;
//        }
//        add_filter('post_thumbnail_html', 'wps_post_thumbnail_remove_width');
//        
//        function wps_post_thumbnail_remove_height($output) {
//                $output = preg_replace('/height=".*?"/', '', $output);
//                return $output;
//        }
//        add_filter('post_thumbnail_html', 'wps_post_thumbnail_remove_height');
?>

<div class="border_box">
    <div class="box_skitter box_skitter_large">
        <ul>
            <?php
            //  global $post, $posts;
            $args = array('post_type' => 'slide', 'posts_per_page' => -1);
            $loop = new WP_Query($args);
            $stt = 0;
            if ($loop->have_posts()) :
                while ($loop->have_posts()) :
                    $stt++;
                    //cac hieu ung chuyen doi lay
                    $a = array("fade", "circlesRotate", "blindHeight", "circles", "swapBars", "tube", "cubeJelly", "blindWidth", "paralell", "showBarsRandom", "block");
                    $random_keys = array_rand($a); // random array tren de doi hieu ung
                    $loop->the_post();
            ?>
                    <li><?php the_post_thumbnail('', array('class' => $a[$random_keys], 'title' => the_title_attribute('echo=0'))); ?>
                        <div class="label_text">
                            <h2 style=" color: white ; margin-left: 20px; font-size: 20px"><?php the_title(); ?></h2>
                        </div>
                    </li>
            <?php
                endwhile;
            endif;
            wp_reset_postdata()
            ?>
        </ul>
    </div>
</div>