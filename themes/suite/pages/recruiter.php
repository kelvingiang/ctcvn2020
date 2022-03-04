<?php
/*
  Template Name: Recruiter Page
 */
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
?>
<?php
if (!isset($_SESSION['login'])) {
    wp_redirect(home_url());
}

$place_url = get_query_var('place', '');
$career_url = get_query_var('cat', '');

global $post, $postCount;
//===1  phan trang B ==========
$intNumArticlePerPage = $postCount; // xac dinh so tin 

if (isset($suite['intNumArticlePerPage'])) {
    $intNumArticlePerPage = $suite['intNumArticlePerPage'];
}
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <?php
        $arrRec = array(
            'post_type' => 'recruitment',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'recruitment_category' => 'dangtuyen',
            'meta_query' => array(
                array('key' => '_recruit_status', 'value' => 'on')
            ),
        );
        $recQuery = new WP_Query($arrRec);

        if (!$recQuery->have_posts()) {
            die();
        }

        // ===== 2 PHAN TRANG XAC DI SO TRANG  B==============
        $intPage = ceil(count($recQuery->posts) / $intNumArticlePerPage);

        if (isset($_GET['wp'])) {
            $intCurrentPage = $_GET['wp'] - 1;
        } else {
            $intCurrentPage = 0;
        }
        //        if ($intCurrentPage >= $intPage) {
        //            wp_redirect(get_page_permalink('Forum Page'));
        //        }
        // LAY CAC THONG TIN TRONG POST TYPE FORUM VA VI TRI LAY DONG THONG TIN
        if (!empty($place_url) && empty($career_url)) {
            // echo '  lay du lieu theo place';
            $argsforum = array(
                'post_type' => 'recruitment',
                'posts_per_page' => $intNumArticlePerPage,
                'offset' => $intCurrentPage * $intNumArticlePerPage,
                'recruitment_category' => 'dangtuyen',
                'meta_query' => array(
                    array(
                        'key' => '_recruit_status',
                        'value' => 'on',
                    ),
                    array(
                        'key' => '_recruit_place',
                        'value' => $place_url,
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC',
            );
        } elseif (empty($place_url) && !empty($career_url)) {
            //echo 'lay du lieu theo career';
            $argsforum = array(
                'post_type' => 'recruitment',
                'posts_per_page' => $intNumArticlePerPage,
                'offset' => $intCurrentPage * $intNumArticlePerPage,
                'recruitment_category' => 'dangtuyen',
                'meta_query' => array(
                    array(
                        'key' => '_recruit_status',
                        'value' => 'on',
                    ),
                    array(
                        'key' => '_recruit_career',
                        'value' => $career_url,
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC',
            );
        } elseif (!empty($place_url) && !empty($career_url)) {
            //         echo 'lay du lieu theo 2 phan  place va career';
            $argsforum = array(
                'post_type' => 'recruitment',
                'posts_per_page' => $intNumArticlePerPage,
                'offset' => $intCurrentPage * $intNumArticlePerPage,
                'recruitment_category' => 'dangtuyen',
                'meta_query' => array(
                    array(
                        'key' => '_recruit_status',
                        'value' => 'on',
                    ),
                    array(
                        'key' => '_recruit_place',
                        'value' => $place_url,
                    ),
                    array(
                        'key' => '_recruit_career',
                        'value' => $career_url,
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC',
            );
        } else {
            $argsforum = array(
                'post_type' => 'recruitment',
                'posts_per_page' => $intNumArticlePerPage,
                'offset' => $intCurrentPage * $intNumArticlePerPage,
                'recruitment_category' => 'dangtuyen',
                'meta_query' => array(
                    array(
                        'key' => '_recruit_status',
                        'value' => 'on',
                    ),
                ),
                'orderby' => 'date',
                'order' => 'DESC',
            );
        }
        $myQuery = new WP_Query($argsforum);

        //===== 2 phan trang xac dinh so trang E========
        ?>

        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('recruit', 'suite'); ?></h2>
            </div>
        </div>
        <div class="my-waiting-2">
            <img src="<?php echo PART_IMAGES . 'loading_pr2.gif' ?>" style=" width: 150px" />
        </div>
        <div style="min-height: 70px; padding-left: 50px; padding: 8px 1px; margin-left: 10px; margin-bottom: 10px; background-color: #ccc; border-radius: 3px" class="row">
            <?php
            require_once DIR_CODES . 'my-list.php';
            $myList = new Codes_My_List;
            $placeList = $myList->PlaceList();
            $careerList = $myList->CareerList();
            ?>
            <div class="col-lg-6" style="border-right: 1px #fff solid; margin-bottom: 5px">
                <label style="color: #666; font-size: 2rem">
                    <?php _e('Search By Area', 'suite') ?>
                </label>
                <select id="sel_place" name="sel_place" class="form-control">
                    <?php foreach ($placeList as $key => $val) { ?>
                        <option value="<?php echo $key ?>" <?php echo $place_url == $key ? 'selected="selected"' : '' ?>>
                            <?php echo $val ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-6">
                <label style="color: #666; font-size: 2rem">
                    <?php _e('Search By Job Title') ?>
                </label>
                <select id="sel_career" name="sel_career" class="form-control">
                    <?php foreach ($careerList as $key => $val) { ?>
                        <option value="<?php echo $key ?>" <?php echo $career_url == $key ? 'selected="selected"' : '' ?>>
                            <?php echo $val ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <ul class="article-list" style=" padding-left: 10px; width: 100%">
            <?php
            if ($myQuery->have_posts()) {
                while ($myQuery->have_posts()) :
                    $myQuery->the_post();
                    $placeMeta = get_post_meta($post->ID, '_recruit_place', TRUE);
            ?>
                    <li>
                        <a href="<?php the_permalink() ?>"><?php the_title() ?>
                            <label><?php echo __('Post Date') . ':' .  substr($post->post_date, 0, 10); ?></label>
                        </a>
                    </li>
                <?php
                endwhile;
                ?>
        </ul>

        <!--   // PHAN TRANG PHAN CUOI -->
        <?PHP if ($intPage > 1) { ?>
            <ul class="pro-pagination">
                <?php
                    //  $strUrlArticle = get_page_permalink('Forum Page');

                    $strUrlArticle = $wp_query->query['pagename'];

                    /* << */
                    if ($intCurrentPage >= 1) {
                        echo '<li> <a href="' . $strUrlArticle . '"> << </a> </li> ';
                    } else {
                        echo ' ';
                    }

                    /* < */
                    if ($intPage > 1) {
                        if ($intCurrentPage >= 1) {
                            if ($intCurrentPage == 1) {
                                echo '<li><a href="' . $strUrlArticle . '"><</a></li> ';
                            } else {
                                echo '<li><a href="' . $strUrlArticle . '?wp=' . $intCurrentPage . '"><</a> </li>';
                            }
                        } else {
                            echo ' ';
                        }
                    }

                    /* Same page */
                    if ($intCurrentPage == $intPage - 1) {
                        $intMin = $intCurrentPage - 1;
                        if ($intPage == 2) {
                            $intMin = $intCurrentPage;
                        }
                        for ($i = $intMin; $i < $intCurrentPage + 2; $i++) {
                            if ($i == $intPage) {
                                echo '<li class="selected">' . $i . '</li>';
                            } else {
                                echo ' <li><a href="' . $strUrlArticle . '?wp=' . $i . '">' . $i . '</a> </li>';
                            }
                        }
                    } elseif ($intCurrentPage == 0) {
                        if ($intPage == 2) {
                            $intMax = 3;
                        } elseif ($intPage == 1) {
                            $intMax = 2;
                        } else {
                            $intMax = 4;
                        }

                        for ($i = $intCurrentPage + 1; $i < $intMax; $i++) {
                            if ($i == 1) {
                                echo '<li class="selected" >' . $i . '</li> ';
                            } else {
                                echo '<li><a href="' . $strUrlArticle . '?wp=' . $i . '">' . $i . '</a> </li>';
                            }
                        }
                    } elseif ($intCurrentPage > 0 && $intCurrentPage < $intPage - 1) {
                        for ($i = $intCurrentPage; $i < $intCurrentPage + 3; $i++) {
                            if ($i == $intCurrentPage + 1) {
                                echo '<li class="selected" >' . $i . '</li> ';
                            } else {
                                echo '<li><a href="' . $strUrlArticle . '?wp=' . $i . '">' . $i . '</a> </li>';
                            }
                        }
                    }

                    /* > */
                    if ($intPage > 1) {
                        if ($intCurrentPage < $intPage - 1) {
                            echo '<li><a href="' . $strUrlArticle . '?wp=' . ($intCurrentPage + 2) . '">></a></li> ';
                        } else {
                            echo '';
                        }
                    }

                    /* >> */
                    if ($intCurrentPage < $intPage - 1) {
                        echo '<li><a href="' . $strUrlArticle . '?wp=' . $intPage . '">>></a> </li>';
                    } else {
                        echo ' ';
                    }
                ?>
            </ul>
        <?php
                    // ==== phan cac link cho cac trang va so trang
                }
        ?>
        <div style="float: right">
            <?php
                echo $intPage;
                _e('Page of', 'suite');
                echo $intCurrentPage + 1;
                _e('Page', 'suite');
            ?>
        </div>
    <?php } else {
    ?>
        <div style=' display: flex; justify-content: center;  align-items:flex-start; letter-spacing: 1px'>
            <h2> <?php _e('Can not find any data') ?></h2>
        </div>
    <?php
            }
            wp_reset_postdata();
    ?>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>

</div>
<style>
    .my-waiting-2 {
        display: none;
        background-color: rgba(0, 0, 0, 0.7);
        position: absolute;
        /*
         top: 0px;*/
        width: 100%;
        height: 100vh;
        text-align: center;
        padding-top: 20%;
        z-index: 5000000;
    }
</style>
<script>
    jQuery('document').ready(function() {
        var cc = "<?php echo $career_url ?>";
        var pp = "<?php echo $place_url ?>";
        var my_url = '';
        if (window.location.origin === 'http://localhost') {
            my_url = window.location.origin + '/ctcvn.vn/';
        } else {
            my_url = 'http://ctcvn.vn/';
        }

        jQuery('#sel_place').on('change', function() {
            //            alert(window.location.origin);
            jQuery('.my-waiting-2').css('display', 'block');
            var pageURL = '';
            if (cc === ' ') {
                pageURL = my_url + 'recruiter?place=' + jQuery(this).val();
            } else {
                if (jQuery(this).val() === '00') {
                    pageURL = my_url + 'recruiter?cat=' + cc;
                } else {
                    pageURL = my_url + 'recruiter?place=' + jQuery(this).val() + '&cat=' + cc;
                }
            }
            window.location.href = pageURL;
            //  jQuery('.my-waiting').css('display', 'none');
        });

        jQuery('#sel_career').on('change', function() {
            jQuery('.my-waiting-2').css('display', 'block');
            var pageURL = '';
            if (pp === ' ') {
                pageURL = my_url + 'recruiter?cat=' + jQuery(this).val();
            } else {
                if (jQuery(this).val() === '00') {
                    pageURL = my_url + 'recruiter?place=' + pp;
                } else {
                    pageURL = my_url + 'recruiter?place=' + pp + '&cat=' + jQuery(this).val();
                }
            }
            window.location.href = pageURL;
        });
    });
</script>

<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by