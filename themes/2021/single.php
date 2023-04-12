<?php
// lay phan header
get_header();
wp_link_pages(); // HIEN THI PHAN TRANG BAI VIET KHI TRONG BAI CO CHEN <!--nextpage--> TRONG PHAN text
// moi mot <!--nextpage--> se chia thanh  1 trang
// $category = get_the_category(); echo $category[0]->name;
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <!-- lay cac bai post  -->
        <div>
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    get_template_part('content', get_post_format());
                endwhile;
            endif;
            ?>
        </div>
        <div style="margin-top: 2rem; border-top: 2rem #04366c solid">
            <ul id="data-list" class="article-list">
                <?php
// LAY CAC THONG TIN TRONG POST TYPE FORUM VA VI TRI LAY DONG THONG TIN

                $argsforum = array(
                    'post_type' => 'post',
                    'posts_per_page' => 10,
                    'offset' => $post_count,
                    'category_name' => $_SESSION['caterogy'],
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $myQuery = new WP_Query($argsforum);
                if ($myQuery->have_posts()):
                    $stt = $post_count + 1;
                    while ($myQuery->have_posts()):
                        $myQuery->the_post();
                        ?>
                        <li data-id="<?php echo $stt ?>">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                        <?php
                        $stt += 1;
                    endwhile;
                endif;
                wp_reset_query();
                ?>
            </ul>
            <div id="load-more">
                <i  style=" font-size: 35px; color: #999; height: 50px" class="fa fa-angle-double-down" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class = "col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar('single')
        ?>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('#load-more').click(function () {
            var lastID = jQuery("#data-list > li:last-child").attr("data-id");
            var caterogy = '<?php echo $_SESSION['caterogy'] ?>';
            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/load-news.php' ?>', // lay doi tuong chuyen sang dang array
                type: 'post', //                data: $(this).serialize(),
                data: {lastID: lastID, caterogy: caterogy},
                dataType: 'json',
                success: function (data) {  // set ket qua tra ve  data tra ve co thanh phan status va message
                    if (data.status === 'done') {
                        jQuery("#data-list").append(data.html);
                    } else if (data.status === 'empty') {
                        jQuery("#load-more").hide();
                    }
                },
                error: function (xhr) {
                    console.log(xhr.reponseText);
                    //console.log(data.status);
                }
            });
        });
    });
</script>



<?php
// lay phan footer
get_footer();

