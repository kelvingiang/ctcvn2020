<?php
if (!empty($_POST)) {
  update_post_meta(1, '_about_chamber', $_POST['txt_about']);
  update_post_meta(1, '_charter_chamber', $_POST['txt_charter']);
}
?>
<div style="width: 80%">
    <form id="f-about" name="f-about" method="post" action="">
        <div><h2>商會簡介  </h2></div>
        <div style="min-height: 400px; overflow:  hidden" >
            <?php wp_editor(get_post_meta('1', '_about_chamber', true), 'txt_about', array('wpautop' => TRUE, 'editor_height' => '350px')); ?>
        </div>
        <hr>
        <div><h2>商會章程 </h2></div>
        <div style="min-height: 400px; overflow:  hidden" >
            <?php wp_editor(get_post_meta('1', '_charter_chamber', true), 'txt_charter', array('wpautop' => TRUE, 'editor_height' => '350px')); ?>
        </div>
        <div style="margin: 20px">
            <input class="button button-primary"  type="submit" value="發 佈"/>  
        </div>
    </form>
</div>
