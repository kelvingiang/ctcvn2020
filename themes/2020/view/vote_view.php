<?php
//
require_once(MODEL_DIR . 'vote_model.php');
$showlist = new Admin_Vote_Model();
$showlist->prepare_items();
$lbl = '';
$page = getParams('page');
$linkAdd = admin_url('admin.php?page=' . $page . '&action=add');  // TAO LINH CHO ADD NEW
$lblAdd = '新增名單';
if (getParams('msg') == 1) {
    $msg .= '<div class="updated notice notice-success is-dismissible"><p> 資料調整成功 </p></div>';
}
?>
<style type="text/css">
    .column-title {
        width: 300px;
    }

    .column-postition{
        width: 30px
    }
    
    .column-kid{
    width: 80px
}
</style>
<div class="wrap">
    <h2 style="font-weight: bold">
        <?php echo esc_html__($lbl); ?>
        <a href ="<?php echo esc_url($linkAdd); ?>"  class ="add-new-h2"><?php echo esc_html__($lblAdd); ?></a>
    </h2>
    <?php echo @$msg; ?>
    <form action ="" method="post" name="<?php echo $page; ?>" id="<?php echo $page; ?>">
        <?php $showlist->search_box('search', 'search_id') ?>
        <?php $showlist->views(); ?>
        <?php $showlist->display(); ?>
    </form>
</div>