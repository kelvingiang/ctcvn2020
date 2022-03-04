<div id="language-space">
    <div class='language-item' data-id='cn'>中文</div>
    <div class='language-item' data-id='en'>English</div>
    <div class='language-item' data-id='vn'>Việt Nam</div>
    <div> <?php echo $_SESSION['languages']; ?></div>
    <div> <?php echo __('language'); ?></div>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery('.language-item').on("click", function() {
            var language = jQuery(this).attr("data-id");

            jQuery.ajax({
                url: '<?php echo get_template_directory_uri() . '/ajax/change_languages.php' ?>',
                dataType: 'json',
                type: 'post',
                data: {
                    type: language
                },
                success: function(res) {
                    if (res.status === 'ok') {
                        //window.location = location.href;
                        //location.reload();
                        // window.location = 'http://localhost/digiwin';
                        window.location = '<?php echo get_option('home') ?>';
                    }
                }
            });
        });
    })
</script>