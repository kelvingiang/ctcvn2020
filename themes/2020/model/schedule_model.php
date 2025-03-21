<?php

// KIEM TRA  WP_List_Table CO TON TAI CHUA NEU CHUA SE INCLUSE VAO
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php ';
}

class Admin_Schedule_Model extends WP_List_Table {

    private $_pre_page = 30;
    private $_sql;

    public function __construct($args = array()) {
        $args = array(
            'plural' => 'id', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'singular' => 'id', // GIA TRI NAY TUONG UNG VOI key TRONG table
            'ajax' => FALSE,
            'screen' => null,
        );
        parent::__construct($args);
    }

    // HAM NAY BAT BUOT PHAI CO QUAN TRONG DE SHOW LIST RA
    //  CAC THONG SO VA DU LIEU CAN  CUNG CAP DE HIEN THI GIRDVIEW
    public function prepare_items() {
        $columns = $this->get_columns();  // NHUNG GI CAN HIEN THI TREN BANG 
        $hidden = $this->get_hidden_columns(); // NHUNG COT TA SE AN DI
        $sorttable = $this->get_sortable_columns(); // CAC COT DC SAP XEP TANG HOAC GIAM DAN

        $this->_column_headers = array($columns, $hidden, $sorttable); //DUA 3 GIA TRI TREN VAO DAY DE SHOW DU LIEU
        $this->items = $this->table_data(); // LAY DU LIEU TU DATABASE

        $total_items = $this->total_items(); // TONG SO DONG DA LIEU
        $per_page = $this->_pre_page; // SO TRANG 
        $total_pages = ceil($total_items / $per_page); // TONG SO TRANG
        // PHAN TRANG
        $args = array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => $total_pages
        );
        $this->set_pagination_args($args);
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM NHAT DINH  PHAI CO CHO LIST NAY
    //---------------------------------------------------------------------------------------------
    // LAY CAC COT TUONG UNG TRONG DATABASE DAN VAO CAC COT TREN LUOI
    public function get_columns() {
        $arr = array(
            'cb' => '<input type="checkbox" />',
            //   'id'            => 'ID',
            'title' => '活動項目',
            'status' => '顯示',
            'year' => '日期',
            'time' => '時間',
            'branch' => '分會',
            'place' => '地點',
                // 'note' => '備註'
        );
        return $arr;
    }

    // KHIA BAO CAC COT BI AN DI TREN GRIDVIEW
    public function get_hidden_columns() {
        return array();
    }

    // COLUMN SAP XEP THU TANG HOAC GIAM DAN
    public function get_sortable_columns() {
        return array(
            'title' => array('title', true),
            'id' => array('id', true),
        );
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM GET DATA TU DATABASE
    //---------------------------------------------------------------------------------------------
    // GET DATA TRONG DATABASE 
    private function table_data() {
        $data = array();
        global $wpdb;
        // LAY GIA TRI SAP XEP DU LIEU TREN COT
        $orderby = (getParams('orderby') == ' ') ? 'id' : $_GET['orderby'];
        $order = (getParams('order') == ' ') ? 'DESC' : $_GET['order'];
        $tblTest = $wpdb->prefix . 'schedule';
        $sql = 'SELECT m.* FROM ' . $tblTest . ' AS m ';
        $whereArr = array();  // TAO MANG WHERE

        if (getParams('filter_status') != ' ') {
            $status = (getParams('filter_status') == 'active') ? 1 : 0;
            $whereArr[] = "(m.status = $status)";
        }

        if (getParams('s') != ' ') {
            $s = esc_sql(getParams('s'));
            $whereArr[] = "(m.title  LIKE '%$s%')";
        }

        // CHUYEN CAC GIA TRI where KET VOI NHAU BOI and
        if (count($whereArr) > 0) {
            $sql .= " WHERE " . join(" AND ", $whereArr);
        }

        // orderby
        $sql .= 'ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);

        $this->_sql = $sql;


        //LAY GIA TRI PHAN TRANG PAGEING
        $paged = max(1, @$_REQUEST['paged']);
        $offset = ($paged - 1) * $this->_pre_page;

        $sql .= ' LIMIT  ' . $this->_pre_page . ' OFFSET ' . $offset;

        // LAY KET QUA  THONG QUA CAU sql
        $data = $wpdb->get_results($sql, ARRAY_A);

//         echo '<pre>';
//         print_r($sql);
//         echo '</pre>';

        return $data;
    }

    // TINH TONG SO DONG DU LIEU  DE AP DUNG CHO VIEC PHAN TRANG
    public function total_items() {
        global $wpdb;
        return $wpdb->query($this->_sql);
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM CAC SELECT BOX O DAU CUA LIST
    //---------------------------------------------------------------------------------------------
    // CAC ITEM TRONG SELECT BOX CHUC NANG 'UNG DUNG'
    public function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete',
            'active' => 'Active',
            'inactive' => 'Inactive'
        );
        return $actions;
    }

