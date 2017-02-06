<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class CompanyList extends WP_List_Table
{

    /** Class constructor */
    public function __construct()
    {

        parent::__construct(array(
            'singular' => __('Company Manager', 'academy'), //singular name of the listed records
            'plural' => __('Company Manager', 'academy'), //plural name of the listed records
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
    public static function get_companies($per_page = 5, $page_number = 1)
    {

        global $wpdb;

        $sql = "SELECT *, usermeta_table.meta_value as company_name, usermeta_table2.meta_value as company_phone, usermeta_table3.meta_value as company_website, usermeta_table4.meta_value as company_status
                  FROM ".COMPANY_PREFIX."users as user_table
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table
                            ON user_table.ID = usermeta_table.user_id
                            AND usermeta_table.meta_key = \"company_name\"
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table2
                            ON user_table.ID = usermeta_table2.user_id
                            AND usermeta_table2.meta_key = \"company_phone\"
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table3
                            ON user_table.ID = usermeta_table3.user_id
                            AND usermeta_table3.meta_key = \"company_website\"
                        LEFT JOIN ".COMPANY_PREFIX."usermeta as usermeta_table4
                            ON user_table.ID = usermeta_table4.user_id
                            AND usermeta_table4.meta_key = \"company_status\"";
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
                  FROM ".COMPANY_PREFIX."users as user_table
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table
                            ON user_table.ID = usermeta_table.user_id
                            AND usermeta_table.meta_key = \"company_name\"
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table2
                            ON user_table.ID = usermeta_table2.user_id
                            AND usermeta_table2.meta_key = \"company_phone\"
                        INNER JOIN ".COMPANY_PREFIX."usermeta as usermeta_table3
                            ON user_table.ID = usermeta_table3.user_id
                            AND usermeta_table3.meta_key = \"company_website\"
                        LEFT JOIN ".COMPANY_PREFIX."usermeta as usermeta_table4
                            ON user_table.ID = usermeta_table4.user_id
                            AND usermeta_table4.meta_key = \"company_status\"";

        return $wpdb->get_var($sql);
    }

    /** Text displayed when no customer data is available */
    public function no_items()
    {
        _e('No company avaliable.', 'academy');
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
        $company_id = $item['ID'];

        switch ($column_name) {
            case 'company_name':
                return $item[$column_name];
            case 'company_phone':
                return $item[$column_name];
            case 'company_website':
                return '<a href="'.$item[$column_name].'" target="_blank">'.$item[$column_name].'</a>';
            case 'company_view':
                return '<a href="" onclick="showCompanyInformation(\''.get_site_url().'/?view-company-popup='.$company_id.'\'); return false;">'.__('View', 'academy').'</a>';
            case 'company_status':
                return $this->getCompanyStatus($item[$column_name]);
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
            '<input type="checkbox" name="company_ids[]" value="%s" />', $item['ID']
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
            'company_name' => __('Company Name', 'academy'),
            'company_phone' => __('Company Phone', 'academy'),
            'company_website' => __('Company Website', 'academy'),
            'company_status' => __('Status', 'academy'),
            'company_view' => __('View', 'academy'),
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
            'company_name' => array( 'company_name', true ),
            'company_status' => array( 'company_status', true ),
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
            'bulk-changetoactive' => __('Change Status To Active', 'academy'),
            'bulk-changetoinactive' => __('Change Status To Inactive', 'academy')
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

        $per_page     = $this->get_items_per_page( 'company_per_page', 5 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();
        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ));


        $this->items = self::get_companies( $per_page, $current_page );
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
                $change_ids = esc_sql( $_POST['company_ids'] );
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
                $change_ids = esc_sql( $_POST['company_ids'] );
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
    public function getCompanyStatus($status){
        if(!$status || $status == '0'){
            echo __('Inactive', 'academy');
        }else{
            echo __('Active', 'academy');
        }
    }

    //public function change university status to active
    public function change_to_active($id){
        global $wpdb;
        $company_usermeta_table = COMPANY_PREFIX.'usermeta';
        $sql = "SELECT user_id FROM ".$company_usermeta_table." WHERE (".$company_usermeta_table.".user_id = \"".$id."\")
                                                                        AND (".$company_usermeta_table.".meta_key = \"company_status\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        if($result){
            $wpdb->update(
                $company_usermeta_table,
                array('meta_value' => '1'),
                array(
                    'user_id' => $id,
                    'meta_key' => 'company_status'
                )
            );
        }else{
            $wpdb->insert(
                $company_usermeta_table,
                array(
                    'user_id' => $id,
                    'meta_key' => 'company_status',
                    'meta_value' => '1'
                )
            );
        }
    }

    //public function change university status to inactive
    public function change_to_inactive($id){
        global $wpdb;
        $company_usermeta_table = COMPANY_PREFIX.'usermeta';
        $sql = "SELECT user_id FROM ".$company_usermeta_table." WHERE (".$company_usermeta_table.".user_id = \"".$id."\")
                                                                        AND (".$company_usermeta_table.".meta_key = \"company_status\")";
        $result = $wpdb->get_results($sql, 'ARRAY_A');
        if($result){
            $wpdb->update(
                $company_usermeta_table,
                array('meta_value' => '0'),
                array(
                    'user_id' => $id,
                    'meta_key' => 'company_status'
                )
            );
        }else{
            $wpdb->insert(
                $company_usermeta_table,
                array(
                    'user_id' => $id,
                    'meta_key' => 'company_status',
                    'meta_value' => '0'
                )
            );
        }
    }

}