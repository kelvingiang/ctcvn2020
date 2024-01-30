<?php
/*
  Template Name: Download Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by
get_header();
?>
<style>
.download-space {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.download-item {
    border: 1px #f2efef solid;
    border-radius: 1rem;
    margin: 1rem;
    width: 23%;
    text-align: center;
    opacity: 0.8;
    transition: all 1s;

}

.download-item:hover {
    opacity: 1;
    box-shadow: 1px 10px 8px #888888;
    transform: scale(1.05);
}

.download-item img {
    width: 90%;
    margin: 0.5rem;
}

.download-item label {
    font-size: 1.8rem;
    margin: 0.5rem;
}
</style>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> <?php _e('總會會刊') ?> </h2>
            </div>
        </div>
        <div>
            <img src="<?php echo PART_IMAGES . 'download-panner.jpg' ?>" style=" width: 99%;" />
        </div>

        <?php
        $table = $wpdb->prefix . 'download';
        $sql = "SELECT * FROM $table WHERE kind = 1";
        $downloadList = $wpdb->get_results($sql, ARRAY_A);
        ?>
        <div class="download-space">
            <?php
            foreach ($downloadList as $val) {
            ?>
            <div class="download-item">
                <a style=" display: block; text-decoration: none" target="_blank"
                    href="<?php echo PART_FILE . $val['file'] ?>">
                    <div>
                        <img src="<?php echo PART_IMAGES . 'download/' . $val['img'] ?>" />
                        <label><?php echo $val['title'] ?></label>
                    </div>
                </a>
            </div>
            <?php
            }
            ?>
        </div>

    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information ??headers already sent by