    // CAC ITEM TRONG SECLETBOX TRONG PHAN FILTER
    public function extra_tablenav($which) {
        if ($which == 'top') {
            $htmlObj = new MyHtml();

            $filterVal = @$_REQUEST['filter_status'];
            $options['data'] = array(
                '0' => 'status filter',
                'active' => 'Active',
                'inactive' => 'Inactive'
            );

            $slbFilter = $htmlObj->selectbox('filter_status', $filterVal, array(), $options);
            $attr = array('id' => 'filter_action', 'class' => 'button');
            $btnFilter = $htmlObj->button('filter_action', 'Filter', $attr);

            echo '<div class="alignleft action bulkactions">' . $slbFilter . $btnFilter . '</div>';
        }
    }

    //---------------------------------------------------------------------------------------------
    // Cmt NHOM THIET LAP GIA TRI CHO CAC CLOUMN
    //---------------------------------------------------------------------------------------------
    // TAO CAC CHECK BOS O DAU DONG TRONG 
    public function column_cb($item) {
        $singular = $this->_args['singular'];
        $html = '<input type="checkbox" name="' . $singular . '[]" value="' . $item['id'] . '"/>';
        return $html;
    }

    // THEM CAC PHAN CHINH SUA NHANH TAI COLUMN NAY
    //DAT TEN column_TEN COLUMN CAN TAO CAC CHINH SUA NHANH
    public function column_title($item) {
        $page = getParams('page');
        $name = 'security_code';

        $linkDelete = add_query_arg(array('action' => 'delete', 'id' => $item['id']));
        $action = 'delete_id' . $item['id'];
        $linkDelete = wp_nonce_url($linkDelete, $action, $name);

        $actions = array(
            'edit' => '<a href=" ?page=' . $page . '&action=edit&id=' . $item['id'] . ' " > Edit </a>',
            'delete' => '<a href="' . $linkDelete . '" onclick="MyConfirm()"> Delete </a>',
                // 'view' => '<a href ="#">View</a>'
        );

        $html = '<strong> <a href="?page=' . $page . '&action=edit&id=' . $item['id'] . ' ">' . $item['title'] . '</a> </strong>' . $this->row_actions($actions);
        return $html;
    }

    public function column_status($item) {
        $page = getParams('page');
        if ($item['status'] == 1) {
            $action = 'inactive';
            $src = get_icon('active32x32.png');
        } else {
            $action = 'active';
            $src = get_icon('inactive32x32.png');
        }

        // TAO SECURITY CODE
        $paged = max(1, @$_REQUEST['paged']);
        $name = 'security_code';
        $linkStatus = add_query_arg(array('action' => $action, 'id' => $item['id'], 'paged' => $paged));
        $action = $action . '_id_' . $item['id'];
        $linkStatus = wp_nonce_url($linkStatus, $action, $name);

        $html = '<img alt="" src=" ' . $src . ' " />';
        $html = '<a href ="' . $linkStatus . ' ">' . $html . '</a>';
        return $html;
    }

