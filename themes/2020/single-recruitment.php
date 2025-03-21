<?php
global $post;
// lay phan header
get_header();
wp_link_pages();
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row" >
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12" style="margin-top: 12px">
        <!-- lay cac bai post  -->
        <?php
        //===== ARTICLE INFOMATION ====================================================
        $mainID = $post->ID;
        $meta = get_post_meta($mainID);
        ?>
        <div class="orange-group">
            <div class="orange-title"> 
                <label><?php the_title(); ?></label>
            </div>

            <div  class="info-bg">
                <div class="post-info">
                    <label> <?php _e('發布者 :', 'suite'); ?><?php echo $meta['_recruit_postby'][0] ?></label><br>
                    <label>
                        <?php _e('發布日期 : ', 'suite'); ?> <?php echo $post->post_date; ?>
                    </label> 
                </div>
                <?php
                if (!empty($meta['_recruit_company_tw'][0])) {
                    $cate = 'dangtuyen';
                } else {
                    $cate = 'ungtuyen';
                }
                ?>
                <?php if ($cate == 'dangtuyen') { ?>
                    <div class="dangtuyen">    

                        <?php if (!empty($meta['_recruit_company_tw'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label  class="label-title"><?php _e('Company Tw', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label><?php echo $meta['_recruit_company_tw'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_company_en'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label  class="label-title"><?php _e('Company En', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label><?php echo $meta['_recruit_company_en'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_company_vn'][0])) { ?>                       
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label  class="label-title"><?php _e('Company Vn', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label><?php echo $meta['_recruit_company_vn'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_address'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('Address', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label ><?php echo $meta['_recruit_address'][0] ?></label>
                                </div>
                            </div> 
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_phone'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('Phone', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label ><?php echo $meta['_recruit_phone'][0] ?></label>
                                </div>
                            </div> 
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_email'][0])) { ?>                    
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('Email', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label ><?php echo $meta['_recruit_email'][0] ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_count'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('number of employees of the company', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label ><?php echo $meta['_recruit_count'][0] ?></label>
                                </div>
                            </div> 
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_summary'][0])) { ?>                    
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('Company Summary', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <label style="word-break: break-word;"><?php echo $meta['_recruit_summary'][0] ?></label> 
                                </div>
                            </div> 
                        <?php } ?>

                        <hr style="border: 2px  #999 dotted">

                        <?php if (!empty($meta['_recruit_lack_job'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('職缺名稱', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <?php echo $meta['_recruit_lack_job'][0] ?>
                                </div>
                            </div> 
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_lack_count'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 col-sm-12 col-xs-12">
                                    <label class="label-title"><?php _e('職缺人數', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10 col-sm-12 col-xs-12">
                                    <?php echo $meta['_recruit_lack_count'][0] ?>
                                </div>
                            </div> 
                        <?php } ?>

                        <div class="row" >
                            <?php $sex = $meta['_recruit_sex'][0]; ?>
                            <div class="col-md-2"> <label for="r_com_sex" class="label-title" ><?php _e('Sex', 'suite'); ?> : </label></div> 
                            <div class="col-md-10"> 
                                <label id="r_com_sex" name="r_com_sex"> <?php
                                    if ($sex == '3') {
                                        _e('Male/Female', 'suite');
                                    } elseif ($sex == 1) {
                                        _e('Male', 'suite');
                                    } elseif ($sex == 2) {
                                        _e('Female', 'suite');
                                    }
                                    ?></label>
                            </div>
                        </div>
                        <?php if (!empty($meta['_recruit_date_from'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label  class="label-title"><?php _e('有效日期', 'suite'); ?> :</label>
                                </div>
                                <div class="col-md-10">
                                    <label > <?php echo $meta['_recruit_date_from'][0]; ?></label>
                                    <label  class="label-title"  style=" margin: 0px 20px"><?php _e('To', 'suite'); ?></label>
                                    <label ><?php echo $meta['_recruit_date_to'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_level'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title"><?php _e('Level', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label><?php echo $meta['_recruit_level'][0]; ?></label> </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_experience'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title" ><?php _e('Experiences', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label ><?php echo $meta['_recruit_experience'][0]; ?></label> </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_age_from'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2 ">
                                    <label for="r_com_date" class="label-title"><?php _e('Age', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_age_from'][0]; ?></label>
                                    <label  class="label-title" style=" margin: 0px 20px"><?php _e('To', 'suite'); ?></label>
                                    <label><?php echo $meta['_recruit_age_to'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_language'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title" ><?php _e('Foreign Languages', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label><?php echo $meta['_recruit_language'][0]; ?></label> </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_work_space'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title" ><?php _e('Work Space', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label><?php echo $meta['_recruit_work_space'][0]; ?></label> </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_salary'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title" ><?php _e('Salary', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label><?php echo $meta['_recruit_salary'][0]; ?></label> </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_orther'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2"><label class="label-title"><?php _e('Another', 'suite'); ?> : </label></div>
                                <div class="col-md-10"><label <label style="word-break: break-word;"> <?php echo $meta['_recruit_orther'][0]; ?></label></div> 
                            </div>
                        <?php } ?>
                        <hr style="border: 2px #999 dotted">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px; margin-top: 10px"> 
                            <label class="label-title" style="font-size: 18px"><?php _e('人事聯絡室', 'suite'); ?></label>
                        </div>
                        <?php if (!empty($meta['_recruit_contact_name'][0])) { ?>
                            <div class="row" style="margin-left: 10px">
                                <div class="col-md-2 col-sm-3 col-xs-12"><label class="label-title"><?php _e('Name', 'suite'); ?></label></div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <label><?php echo $meta['_recruit_contact_name'][0] ?> </label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_contact_phone'][0])) { ?>
                            <div class="row" style="margin-left: 10px">
                                <div class="col-md-2 col-sm-3 col-xs-12"><label class="label-title"><?php _e('Phone', 'suite'); ?></label></div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <label><?php echo $meta['_recruit_contact_phone'][0] ?></label>
                                </div> 
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_contact_email'][0])) { ?>
                            <div class="row" style="margin-left: 10px">
                                <div class="col-md-2 col-sm-3 col-xs-12"><label class="label-title"><?php _e('Email', 'suite'); ?></label></div>
                                <div class="col-md-10 col-sm-9 col-xs-12">
                                    <label><?php echo $meta['_recruit_contact_email'][0] ?> </label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } elseif ($cate == 'ungtuyen') { ?>
                    <div class="ungtuyen">     
                        <?php if (!empty($meta['_recruit_img'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label></label>
                                </div>
                                <div class="col-md-10">
                                    <?php if (!empty($meta['_recruit_img'][0])) { ?>
                                        <img  style="margin: 10px 20px" src="<?php echo WB_URL_IMAGES_APPLY . $meta['_recruit_img'][0] ?>" width="200px"/>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-md-2">
                                <label  class="label-title"><?php _e('Full Name', 'suite'); ?> : </label>
                            </div>
                            <div class="col-md-10">
                                <label ><?php echo $meta['_recruit_fullname'][0]; ?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><label  class="label-title"><?php _e('Brith of date', 'suite'); ?> : </label></div>
                            <div class="col-md-10"><label ><?php echo $meta['_recruit_birthday'][0]; ?></label></div>
                        </div>
                        <div class="row" >
                            <?php $sex = $meta['_recruit_sex'][0]; ?>
                            <div class="col-md-2"> 
                                <label class="label-title" ><?php _e('Sex', 'suite'); ?> : </label>
                            </div> 
                            <div class="col-md-10"> 
                                <label> <?php echo $meta['_recruit_sex'][0] == 1 ? _e('Male', 'suite') : _e('Female', 'suite') ?></label> 
                                <label style="color:  #666; font-size: 12px; padding-left: 15px"> <?php echo $meta['_recruit_drive'][0] == 'on' ? " (具備駕駛執照) " : ' ' ?></label> 
                            </div>
                        </div>

                        <?php if (!empty($meta['_recruit_height'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('Height and weight', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_height'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>



                        <?php if (!empty($meta['_recruit_address'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('Address', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_address'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_email'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="label-title"><?php _e('Email', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label ><?php echo $meta['_recruit_email'][0]; ?></label> 
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_phone'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('Phone', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_phone'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_line'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('Line 帳號', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_line'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_level'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="label-title" ><?php _e('Level', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_level'][0]; ?></label> 
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_height'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('School Department', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_department'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_experience'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="label-title" ><?php _e('Experiences', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_experience'][0]; ?></label> 
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_work'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('最快可上班日', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_work'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>


                        <?php if (!empty($meta['_recruit_job'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('希望職務類別', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_job'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_salary'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('希望薪資待遇', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_salary'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_industry'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('希望從事的產業別', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_industry'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_language'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('語言能力', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_language'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_license'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('證照資格', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_license'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_software'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2" >
                                    <label class="label-title" ><?php _e('擅長軟體', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label><?php echo $meta['_recruit_software'][0]; ?></label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!empty($meta['_recruit_another'][0])) { ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="label-title"><?php _e('Another', 'suite'); ?> : </label>
                                </div>
                                <div class="col-md-10">
                                    <label id="another" name="another"> <?php echo $meta['_recruit_another'][0]; ?></label>
                                </div> 
                            </div>
                        <?php } ?>
                    </div>   
                <?php } ?>
            </div>
        </div>
        <hr>


        <!-- PHAN HOW CAC THONG KHAC CHUNG NHOM  UNGTUYEN HAY DANGTUYEN     -->

        <?php
        global $suite, $post, $postCount;
        //===1  phan trang B ==========
        $intNumArticlePerPage = $postCount; // xac dinh so tin 
        if (isset($suite['intNumArticlePerPage'])) {
            $intNumArticlePerPage = $suite['intNumArticlePerPage'];
        }
        $arrRec = array(
            'post_type' => 'recruitment',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'recruitment_category' => $cate,
            'meta_query' => array(
                array('key' => '_recruit_status', 'value' => 'on')
            ),
        );
        $recQuery = new WP_Query($arrRec);
        // ===== 2 PHAN TRANG XAC DI SO TRANG  B==============
        $intPage = ceil(count($recQuery->posts) / $intNumArticlePerPage);
        if ($_GET['wp']) {
            $intCurrentPage = $_GET['wp'] - 1;
        } else {
            $intCurrentPage = 0;
        }
        if ($intCurrentPage >= $intPage) {
            wp_redirect(get_page_permalink('Forum Page'));
        }
// LAY CAC THONG TIN TRONG POST TYPE FORUM VA VI TRI LAY DONG THONG TIN
        $argsforum = array(
            'post_type' => 'recruitment',
            'posts_per_page' => $intNumArticlePerPage,
            'offset' => $intCurrentPage * $intNumArticlePerPage,
            'recruitment_category' => $cate,
            'meta_query' => array(
                array(
                    'key' => '_recruit_status', 'value' => 'on',
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $myQuery = new WP_Query($argsforum);

//===== 2 phan trang xac dinh so trang E========
        ?>
        <?php
        if (get_query_var('page') == '') {
            $getWP = 1;
        } else {
            $getWP = get_query_var('page');
        }
        ?>     
        <div class="blue-group">
            <div class="blue-title">
                <label><?php echo $cate == 'dangtuyen' ? ' 求 才' : ' 求 職' ?></label>
            </div>
            <ul class="article-list">
                <?php
                global $post;
                if ($myQuery->have_posts()):
                    while ($myQuery->have_posts()):
                        $myQuery->the_post();
                        if ($mainID == $post->ID)
                            continue;
                        ?>
                        <li>
                            <a href="<?php the_permalink() ?>/<?php echo $getWP; ?>"><?php the_title() ?>
                                <label style="font-size: 9px; color: #666666; float: right; padding-right: 3px">發布 : <?php echo substr($post->post_date, 0, 10) ?></label>
                            </a>  
                        </li>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </ul>  
        </div>
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
            <?php _e('第', 'suite'); ?>  <?php echo $intCurrentPage + 1 ?>   <?php _e('頁的', 'suite'); ?> <?php echo $intPage ?> <?php _e('頁', 'suite'); ?> 
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
    });
</script>
<?php
// lay phan footer
get_footer();

