<?php
/*
  Template Name: Post  Recruit  Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();

//==================================================================
?>

<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <!-- //================================================ -->
        <div>
            
            <?php
     
            if ($_GET['dt'] === '3' || !isset($_GET['dt']) || $_GET['dt'] !== '4') {
                get_template_part('templates/template', 'ungtuyen');
            } elseif ($_GET['dt'] === '4') {
                get_template_part('templates/template', 'dangtuyen');
            }
            ?>

        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
<?php get_sidebar() ?>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php _e('刪除資料', 'suite'); ?></h4>
                    <div class="clear"></div>
                </div>

                <div class="modal-body">
                    <p>  <?php _e('您是否要刪除這行資料', 'suite'); ?></p>
                    <p class="debug-url"></p>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-primary" data-dismiss="modal"><?php _e('Cancel', 'suite'); ?></a>
                    <a class="btn  btn-ok"><?php _e('Delete', 'suite'); ?></a>
                </div>
            </div>
        </div>
    </div>




    <script>
        jQuery(document).ready(function () {
            jQuery('#confirm-delete').on('show.bs.modal', function (e) {
                jQuery(this).find('.btn-ok').attr('href', jQuery(e.relatedTarget).data('href'));
            });
        });
    </script>

</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by

