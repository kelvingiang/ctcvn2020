<?php
/*
  Template Name: Recruitments Page
 */
?>
<?php
if (!isset($_SESSION['login'])) {
    wp_redirect(home_url());
}
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <?php
        // PHAN TRANG PHAN 1
        global $suite, $postCount;
        //===1  phan trang B ==========
        $intNumArticlePerPage = $postCount; // xac dinh so tin 
        if (isset($suite['intNumArticlePerPage'])) {
            $intNumArticlePerPage = $suite['intNumArticlePerPage'];
        }


        $arrRec = array(
            'post_type' => 'recruitment',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'recruitment_category' => 'ungtuyen',
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
        if ($_GET['wp']) {
            $intCurrentPage = $_GET['wp'] - 1;
        } else {
            $intCurrentPage = 0;
        }
       
// LAY CAC THONG TIN TRONG POST TYPE FORUM VA VI TRI LAY DONG THONG TIN
        $argsforum = array(
            'post_type' => 'recruitment',
            'posts_per_page' => $intNumArticlePerPage,
            'offset' => $intCurrentPage * $intNumArticlePerPage,
            'recruitment_category' => 'ungtuyen',
            'meta_query' => array(
                array(
                    'key' => '_recruit_status',
                    'value' => 'on',
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $myQuery = new WP_Query($argsforum);

//===== 2 phan trang xac dinh so trang E========
        ?>
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e(' 求 職 ', 'suite'); ?> </h2>
            </div>
        </div>
        <ul class="article-list">
            <?php
            global $post;
            if ($myQuery->have_posts()):
                while ($myQuery->have_posts()):
                    $myQuery->the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink() ?>"><?php the_title() ?>
                            <label>發布 : <?php echo substr($post->post_date, 0, 10) ?></label>
                        </a>  
                    </li>
                    <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </ul>  

        <!--    PHAN TRANG PHAN CUOI -->
        <?PHP if ($intPage > 1) { ?>
            <ul class="pro-pagination">
                <?php
                $strUrlArticle = get_page_permalink('Forum Page');
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
                            echo ' <li><a href="' . $strUrlArticle .'?wp=' . $i . '">' . $i . '</a> </li>';
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
            _e('頁, 的第', 'suite');
            echo $intCurrentPage + 1;
            _e('頁', 'suite');
            ?> 
        </div>
    </div>
    <div class="ccol-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
 