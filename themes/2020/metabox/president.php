<?php
class Admin_Metabox_President{
    public function __construct() {
       // echo __METHOD__;
         add_action('add_meta_boxes' , array($this,'create') );
         add_action( 'save_post' , array($this, 'save'));
    }
    
    
    public function create(){    
  //      echo __METHOD__;
        $id             = 'tw-metabox-email';
        $title          = '屆期和年度';
        $callback    = array($this, 'display');
       $screen        =array('president'); // CAC POST VA CUSTOMER POST CHO PHEP METABOX NAY HIEN THI
        add_meta_box($id, $title, $callback, $screen);
        // FUNCTION NAY DE O DAY, DE KHI NAO DUNG DE METABOX THI TA MOI GOI FILE CSS NAY VO 
    //     add_action('admin_enqueue_scripts' , array($this,'add_css_file'));
    }

    public function display($post){
    //        echo __METHOD__;
        // thanh an nham bao mat trong wp
        $action = 'tw-metabox-data';
        $name  ='tw-metabox-data-nonce';
        wp_nonce_field($action, $name);
       ?>
        <div class="row-one-clo">
          <div class="cell-one "><label class="label-admin"><?php    _e('Brach'); ?> </label></div>    
          <div class="cell-two">
          <select  id="sel_Country" name="sel_country" >
                  <?php 
                         require_once CODES_DIR .'my_list.php';
                         $myList = new my_list();
                  foreach ($myList->countryList() as $key => $val) { ?>
                      <option value='<?php echo $key ?>' <?php echo get_post_meta($post->ID, '_president_branch',true)  == $key ? 'selected' : '' ?>  > <?php echo $val ?> </option>
                 <?php } ?>
           </select></div>
      </div>
        <div class="row-one-clo">
            <div class="cell-one"><label class="admin-title">屆 期</label> </div>
            <div class="cell-two"><input type="text" id="txt_term" name="txt_term" value="<?php echo get_post_meta($post->ID, '_president_term',true) ?>" /></div>
        </div>
        <div class="row-one-clo">
            <div class="cell-one"><label class="admin-title">年 度</label> </div>
            <div class="cell-two"><input type="text" id="txt_year" name="txt_year" value="<?php  echo get_post_meta($post->ID, '_president_year',true) ?>" /></div>
        </div>
    

        <?php
    }
    
        // LUU GIA TRI VAO DATABASE
    public  function save( $post_id){
        // kiem thanh phan an bao mat cua wp
        // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id
        if(!isset($_POST['tw-metabox-data-nonce'])) return$post_id;
       // NEU HAM NAY TRA VE GIA TRI  LA TRUE THUC HIEN TIEP CAC PHAN DUOI , CON TRA VE FLASE return VE $post_id 
        if(wp_verify_nonce('tw-metabox-data-nonce','tw-metabox-data'))            return $post_id; 
        // HAM TU DONG LUU KHI DE QUA LAU NEU TRA VE FLASE return $post_id
        if(define('DOING_AUTOSAVE') && DOING_AUTOSAVE)            return $post_id;
        
        if(!current_user_can('edit_post', $post_id))            return$post_id;
       // 4 BON PHAN TREN DUNG DE BAO MAT KHI LUU METABOX TRONG WP 
       
        update_post_meta($post_id, '_president_branch', sanitize_text_field($_POST['sel_country']));
        update_post_meta($post_id, '_president_term', sanitize_text_field($_POST['txt_term']));
        update_post_meta($post_id, '_president_year', sanitize_text_field($_POST['txt_year']));
        
    }
    
        // chen file css vao trong file nay

}
