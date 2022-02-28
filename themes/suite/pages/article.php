<?php
/*
  Template Name: Article  Page
 */
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
$uri = $_SERVER['REQUEST_URI'];  // lay url tai trang hien hanh
// ====== phan lay ID user thong qua $_SESSION['login']==============;
$arr = array(
    'post_type' => 'member',
    'meta_query' => array(
        array('key' => 'm_user', 'value' => $_SESSION['login'])
    ),
);
$objMember = current(get_posts($arr));

//===================================
//KIEM TRA DU LIEU NHAP VAO
if ($_POST) {
    $errNew = '';
    $errUpdate = '';

    // KIEM TRA DU LIEU TRONG PHAN ADD NEW
    if (isset($_POST['txt_title'])) {
        $txt_new_title = $_POST['txt_title'];
        $back_new_title = checkstr($txt_new_title);
        if (!empty($back_new_title)) {
            $err_new_title = '標題' . $back_new_title;
            $errNew = $errNew . ', titlle';
        } else {
            $txt_title = $txt_new_title;
        }
    }

    if (isset($_POST['editor'])) {
        $txt_new_content = $_POST['editor'];
        $back_new_content = checkstr($txt_new_content);
        if (!empty($back_new_content)) {
            $err_new_content = '內容' . $back_new_content;
            $errNew = $errNew . ', content';
        } else {
            $txt_content = $txt_new_content;
        }
    }
}
// PHAN ADD NEW BAI VIET
if (empty($errNew)) {
    if (!empty($_POST['txt_title'])) {

        // FUNCTION checkContent duoc viet o function.php de kiem tra cac tu khong cho phep;
        //if (checkContent($_POST['editor'])) {
        $catePost = (int) $_POST['cate'];
        $cat = array($catePost);
        //    $editor_settings = Common::$_wpeditor;
        $newArticle = array(
            'post_author' => $objMember->ID,
            'post_title' => esc_attr($_POST['txt_title']),
            'post_content' => $_POST['editor'],
            'post_category' => $cat,
            'post_status' => 'publish',
            'post_type' => 'forum'
        );
        //add post moi
        $articleMeta = wp_insert_post($newArticle);
        // them catetegory cho post
        wp_set_object_terms($articleMeta, $cat, 'forum_category');
        // Save phan metabox active //
        update_post_meta($articleMeta, 'f_postby', $_SESSION['login']);
        update_post_meta($articleMeta, 'f_active', 'on');
        update_post_meta($articleMeta, 'f_like', 0);
        update_post_meta($articleMeta, 'f_view', 0);
        update_post_meta($articleMeta, 'seo_title', esc_attr(substr($_POST['txt_title'], 0, 20)));
        update_post_meta($articleMeta, 'seo_description', esc_attr($_POST['txt_title']));
        update_post_meta($articleMeta, 'seo_keywords', esc_attr($_POST['cate']));
        $txt_cate = '';
        $txt_title = '';
        $txt_content = '';
        wp_redirect(esc_url(remove_query_arg('id', $uri)));  // PHAN XOA ID TREN THANH URL VA KHONG CO INSERT KHI REFRESH
    } else {
        $txt_cate = $_POST['cate'];
        $txt_title = $_POST['txt_title'];
        $txt_content = $_POST['editor'];
        $err_new_content = '請刪除含有色情的字眼 ';
    }
}
//}
// PHAN UPDATE BAI VIET
if (empty($errUpdate)) {
    if (!empty($_POST['update_title'])) {

        // if (checkContent($_POST['update_editor'])) {
        $arrUpdate = array(
            'ID' => esc_attr($_POST['update_id']),
            'post_title' => esc_attr($_POST['update_title']),
            'post_content' => $_POST['update_editor']
        );
        wp_update_post($arrUpdate);
        wp_set_object_terms($_POST['update_id'], array((int) $_POST['update_cate']), 'forum_category'); // cap nhat lai taxonomy
        wp_redirect(esc_url(remove_query_arg('id', $uri)));
    } else {
        $err_update_content = '請刪除含有色情的字眼';
    }
}
//}
//XOA BAI VIET
if (!$_GET['del'] == '') {
    wp_trash_post($_GET['del']);
    wp_redirect(esc_url(remove_query_arg('del', $uri)));
}
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('在留言區已發表', 'suite'); ?> </h2>
            </div>
        </div>

        <?php if ($_GET['id'] == '') {
        ?>
        <form id="f_article" method="post" action="#">
            <div style="width: 98%; margin-left: 20px">
                <!-- phan lay category  -->
                <div class='row'>
                    <div class='col-md-3'> <label class="label-title"><?php echo _e('Category', 'suite') ?></label>
                    </div>
                    <?php
                        $argsCate = array(
                            'type' => 'forum',
                            'orderby' => 'meta_value',
                            'order' => 'ASC',
                            'taxonomy' => 'forum_category',
                            'hide_empty' => 0,
                            'parent' => 0,
                        );
                        $categories = get_categories($argsCate);
                        ?>
                    <div class='col-md-9'>
                        <select id="cate" name="cate" class="selectmenu" style="width: 180px">
                            <?php foreach ($categories as $cate) { ?>
                            <option value="<?php echo $cate->term_id ?>" <?php
                                                                                    if ($txt_cate == $cate->term_id) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>><?php echo $cate->name ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class='col-md-3'><label for="txt_title"
                            class="label-title"><?php echo _e('Title', 'suite') ?></label></br></div>
                    <div class='col-md-9'><input type="text" id="txt_title" name="txt_title" class="form-control"
                            value="<?php echo $txt_title ?>" /></div>
                    <div class='col-md-12 error-text'> <label><?php echo $err_new_title ?></label></div>
                </div>

                <div class="row">
                    <div class='col-md-3'><label class="label-title"><?php echo _e('Content', 'suite') ?></label></div>
                    <div class='col-md-9'><label style='color:red'> <?php echo $err_new_content; ?></label></div>
                    <!--  phan su dung ckeditor chua duoc      -->
                    <div class='col-md-12'>
                        <textarea id="editor" name="editor" required style="min-height: 300px">
                                <?php echo $txt_content ?>
                            </textarea>
                        <script>
                        var editor = CKEDITOR.replace('editor', {
                            customConfig: 'custom-config.js'
                        });
                        CKFinder.setupCKEditor(editor, '<?php echo  PART_CLASS . 'ckfinder' ?>');
                        </script>
                    </div>
                </div>
                <div style=" margin-top: 15px;  text-align: center">
                    <input id="btn-submit" type="submit" class="btn btn-primary" value="<?php _e('新增', 'suite'); ?>" />
                    <input id="btn_reset_new" type="reset" class="btn btn-primary"
                        value="<?php _e('Cancel', 'suite'); ?>"
                        onclick="javascript:window.location = '<?php echo home_url('/article/') ?>';" />
                </div>
            </div>
        </form>
        <?php
        } else {
            $id = (int) $_GET['id'];
            $arrArgs = array(
                'post_type' => 'forum',
                'post__in' => array($id),
            );
            $objArticle = current(get_posts($arrArgs));


            $ArticleCate = get_the_terms($objArticle->ID, 'forum_category'); // lay taxonomy cua 1 post
            $cateID = $ArticleCate[0]->term_id; // lay 1 doi tuong trong 1 array;
            $updateTitle = get_the_title($objArticle->ID);
            //  if(!isset($_POST['update_editor'])){
            $updateContent = get_post_field('post_content', $objArticle->ID)
        ?>
        <form id="f_update_article" method="post" action="<?php $_SERVER["REQUEST_URI"] ?>">
            <!-- giu link hien tai -->
            <div>
                <!-- phan lay category  -->
                <div class="content" style="display: none">
                    <?php echo $errUpdate; ?>
                    <label class="label-title"><?php echo _e('category', 'suite') ?></label><br>
                    <?php
                        $argsCate2 = array(
                            'type' => 'forum',
                            'orderby' => 'meta_value',
                            'order' => 'ASC',
                            'taxonomy' => 'forum_category',
                            'hide_empty' => 0,
                            'parent' => 0,
                        );
                        $categories2 = get_categories($argsCate2);
                        ?>
                    <select id="update_cate" name="update_cate" class="selectmenu" style="width:150px">
                        <?php foreach ($categories2 as $cate2) { ?>
                        <option value="<?php echo $cate2->term_id ?>" <?php
                                                                                if ($cateID == $cate2->term_id) {
                                                                                    echo 'selected';
                                                                                }
                                                                                ?>><?php echo $cate2->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="content">
                    <label class="label-title"><?php echo _e('title', 'suite') ?></label><br>
                    <input type="hidden" id="update_id" name="update_id" value="<?php echo $objArticle->ID ?>" />
                    <input type="text" id="update_title" name="update_title" class="form-control"
                        value="<?php echo $updateTitle; ?>" />
                    <label class="mess"><?php echo $err_update_title ?></label>
                </div>
                <div class="content">
                    <label class="label-title">content</label>
                    <label class="mess"> <?php echo $err_update_content ?></label>
                    <?php // wp_editor($p_description_vi, 'editor1', $editor_settings);                 
                        ?>
                    <!--  phan su dung ckeditor chua duoc      -->

                    <textarea id="update_editor" name="update_editor">
                            <?php echo $updateContent ?> 
                        </textarea>
                    <script>
                    var editor = CKEDITOR.replace('update_editor', {
                        customConfig: 'custom-config.js'
                    });
                    CKFinder.setupCKEditor(editor, '<?php echo  PART_CLASS . 'ckfinder/' ?>');
                    </script>
                </div>
                <div style="text-align: center; margin-top: 20px">
                    <input id="btn-update" class="btn btn-primary" type="submit"
                        value="<?php _e('Update', 'suite'); ?>" />
                    <input id="btn_reset" class="btn btn-primary" type="reset" value="<?php _e('Cancel', 'suite'); ?>"
                        onclick="javascript:window.location = '<?php echo home_url('/article/') ?>';" />
                </div>
            </div>
        </form>
        <?php } ?>

        <hr>



        <?php
        $arrpost = array(
            'post_type' => 'forum',
            'author' => $objMember->ID,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'f_active',
                    'value' => 'on',
                )
            )
        );
        $myQuery = new WP_Query($arrpost);
        if ($myQuery->have_posts()) :
        ?>
        <!-- phan post bai cua member -->
        <div class="list-item">
            <?php
                while ($myQuery->have_posts()) :
                    $myQuery->the_post();
                ?>
            <div class="row-item row">
                <span class="col-8">
                    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    <label style="font-size: 8px; color: #666666"> <?php _e('發表日期 ', 'suite'); ?> :
                        <?php echo $post->post_date ?></label>
                </span>
                <span class="col-4" style=" float: right">
                    <a class="edit-item"
                        href="<?php echo esc_attr(add_query_arg(array('id' => $post->ID), home_url('article'))); ?>">
                        <?php _e('Edit', 'suite'); ?> </a> |
                    <a href="#" class="del" data-id="del-<?php echo $post->ID ?>"
                        data-href="<?php echo esc_attr(add_query_arg(array('del' => $post->ID), home_url('article'))) ?>"
                        data-title=" <?php echo get_the_title($post->ID); ?>" data-toggle="modal"
                        data-target="#confirm-delete"><?php _e('Delete', 'suite'); ?> </a>
                </span>
            </div>
            <?php endwhile; ?>
        </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
        <!-------------add new article----------------------------------------------->
        <hr>

    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
    <!--// POPUP CO PHAI MUON XOA DU LIEU-->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php _e('刪除資料', 'suite'); ?></h4>
                    <div class="clear"></div>
                </div>

                <div class="modal-body">
                    <p> <?php _e('您是否要刪除這行資料', 'suite'); ?></p>
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal"><?php _e('Cancel', 'suite'); ?></a>
                    <a class="btn  btn-ok"><?php _e('Delete', 'suite'); ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php
    // PHAN LAY PARAM CUA URL CHUYEN CHO JAVASCRIPT DE TAO HIEU UNG SCROLL
    if (isset($_GET['id'])) {
        $getid = $_GET['id'];
    } else {
        $getid = 001;
    }
    ?>
    <script>
    jQuery(document).ready(function() {

        // CONG ITEM
        jQuery('#confirm-delete').on('show.bs.modal', function(e) {
            jQuery(this).find('.btn-ok').attr('href', jQuery(e.relatedTarget).data('href'));
            //        $('.debug-url').html(' <strong>' + $(this).find('.btn-ok').attr('data-title') + '</strong>');
        });

        // LAY GIA TRI ID TAO HIEU UNG CUON
        //            if (id !== '' && id !== 1) {
        //                jQuery('body,html').stop(false, false).animate({
        //                    scrollTop: 1000
        //                }, 1000);
        //            };
    });
    </script>
</div>
<div style="height: 40px;"></div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by