    // SET GIA TRI COT YEAR
    public function column_year($item) {
        echo $item['date'];
    }

    // SET LAI GIA TRI COT TIME
    public function column_time($item) {
        echo $item['weekdays'] . '</br>' . $item['time'];
    }

    //CAC COLUMN MAC DINH KHI LOAD TRANG SE SHOW LEN 
    public function column_default($item, $column_name) {
        return $item[$column_name];
    }

    //---------------------------------------------------------------------------------------------
    // Cmt  CAC CHUC ADD EDIT DELETE 
    //---------------------------------------------------------------------------------------------
    // SAVE DATA DEN DATABASE
    public function save_item($arrData = array(), $option = array()) {
        global $wpdb;

        $action = $arrData['action'];

        // TAO  GIA TRI slug  
        // a : neu slug co nhap gia tri thi lay gia tri no, neu khong thi la gia tri cua title
        $slug = '';
        if (empty($arrData['slug'])) {
            $slug = sanitize_title($arrData['title']);
        } else {
            $slug = sanitize_title($arrData['slug']);
        }
        //HAM KIEM TRA slug TRONG DATABASE
        // b : KIEM TRA  slug  TON TAI TRONG DATABASE CHUA VA KHI DA TON TAI SE CAP GIA TRI slug 
        require_once (CLASS_DIR . 'create_slug.php');
        $slugHelper = new Admin_CreateSlug_helper();
        // KIEM TRA action LA add HAY edit DE CHUYEN THAM CHO VIEC CAP GIA TRI CHO slug
        if ($action == 'add') {
            // LA ADD CHI CAN CHUYEN 2 THAM SO table va field CHUA slug
            $optionSlug = array('table' => 'schedule', 'field' => 'slug');
        } else if ($option == 'edit') {
            // LA EDIT PHAI CHUYEN THEM THAM SO exception VOI field la id và value la id CUA DOI TUONG CAN SUA
            $optionSlug = array('table' => 'schedule', 'field' => 'slug', 'exception' => array('field' => 'id', 'value' => absint($arrData['id'])));
        }
        // TAO GIA TRI slug THONG QUA HAM getSlug LAY GIA TRI TRA VE DUA VAO DATABASSE
        $slug = $slugHelper->getSlug($slug, $optionSlug);

        // CAC DOI TUONG date THANH CAC PHAN NHO 
        $date = $arrData['date'];
        $arrDate = explode('/', $date);


        // kIEM ADD NEW OR UPDATE
        $table = $wpdb->prefix . 'schedule';
        $data = array(
            'title' => $arrData['title'],
            'slug' => $slug, // muc luu gia tri co su ly
            'year' => $arrDate[2],
            'month' => $arrDate[1],
            'day' => $arrDate[0],
            'weekdays' => $arrData['weekdays'],
            'time' => $arrData['timeStart'] . '-' . $arrData['timeEnd'],
            'branch' => $arrData['branch'],
            'place' => $arrData['place'],
            'note' => $arrData['note'],
            'status' => $arrData['status'],
            // cac muc save gia tri co su ly
            'date' => $date,
            'create-date' => date('Y-m-d'),
        );
        
        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s'); // LA STR %s , LÀ SO %d
        if ($action == 'add') {
            $wpdb->insert($table, $data);
        } else if ($action == 'edit') {
            $where = array('id' => absint($arrData['id']));  // CHUYEN THEM DK DE UPDATE 
            $wpdb->update($table, $data, $where);
        }
            $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
        wp_redirect($url);
    }

    // LAY DU LIEU CAN CHINH SUA
    public function get_item($arrData = array(), $option = array()) {
        global $wpdb;
        // THONG SO id DUA CHUYEN TREN url DE LAY DONG DU LIEU CAN CHINH SUA
        $id = absint($arrData['id']);  // ham absint  chuyen ky tu sang kieu so
        $table = $wpdb->prefix . 'schedule';
        $sql = "SELECT * FROM $table WHERE id = $id";
        $row = $wpdb->get_row($sql, ARRAY_A);  // LAY DONG DU LIEU TRA VE KIEU array
        return $row;
    }

