<!-- slider -->
<style type="text/css">
    .border_box {

        margin: 0;
    }

    .box_skitter_large {
        height: 600px;
    }

    .container_skitter img {

        text-align: center;

    }

    .box_skitter {
        width: 100%;
    }

    .label_skitter {
        background-color: transparent !important;
    }

    .image_main {
        height: 600px;
        width: 100%;
    }
</style>
<!--  KHOI TAO VIEC CHAY SLIDER -->
<script type="text/javascript" language="javascript">
    jQuery(document).ready(function() {
        jQuery('.box_skitter_large').skitter({
            thumbs: false,
            theme: 'Minimalist',
            numbers_align: 'center',
            numbers: false,
            progressbar: false,
            dots: false,
            navigation: false,
            preview: false,
            interval: 8000 // thoi gian chuyen hinh]
        });
    });
</script>

<div class="border_box" style="background-color: red;">
    <div class="box_skitter box_skitter_large">
        <ul>
            <?php
            //  global $post, $posts;
            $args = array(
                'post_type' => 'slide',
                'posts_per_page' => -1,
                'slide_category' => 'home',
            );
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
                    <li>
                        <?php the_post_thumbnail('', array('class' => $a[$random_keys], 'title' => the_title_attribute('echo=0'))); ?>
                        <div class="label_text">
                            <h2 style=" color: white ; margin-left: 20px; font-size: 20px"><?php // the_title(); 
                                                                                            ?></h2>
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