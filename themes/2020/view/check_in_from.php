<?php
if (!empty(getParams('id'))) {
    require_once (MODEL_DIR . 'check_in_model.php');
    $model = new Admin_Check_In_Model();
    $data = $model->get_item(getParams());
}
?>

<?php
require_once (MODEL_DIR . 'check_in_model.php');
$model = new Admin_Check_In_Model();
$dd = $model->saveItem();
if (!empty($dd)) {
    ?>
    <div style=" background-color: #FFADAD; color: white; min-height: 150px; margin-left: -20px; margin-bottom: 50px; padding-left: 20px">
        <?php
        foreach ($dd as $val) {
            echo $val;
        }
        ?>
    </div>
<?php } ?>
<form action="" method="post" enctype="multipart/form-data" id="f-guests" name="f-guests" >
    <div class="row-one-clo" style=" margin-top: 3rem ">
        <div class="cell-one "><label class="label-admin" > <?php _e('Picture') ?> </label></div>    
        <div class="cell-two">
            <?php
            if (empty($data['img'])) {
                $guest_img = 'no-image.jpg';
            } else {
                $guest_img = $data['img'];
            }
      
            ?>

            <div id="show-img" style=" background-image: url('<?php echo WB_URL_IMAGES_GUESTS . $guest_img; ?>');"></div>  

            <input type="file" id="guests_img" name="guests_img" accept=".png, .jpg, .jpeg, .bmp"/>

            <input type='hidden' id='hidden_barcode' name='hidden_barcode' value='<?php echo $data['barcode']; ?>'/>
            <input type='hidden' id='hidden_ID' name='hidden_ID' value='<?php echo $data['ID']; ?>'/>
            <input type='hidden' id='hidden_img' name='hidden_img' value='<?php echo $data['img']; ?>'/>
            <input type='hidden' id='hidden_country' name='hidden_country' value='<?php echo $data['country']; ?>'/>
            <input type='hidden' id='hidden_fullname' name='hidden_fullname' value='<?php echo $data['full_name']; ?>'/>
            <input type='hidden' id='hidden_appcode' name='hidden_appcode' value='<?php echo $data['app_code']; ?>'/>
        </div>
    </div>

    <?php if (getParams('action') != 'add') { ?>
        <div class="row-one-clo" style=" height: 50px">
            <div class="cell-one "><label class="label-admin"> <?php _e('Barcode') ?> </label></div>    
            <div class="cell-two">
                <?php $barcodeImgName = $data['full_name'] . '-' . $data['barcode']; ?>
                <div style=" float: left; margin-right: 20px">
                    <img id="img_barcode" name="img_barcode" src='<?php echo get_qrcode_img($data['barcode']); ?>' style="width: 50px" >
                </div>
                <div>
                    <label> <?php echo $data['barcode']; ?></label> <br>
                    <a href="<?php echo get_qrcode_img($data['barcode']) ?>" 
                       download="<?php echo $barcodeImgName . '.png' ?>"
                       style="font-weight:  bold; text-decoration: none; color: blue"    
                       >
                        Download QRCode Image
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('App Code') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_appcode" name="txt_appcode" <?php echo get_current_user_id() == 1 ? '' : 'readonly' ?> value ="<?php echo $data['app_code'] ?>" /></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('Full Name') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_fullname" name="txt_fullname"   required value ="<?php echo $data['full_name'] ?>" /></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"><?php
                _e('Brach');
                echo $data['country'];
                ?> </label></div>    
        <div class="cell-two">
            <select  id="sel_Country" name="sel_country" >
                <?php
                require_once CODES_DIR . 'my_list.php';
                $myList = new my_list();
                foreach ($myList->countryList() as $key => $val) {
                    ?>
                    <option value='<?php echo $key ?>' <?php echo $data['country'] == $key ? 'selected' : '' ?>  > <?php echo $val ?> </option>
                <?php } ?>
            </select></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('Asia Position') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_position" name="txt_position" value='<?php echo $data['position'] ?>' /></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('Email') ?> </label></div>    
        <div class="cell-two">
            <input type="text" id="txt_email" name="txt_email" class='email' value='<?php echo $data['email'] ?>' />
            <label style=' font-weight: bold; color: red;padding-left: 10px' id='error-email'></label>
        </div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('Phone') ?> </label></div>    
        <div class="cell-two"><input type="text" id="txt_phone" name="txt_phone" class='type-phone-more'  value='<?php echo $data['phone']; ?>' /></div>
    </div>

    <div class="row-one-clo">
        <div class="cell-one "><label class="label-admin"> <?php _e('Note') ?> </label></div>    
        <div class="cell-two">
            <textarea id="txt_note" name="txt_note" rows="5" style=" width: 100%" ><?php echo $data['note'] ?></textarea>
        </div>
    </div>

    <div class="row-one-clo" style="padding-top: 20px; text-align: right">
        <div class="cell-one "><label class="label-admin"></label></div>   
        <div class="cell-two">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit" style="margin-right: 50px">
        </div>
    </div>
</form>
<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function () {
        jQuery("#guests_img").on("change", function ()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    jQuery("#show-img").css("background-image", "url(" + this.result + ")");
                };
                console.log(result);
            }
        });
    });

</script>
