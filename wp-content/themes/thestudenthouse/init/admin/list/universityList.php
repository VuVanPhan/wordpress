<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class UniversityList extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {

        parent::__construct(array(
            'singular' => __('University Manager', 'academy'), //singular name of the listed records
            'plural' => __('University Manager', 'academy'), //plural name of the listed records
            'ajax' => false //should this table support ajax?
        ));

    }

    /**
     * Retrieve customer’s data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_universities($per_page = 5, $page_number = 1)
    {

        global $wpdb;

        $sql = "SELECT *, usermeta_table.meta_value as university_name, usermeta_table2.meta_value as university_phone, usermeta_table3.meta_value as university_website, usermeta_table4.meta_value as university_status
                  FROM ".UNIVERSITY_PREFIX."users as user_table
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table
                            ON user_table.ID = usermeta_table.user_id
                            AND usermeta_table.meta_key = \"university_name\"
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table2
                            ON user_table.ID = usermeta_table2.user_id
                            AND usermeta_table2.meta_key = \"university_phone\"
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table3
                            ON user_table.ID = usermeta_table3.user_id
                            AND usermeta_table3.meta_key = \"university_website\"
                        LEFT JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table4
                            ON user_table.ID = usermeta_table4.user_id
                            AND usermeta_table4.meta_key = \"university_status\"";
//        var_dump($sql);die();
        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_customer($id)
    {
        global $wpdb;

        $wpdb->delete(
            "{$wpdb->prefix}customers",
            array('ID' => $id),
            array('%d')
        );
    }

    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count()
    {
        global $wpdb;

        //$sql = "SELECT COUNT(*) FROM ".UNIVERSITY_PREFIX."users";
        $sql = "SELECT COUNT(*)
                  FROM ".UNIVERSITY_PREFIX."users as user_table
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table
                            ON user_table.ID = usermeta_table.user_id
                            AND usermeta_table.meta_key = \"university_name\"
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table2
                            ON user_table.ID = usermeta_table2.user_id
                            AND usermeta_table2.meta_key = \"university_phone\"
                        INNER JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table3
                            ON user_table.ID = usermeta_table3.user_id
                            AND usermeta_table3.meta_key = \"university_website\"
                        LEFT JOIN ".UNIVERSITY_PREFIX."usermeta as usermeta_table4
                            ON user_table.ID = usermeta_table4.user_id
                            AND usermeta_table4.meta_key = \"university_status\"";

        return $wpdb->get_var($sql);
    }

    /** Text displayed when no customer data is available */
    public function no_items()
    {
        _e('No university avaliable.', 'academy');
    }

    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_name($item)
    {

        // create a nonce
        $delete_nonce = wp_create_nonce('sp_delete_customer');

        $title = '<strong>' . $item['name'] . '</strong>';

        $actions = array(
            'delete' => sprintf('<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr($_REQUEST['page']), 'delete', absint($item['ID']), $delete_nonce)
        );

        return $title . $this->row_actions($actions);
    }

    /**
     * Render a column when no column specific method exists.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        $university_id = $item['ID'];

        switch ($column_name) {
            case 'university_name':
                return $item[$column_name];
            case 'university_phone':
                return $item[$column_name];
            case 'university_website':
                return '<a href="'.$item[$column_name].'" target="_blank">'.$item[$column_name].'</a>';
            case 'university_view':
                return '<a href="" onclick="showUniversityInformation(\''.get_site_url().'/?view-university-popup='.$university_id.'\'); return false;">'.__('View', 'academy').'</a>';
            case 'university_status':
                return $this->getUniversityStatus($item[$column_name]);
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="university_ids[]" value="%s" />', $item['ID']
        );
    }

    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'university_name' => __('University Name', 'academy'),
            'university_phone' => __('University Phone', 'academy'),
            'university_website' => __('University Website', 'academy'),
            'university_status' => __('Status', 'academy'),
            'university_view' => __('View', 'academy'),
//            'address' => __('Address', 'sp'),
//            'city' => __('City', 'sp')
        );

        return $columns;
    }

    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
//            'user_nicename' => array( 'user_nicename', true ),
            'university_name' => array( 'university_name', true ),
            'university_status' => array( 'university_status', true ),
//            'university_phone' => array( 'university_phone', true ),
//            'city' => array( 'city', false )
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
//            'bulk-delete' => 'Delete',
            'bulk-changetoactive' => 'Change Status To Active',
            'bulk-changetoinactive' => 'Change Status To Inactive'
        );

        return $actions;
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'university_per_page', 5 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ) );


        $this->items = self::get_universities( $per_page, $current_page );
    }

    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
//        if ( 'delete' === $this->current_action() ) {
//
//            // In our file that handles the request, verify the nonce.
//            $nonce = esc_attr( $_REQUEST['_wpnonce'] );
//
//            if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
//                die( 'Go get a life script kiddies' );
//            }
//            else {
//                self::delete_customer( absint( $_GET['customer'] ) );
//
//                wp_redirect( esc_url( add_query_arg() ) );
//                exit;
//            }
//
//        }
        if( 'bulk-changetoactive' === $this->current_action() ){
            if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-changetoactive' )
                || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-changetoactive' )
            ) {
                $change_ids = esc_sql( $_POST['university_ids'] );
                foreach($change_ids as $id){
                    self::change_to_active($id);
                }
//                wp_redirect( esc_url( add_query_arg() ) );
//                exit;
            }
        }

        if( 'bulk-changetoinactive' === $this->current_action() ){
            if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-changetoinactive' )
                || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-changetoinactive' )
            ) {
                $change_ids = esc_sql( $_POST['university_ids'] );
                foreach($change_ids as $id){
                    self::change_to_inactive($id);
                }
//                wp_redirect( esc_url( add_query_arg() ) );
//                exit;
            }
        }

        // If the delete bulk action is triggered
//        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
//            || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
//        ) {
//
//            $delete_ids = esc_sql( $_POST['bulk-delete'] );
//
//            // loop over the array of record IDs and delete them
//            foreach ( $delete_ids as $id ) {
//                self::delete_customer( $id );
//
//            }
//
//            wp_redirect( esc_url( add_query_arg() ) );
//            exit;
//        }
    }

    //get status university register
    public function getUniversityStatus($status){
        if(!$status || $status == '0'){
            echo __('Inactive', 'academy');
        }else{
            echo __('Active', 'academy');
        }
    }

    //public function change university status to active
    public function change_to_active($id){
        global $wpdb;
        $university_usermeta_table = UNIVERSITY_PREFIX.'usermeta';
        $sql = "SELECT user_id FROM ".$university_usermeta_table." WHERE (".$university_usermeta_table.".user_id = \"".$id."\")
                                                                        AND (".$university_usermeta_table.".meta_key = \"university_status\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        if($result){
            $wpdb->update(
                $university_usermeta_table,
                array('meta_value' => '1'),
                array(
                    'user_id' => $id,
                    'meta_key' => 'university_status'
                )
            );
        }else{
            $wpdb->insert(
                $university_usermeta_table,
                array(
                    'user_id' => $id,
                    'meta_key' => 'university_status',
                    'meta_value' => '1'
                )
            );
        }
    }

    //public function change university status to inactive
    public function change_to_inactive($id){
        global $wpdb;
        $university_usermeta_table = UNIVERSITY_PREFIX.'usermeta';
        $sql = "SELECT user_id FROM ".$university_usermeta_table." WHERE (".$university_usermeta_table.".user_id = \"".$id."\")
                                                                        AND (".$university_usermeta_table.".meta_key = \"university_status\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        if($result){
            $wpdb->update(
                $university_usermeta_table,
                array('meta_value' => '0'),
                array(
                    'user_id' => $id,
                    'meta_key' => 'university_status'
                )
            );
        }else{
            $wpdb->insert(
                $university_usermeta_table,
                array(
                    'user_id' => $id,
                    'meta_key' => 'university_status',
                    'meta_value' => '0'
                )
            );
        }
    }

}