<?php
if (!empty(getParams('id'))) {
    require_once MODEL_DIR . 'download_model.php';
    $model = new Admin_Download_Model();
    $item = $model->get_item(getParams('id'));
}
$page = getParams('page');
?>
<div class=" wrap">
    <h2><?php echo $lbl ?></h2>
    <?php echo $msg ?>
    <form action="" method="post" enctype="multipart/form-data" id="<?php $page ?>" name="<?php $page ?>" >
        <input type="hidden" name="hid_ID" id="hid_ID" value="<?php echo $item['ID']; ?>" >
        <input type="hidden" name="hid_file" id="hid_file" value="<?php echo $item['file']; ?>" >
        <input type="hidden" name="hid_img" id="hid_img" value="<?php echo $item['img']; ?>" >
        <?php wp_nonce_field($action, 'security_code', true); ?>
        <table class="form-table" style=" width: 100%">
            <tbody>
                <tr>
                    <th scope="row">
                        <label>標題</label>
                    </th>
                    <td >
                        <input type="text" id="txt_title" name="txt_title" value="<?php echo $item['title'] ?>" style=" width: 80%"  />
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label>類型</label>
                    </th>
                    <td>
                        <select id="sel_kind" name="sel_kind" >
                            <?php
                            require_once CODES_DIR . 'my_list.php';
                            $myList = new my_list();
                            foreach ($myList->DownloadList() as $key => $val) {
                                ?>
                                <option <?php echo $item['kind'] == $key ? 'selected' : '' ?>  value= "<?php echo $key ?>"><?php echo $val ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr style="border-bottom: 1px solid #000; border-top:  1px solid #000">
                    <th scope="row">
                        <label>照片</label>
                    </th>
                    <td>
                        <div id="show-img" 
                             style=" background-image: url('<?php echo WB_URL_IMAGES . '/download/' . $item['img']; ?>');">
                        </div>  
                        <input type="file" id="img_upload" name="img_upload" />
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th scope="row">
                        <label>檔案</label>
                    </th>
                    <td>
                        <h2> <?php echo $item['file'] ?> </h2>
                        <input type="file" id="file_upload" name="file_upload" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input name="submit" id="submit" class="button button-primary" value="發 表" type="submit">
        </p>
    </form>

</div>

<script type="text/javascript">
    // show hinh anh truoc khi up len
    jQuery(function () {
        jQuery("#img_upload").on("change", function ()
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