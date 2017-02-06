<?php
require_once('list/universityList.php');
require_once('list/companyList.php');
class Menu_Admin
{
    // class instance
    static $instance;


    public $university_obj;
    public $company_obj;

    // class constructor
    public function __construct()
    {
        //add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
        add_action('admin_menu', array($this, 'plugin_menu'));
    }

    public static function set_screen($status, $option, $value)
    {
        return $value;
    }

    public function plugin_menu()
    {

        $universityHook = add_menu_page(
            __('University Manager'),
            __('University Manager'),
            'manage_options',
            'university_manager',
            array($this, 'university_settings_page')
        );

        $companyHook = add_menu_page(
            __('Company Manager', 'academy'),
            __('Company Manager', 'academy'),
            'manage_options',
            'company_manager',
            array($this, 'company_settings_page')
        );

//        $hook1 = add_menu_page(
//            'Sitepoint WP_List_Table Example111',
//            'SP WP_List_Table111',
//            'manage_options',
//            'wp_list_table_class1',
//            [$this, 'plugin_settings_page']
//        );

        add_action("load-$universityHook", array($this, 'university_option'));
        add_action("load-$companyHook", array($this, 'company_option'));
//        add_action("load-$hook1", [$this, 'screen_option']);

    }

    /**
     * University options
     */
    public function university_option()
    {

        $option = 'per_page';
        $args = array(
            'label' => __('University Manager','academy'),
            'default' => 5,
            'option' => 'university_per_page'
        );
        add_screen_option($option, $args);
        $this->university_obj = new UniversityList();
    }

    /**
     * Company options
     */
    public function company_option()
    {

        $option = 'per_page';
        $args = array(
            'label' => __('Company Manager','academy'),
            'default' => 5,
            'option' => 'company_per_page'
        );
        add_screen_option($option, $args);
        $this->company_obj = new CompanyList();
    }

    /**
     * Plugin settings page
     */
    public function plugin_settings_page()
    {
        ?>
        <div class="wrap">
            <h2>WP_List_Table Class Example</h2>

            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2" style="width: 100%">
                    <div id="post-body-content" style="width: 100%">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->university_obj->prepare_items();
                                $this->university_obj->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    /**
     * University settings page
     */
    public function university_settings_page()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('University Manager', 'academy') ?></h2>
            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ."/init/lib/tinybox/style.css"; ?>" />
            <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ."/init/lib/tinybox/tinybox.js" ?>"></script>
            <script type="text/javascript">
                function showUniversityInformation(url){
                    TINY.box.show(url,1,550,400,1);
                }
            </script>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2" style="width: 100%">
                    <div id="post-body-content" style="width: 100%">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->university_obj->prepare_items();
                                $this->university_obj->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    /**
     * Company settings page
     */
    public function company_settings_page()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('Company Manager', 'academy') ?></h2>
            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ."/init/lib/tinybox/style.css"; ?>" />
            <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ."/init/lib/tinybox/tinybox.js" ?>"></script>
            <script type="text/javascript">
                function showCompanyInformation(url){
                    TINY.box.show(url,1,550,400,1);
                }
            </script>
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2" style="width: 100%">
                    <div id="post-body-content" style="width: 100%">
                        <div class="meta-box-sortables ui-sortable">
                            <form method="post">
                                <?php
                                $this->company_obj->prepare_items();
                                $this->company_obj->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear">
            </div>
        </div>
        <?php
    }

    /** Singleton instance */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


}