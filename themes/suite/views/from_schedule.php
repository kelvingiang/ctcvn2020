<?php
$page = getParams('page');
$action = (getParams('action') != ' ') ? getParams('action') : 'add';
$msg = '';
//---------------------------------------------------------------------------------------------
// Cmt KIEM TRA NEU CO LOI THI DUA LOI VAO BIEN  $msg VAO SHOW $msg 
//---------------------------------------------------------------------------------------------
if (count($error) > 0) {
    $msg .= '<div class="error"><ul>';
    foreach ($error as $key => $value) {
        $msg .= '<li>' . $value . '</li>';
    }
    $msg .= '</ul></div>';
}
//---------------------------------------------------------------------------------------------
// Cmt PHAN GIU LAI GIA TRI DA NHAP CHO CAC FIELD DUNG
//---------------------------------------------------------------------------------------------
// NHAM BAO MAT NEN TA THEM CAC HAM TRUOC CAC GIA TRI CHUYEN QUA
$vTitle = sanitize_text_field($data['title']);
$vSlug = sanitize_text_field($data['slug']);
$vDate = sanitize_text_field($data['date']);
$vWeekdays = sanitize_text_field($data['weekdays']);
if ($data['time']) {
    $time = explode('-', $data['time']);
    $vTimeStart = sanitize_text_field($time[0]);
    $vTimeEnd = sanitize_text_field($time[1]);
} else {
    $vTimeStart = sanitize_text_field($data['timeStart']);
    $vTimeEnd = sanitize_text_field($data['timeEnd']);
}
$vPlace = sanitize_text_field($data['place']);
$vNote = sanitize_text_field($data['note']);
$vBranch = sanitize_text_field($data['branch']);

//echo '<pre>';
//  print_r($data);
//  echo '</pre>';

if (!empty($data))
    $vStatus  = $data['status'];
else
    $vStatus  = 1;

//---------------------------------------------------------------------------------------------
// Cmt TAO CAC FIELD NHAP LIEU
//---------------------------------------------------------------------------------------------
$objHtml = new MyHtml();
$txtTitle = $objHtml->textbox('title', @$vTitle, array('class' => 'regular-text'));
$txtSlug = $objHtml->textbox('slug', @$vSlug, array('class' => 'regular-text'));
$txtDate = $objHtml->textbox('date', @$vDate, array('width' => '200px', 'placeholder' => 'yyyy/mm/dd', 'id' => 'datepicker'));
$txtWeekDay = $objHtml->textbox('weekdays', @$vWeekdays, array('width' => '200px', 'id' => 'dayOfWeek'));
$txtTimeStart = $objHtml->textbox('timeStart', @$vTimeStart, array('width' => '100px', 'class' => 'type-time', 'maxlength' => '5', 'placeholder' => '00:00 ', 'id' => 'timeStart'));
$txtTimeEnd = $objHtml->textbox('timeEnd', @$vTimeEnd, array('width' => '100px', 'class' => 'type-time', 'maxlength' => '5', 'placeholder' => '00:00 ', 'id' => 'timeEnd'));
$txtPlace = $objHtml->textbox('place', @$vPlace, array('class' => 'regular-text', 'id' => 'place'));
$areaNote = $objHtml->textarea('note', @$vNote, array('class' => 'regular-text', 'rows' => '8', 'cols' => '45', 'id' => 'note'));
$chkStatus = $objHtml->checkbox('status', '1', array('id' => 'status'), array('current_value' => $vStatus));

// LAY CAC CHI NHANH TU DATABSE DUA VO SELECT BOX branch
$args = array(
    'post_type' => 'brach',
    'post_status' => 'publish',
    'showposts' => -1
);
$my_query = new WP_Query($args);
$arrBranch = array();
$arrBranch[0] = __('Choose a Branch');
if ($my_query->have_posts()) {
    while ($my_query->have_posts()) : $my_query->the_post();
        $arrBranch[get_the_title()] = get_the_title();
    endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post()

$arr = array('id' => 'branch');
$options['data'] = $arrBranch;
$selBranch = $objHtml->selectbox('branch', @$vBranch, $arr, $options);
?>
<!--DOAN SCRIPT HIEN THI NGAY VA THU TRONG TUAN-->
<script type="text/javascript">
    jQuery(function() {
        // $('#dayOfWeek').attr('readonly', true);

        jQuery('#datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            showAnim: 'show',
            onSelect: function(dateText) {
                var seldate = jQuery(this).datepicker('getDate');
                seldate = seldate.toDateString();
                seldate = seldate.split(' ');
                var weekday = new Array();
                weekday['Mon'] = "星期一";
                weekday['Tue'] = "星期二";
                weekday['Wed'] = "星期三";
                weekday['Thu'] = "星期四";
                weekday['Fri'] = "星期五";
                weekday['Sat'] = "星期六";
                weekday['Sun'] = "星期天";
                var dayOfWeek = weekday[seldate[0]];
                jQuery('#dayOfWeek').val(dayOfWeek); //.attr('readonly', true)
            },
            onClose: closeDatePicker_datepicker_1
        });
    });

    function closeDatePicker_datepicker_1() {
        var tElm = jQuery('#datepicker');
        if (typeof datepicker_1_Spry != null && typeof datepicker_1_Spry != "undefined" && test_Spry.validate) {
            datepicker_1_Spry.validate();
        }
        tElm.blur();
    }
</script>

<div class=" wrap">
    <h2><?php echo $lbl ?></h2>
    <?php echo $msg ?>
    <form action="" method="post" enctype="multipart/form-data" id="<?php $page ?>" name="<?php $page ?>">
        <input name="action" value="<?php echo $action; ?>" type="hidden">
        <?php wp_nonce_field($action, 'security_code', true); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo __('Enable') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $chkStatus; ?>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo __('Title') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $txtTitle; ?>
                    </td>
                </tr>
            </tbody>

            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo __('Date') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $txtDate ?>
                        <?php echo $txtWeekDay ?>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo __('Time') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $txtTimeStart . __('To') . $txtTimeEnd ?>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo translate('Branch') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $selBranch ?>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo translate('Place') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $txtPlace ?>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php echo translate('Note') . ':'; ?></label>
                    </th>
                    <td>
                        <?php echo $areaNote ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input name="submit" id="submit" class="button button-primary" value="<?php _e('Submit') ?>" type="submit">
        </p>
    </form>

</div>