    // XOA DATA
    public function deleteItem($arrData = array(), $options = array()) {
        global $wpdb;
        $flag = $_COOKIE['del'];

        if ($flag == 'true') {
            $table = $wpdb->prefix . 'schedule';
            // KIEM TRA PHAN DELETE CÓ PHAN DANG CHUOI HAY KHONG
            if (!is_array($arrData['id'])) {
                $where = array('id' => absint($arrData['id']));
                $wpdb->delete($table, $where);
            } else {
                $arrData['id'] = array_map('absint', $arrData['id']);
                $ids = join(',', $arrData['id']);
                echo '<br>' . $ids;
                $sql = "DELETE FROM $table  WHERE id IN ($ids)";
                $wpdb->query($sql);
            }
        }
    }

    // THAY DOI TRANG THAI 
    public function changeStatus($arrData = array(), $options = array()) {
        global $wpdb;

        $table = $wpdb->prefix . 'schedule';
        $status = ($arrData['action'] == 'active') ? 1 : 0;
        // KIEM TRA PHAN UPFDATE CÓ PHAN DANG CHUOI HAY KHONG
        if (!is_array($arrData['id'])) {
            $data = array('status' => absint($status));
            $where = array('id' => absint($arrData['id']));
            $wpdb->update($table, $data, $where);
        } else {
            $arrData['id'] = array_map('absint', $arrData['id']);
            $ids = join(',', $arrData['id']);
            echo '<br>' . $ids;
            $sql = "UPDATE $table SET status = $status WHERE id IN ($ids)";
            $wpdb->query($sql);
        }
    }

    public function sendMail(array $contentData) {
        //LAY TAT CA CAC THANH VIEN
        $arrMember = array(
            'post_type' => 'member',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'm_active',
                    'value' => 'on',
                ))
        );
        $arrMailTo = array('giaminh0265@yahoo.com', 'giaminh_vn@digiwin.biz', 'giaminh0265@gmail.com');
//        $memQuery = new WP_Query($arrMember);
//        if ($memQuery->have_posts()):
//            while ($memQuery->have_posts()):
//                $memQuery->the_post();
//                $arrMailTo[] = get_post_meta(get_the_ID(), 'm_email', true);
//            endwhile;
//        endif;
        //   if ($send == 'true') {
////          $arrMailTo = array('giaminh0265@yahoo.com', 'giaminh0265@gmail.com','giaminh_vn@digiwin.biz');
//          $arrMailTo = 'giaminh0265@yahoo.com;giaminh0265@gmail.com;giaminh_vn@digiwin.biz';
        $subj = '台灣商會總會的行事曆';
        $content = '<h3>台灣商會總會的行事曆</h3></br>';
        $content .= '<h2 style= "color:blue">' . $contentData['title'] . '</h2>';
        $content .= '<p><i>日期 :</i> ' . $contentData['date'] . ' - ' . $contentData['weekdays'] . '</p>';
        $content .= '<p><i>時間 :</i> ' . $contentData['timeStart'] . ' - ' . $contentData['timeEnd'] . '</p>';
        $content .= '<p><i>地點 :</i> ' . $contentData['branch'] . ' - ' . $contentData['place'] . '</p>';
        $content .= '<p>' . $contentData['note'] . '</p>';
        $content .= '<a href="http://ctcvn.vn/schedule/"><h3>' . 台灣商會總會網站 . '</h3></a>';
       
        wp_mail($arrMailTo, $subj, $content);
//    SAU KHI SEND XONG CHUYEN VE TRANG SHOW
        $url = 'admin.php?page=' . $_REQUEST['page'] . '&msg=1';
        wp_redirect($url);
        //  }
    }

}
