<?php $page = getParams('page'); ?>
<div class="report_head" style="height: 60px">
    <ul style="margin:  15px 0">
        <li>
            <a style=' margin-top: 2px; margin-right: 40px; letter-spacing: 4px '
                class="button button-primary button-large"
                href="<?php echo "admin.php?page=$page&action=export_checkin" ?>"> 導出 Check in</a>
        </li>
        <li>
            <a style=' margin-right: 20px; letter-spacing: 4px ' class="button button-primary button-large"
                href="<?php echo "admin.php?page=$page&action=export_guests" ?>"> 導出 Guests</a>
        </li>
        <li>
            <a style=' margin-right: 20px; letter-spacing: 4px ' class="button button-primary button-large"
                href="<?php echo "admin.php?page=$page&action=export_member_post" ?>"> 導出 Member (post)</a>
        </li>
        <!--        <li>
            <a style=' margin-right: 20px; letter-spacing: 4px ' 
               class="button button-primary button-large" 
               href="<?php //echo "admin.php?page=$page&action=export_member_table" 
                        ?>"> 導出 Member (table)</a>
        </li>-->
    </ul>
    <hr />
    <ul>
        <li>
            <a style="background-color: green; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold "
                class="button button-large" href="<?php echo "admin.php?page=$page&action=import_guests" ?>"> 導入
                Guests</a>
        </li>
        <!--        <li>
            <a style="background-color: green; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold "
               class="button button-large" 
               href="<?php //echo "admin.php?page=$page&action=import_member" 
                        ?>"> 導入 Member</a>
        </li>-->
    </ul>
    <hr />
    <ul>
        <li>
            <a class="button button-large" onclick="myFunction()"
                style="background-color: red; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold ">刪除所有報到記錄</a>
        </li>
        <li>
            <a style='background-color: red; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold '
                class="button  button-large" href="<?php echo "admin.php?page=$page&action=create_qrcode" ?>">
                批次產生QRCode檔</a>
        </li>
        <li><a style='background-color: red; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold '
                class="button  button-large" href="<?php echo "admin.php?page=$page&action=create_qrcode_name" ?>">
                產生QRCode含姓名(記得檢查姓名)</a>
        </li>
        <li><a style='background-color: red; color: white; border-radius: 5px; letter-spacing: 2px;  font-weight: bold '
                class="button  button-large" href="<?php echo "admin.php?page=$page&action=create_qrcode_register" ?>">
                產生出席QRCode含姓名(記得檢查姓名)</a>
        </li>
    </ul>
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
<script type="text/javascript">
function myFunction() {
    if (confirm("您確定刪除所有報到記錄")) {
        location.href = "<?php echo "admin.php?page=$page&action=reset_checkin" ?>";
    } else {
        window.stop();
    }
}
</script>