<?php
/*
  Template Name: New Finance Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
$caterogy = 'vn-finance';
$post_count = 5;
$_SESSION['caterogy'] = $caterogy;
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('越南財經', 'suite'); ?> </h2>
            </div>
        </div>
        <?php Post_list_style($caterogy, $post_count) ?>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        jQuery('#load-more').click(function () {
            var lastID = jQuery("#data-list > li:last-child").attr("data-id");
            var caterogy = '<?php echo $caterogy ?>';
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
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
