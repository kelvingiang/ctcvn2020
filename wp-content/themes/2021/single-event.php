<?php
global $post;
// lay phan header
get_header();
wp_link_pages();
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12 ">
        <div class="orange-group" style="margin-top: 1rem">
            <div class="orange-title">
                <label class="orange-title-text"><?php the_title(); ?></label>
            </div>
            <div  class="info-bg">
                <div>
                    <label>
                        <?php
                        if (get_post_meta($post->ID, 'e_end_date', TRUE) !== '')
                            $endDate = get_post_meta($post->ID, 'e_end_date', TRUE) . '&nbsp;--';
                        else
                            $endDate = '';

                        if (get_post_meta($post->ID, 'e_end_time', true) !== '')
                            $endTime = ' &nbsp;' . get_post_meta($post->ID, 'e_end_time', true);
                        else
                            $endTime = ''
                            ?>
                        <?php _e('開始日期 ') ?> </br>
                        <?php _e('從') ?>  <?php echo get_post_meta($post->ID, 'e_start_date', TRUE); ?>
                        &nbsp;--&nbsp;<?php echo get_post_meta($post->ID, 'e_start_time', TRUE); ?>
                        <?php _e('至') ?>
                        <?php echo $endDate; ?> 
                        <?php echo $endTime ?> 

                    </label>
                </div>

                <div><?php echo $post->post_content // NOI DUNG     ?></div>      
            </div>
            <hr>
            <?php if (get_post_meta($post->ID, 'e_join', true) == 'on') { ?>
                <?php if (!$_SESSION['login']) { ?>
                    <h3 style="color: blue"> <?php _e('會員登入後才可以填寫報名表', 'suite'); ?> </h3>            
                <?php } else { ?>      
                    <div id="join">
                        <hr>
                        <?php get_template_part('template', 'join'); ?>
                    </div> 
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar('event') ?>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function () {
        $('.item .delete').click(function () {
            var elem = $(this).closest('.item');
            $.confirm({
                'title': 'Delete Confirmation',
                'message': 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
                'buttons': {
                    'Yes': {
                        'class': 'blue',
                        'action': function () {
                            elem.slideUp();
                        }
                    },
                    'No': {
                        'class': 'gray',
                        'action': function () {
                        }	// Nothing to do in this case. You can as well omit the action property.
                    }
                }
            });
        });
    });
</script>
<?php
// lay phan footer
get_footer();
?>
