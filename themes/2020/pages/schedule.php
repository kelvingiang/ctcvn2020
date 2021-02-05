<?php
/*
  Template Name:  Schedule  Page
 */
?>
<?php
ob_start();  // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
get_header();
global $wpdb;
?>
<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 col-12">
        <?php
// PHAN get_resuls GET DATA FROM MY CREATE TABEL
        $table = $wpdb->prefix . 'schedule';
        $query = "SELECT * FROM {$table} WHERE status = 1  ORDER BY year  DESC, month  DESC, day  DESC";
        $reback = $wpdb->get_results($query, ARRAY_A);
        ?>
        <div class='head-title'>
            <div class="title">
                <h2 class="head"> 行事曆  </h2>
            </div>
        </div>
        <?php
        $tmp = array();

        foreach ($reback as $arg) {
            $tmp[$arg['month'] . ' / ' . $arg['year']][] = $arg['id'];
        }
        $output = array();
        foreach ($tmp as $type => $labels) {
            $output[] = array(
                'month' => $type,
                'id' => $labels
            );
        }
        $ids = array();
        foreach ($output as $value) {
            $ids = $value['id'];
            ?>
            <div class="schedule_month"><?php echo $value['month'] ?></div>
            <?php
            foreach ($ids as $id) {
                foreach ($reback as $item) {
                    if (in_array($id, $item)) {
                        ?>
                        <div class ="row schedule_item">
                            <?php ?>
                            <div class=" col-md-12">
                                <label class="label-title "><?php echo $item['title']; ?></label>
                            </div> 
                            <div class="col-md-12 schedule_text">
                                <label>日期:</label> <?php echo $item['date'] . '-' . $item['weekdays']; ?>
                                <label> - - 時間:</label> <?php echo $item['time']; ?>
                            </div>
                            <div class="schedule_hide">
                                <div class="col-md-12">
                                    <label>地點:</label> <?php echo $item['place']; ?></br>
                                    <label>分會:</label> <?php echo $item['branch']; ?> 
                                </div>
                                <div class="col-md-12">
                                    <label>備註:</label> <?php echo $item['note']; ?>  
                                </div> 
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            $ids = null;
        }
        ?>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
        <?php get_sidebar() ?>
    </div>
</div>
<?php
get_footer();
ob_flush();   // neu bao loi PHP Warning: Cannot modify header information – headers already sent by
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.schedule_item').click(function () {
            jQuery('.schedule_hide').stop(true, false).slideUp('100');
             jQuery('.schedule_item').css("background-color" ,"#fff");
            jQuery(this).children('.schedule_hide').stop(true, false).slideDown('slow');
            jQuery(this).css("background-color" ,"#ccc");
        });
    });
</script>

