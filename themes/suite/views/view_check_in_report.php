<?php
require_once DIR_CODES . 'my-list.php';
$myList = new Codes_My_List();

require_once(DIR_MODEL . 'model_check_in_report.php');
$model = new Admin_Model_Check_In_Report();
//$list = $model->ReportView();
$registerTotal = $model->RegisterTotal();
$listGuests = $model->ReportjoinView();
//$listMember = $model->ReportjoinViewMember();
//$list = array_merge($listGuests,$listMember);

$page = getParams('page');
$branch = $model->ReportBranchView();

//sap xep thu tu mang trong mang
uasort($branch, 'sort_by_order');
function sort_by_order($a, $b)
{
    //            return $a['percent'] - $b['percent'];
    return $b['percent'] - $a['percent'];
}
?>
<div class="report_head" style="height: 60px; margin-top: 20px">
    <a style=' margin-top: 2px; margin-right: 20px; letter-spacing: 4px ' class="button button-primary button-large" href="<?php echo home_url('print-check-in'); ?>" target="_blank"> <?php _e('Print Report'); ?></a>

    <a style=' margin-top: 2px; margin-right: 40px; letter-spacing: 4px ' class="button button-primary button-large" href="<?php echo "admin.php?page=$page&action=waiting" ?>"><?php _e('Title & Check in Time') ?></a>
</div>

<div>
    <h2><?php echo __('Total of registrations') . ' : ' . $registerTotal['COUNT(ID)']; ?></h2>
    <h2><?php echo __('Total attendance') . ' : ' . count($listGuests); ?></h2>
    <table id="bao_cao">
        <tr style=" background-color: #2B95FD; text-align: center; ">
            <td style="width: 100px">
                <h3 style="color: white"> <?php _e('Branch') ?></h3>
            </td>
            <td style="width: 100px">
                <h3 style="color: white"> <?php _e('Registration') ?></h3>
            </td>
            <td style="width: 100px">
                <h3 style="color: white"><?php _e('Attend') ?></h3>
            </td>
            <td style="width: 100px">
                <h3 style="color: white"> <?php _e('Ratio') ?></h3>
            </td>
        </tr>

        <?php foreach ($branch as $key => $val) {
        ?>
            <tr>
                <td> <label><?php echo $val['code']; ?></label></td>
                <td> <label><?php echo $val['register']; ?></label></td>
                <td> <label><?php echo $val['arrived']; ?></label></td>
                <td> <label><?php echo $val['percent']; ?> %</label></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
<div class="report_content">
    <div>
        <table cellpadding="0" Cellspacing='0' style='width: 98%; margin-top: 20px; border-left: 1px solid #000; border-right:  1px solid #000 '>
            <tr style=' background-color: #2b95fd; color: white; height: 50px; font-size: 18px'>
                <th style=" border-right:  1px white solid; width: 20px"></th>
                <th style=' border-right:  1px white solid; width: 100px'><?php _e('Full Name'); ?></th>
                <th style=' border-right: 1px white solid; width: 80px'><?php _e('Branch') ?></th>
                <th style=' border-right: 1px white solid;width: 100px'><?php _e('Positions'); ?></th>
                <th style=' border-right: 1px white solid; width: 150px'><?php _e('Check-In') ?></th>
                <!--<th style=' border-right: 1px white solid'><?php //_e('Career') 
                                                                ?></th>-->
                <th style=' border-right: 1px white solid; width: 100px'><?php _e('Phone') ?></th>
                <th style=" width: 200px"><?php _e('E-mail') ?></th>
            </tr>
            <?php foreach ($listGuests as $key => $val) { ?>
                <tr class="report" style="border-bottom:1px white solid; ">
                    <td style=" text-align: center"> <?php echo $key + 1 ?></td>
                    <td> <?php echo $val['full_name'] ?></td>
                    <td> <?php
                            echo $myList->get_country($val['country'])
                            ?>
                    </td>
                    <td> <?php echo $val['position'] ?></td>
                    <td>
                        <?php
                        echo $val['time'] . ' -- ' . $val['date'];
                        //                        $listDetail = $model->ReportDetailView($val['ID']);
                        //                        foreach ($listDetail as $item) {
                        //                            echo '<lable>' . $item['time'] . ' __ ' . $item['date'] . '</lable><br>';
                        //                        }
                        ?>
                    </td>
                    <td> <?php echo $val['phone'] ?></td>
                    <td> <?php echo $val['email'] ?></td>
                </tr>
            <?php } ?>

        </table>
    </div>
</div>
<style>
    #bao_cao tr {
        height: 30px;
        border-bottom: #cccccc solid 2px;
    }

    #bao_cao tr:nth-child(even) {
        background-color: #DEE1E5;
    }

    #bao_cao td {
        padding-left: 5px
    }
</style>