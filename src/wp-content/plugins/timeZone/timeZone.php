<?php
/*
* Plugin Name:       timeZone
*/

if (!defined("ABSPATH")) {
    die();
}

global $time_zone_version;
$time_zone_version = '13333.0';


function hello()
{
    echo 'Hello World!';
}

//add_action("admin_init",'hello');
register_activation_hook(__FILE__, 'jal_install');

class TimeZone
{
    function __construct()
    {
    }


    function activation()
    {
        global $wpdb;
        global $time_zone_version;

        $table_name = $wpdb->prefix . "time_zone";
        $charset_collate = $wpdb->get_charset_collate();


        $wpdb->query($wpdb->prepare(
            "CREATE TABLE IF NOT EXISTS $table_name (
        id_user bigint(20)  PRIMARY KEY,
        timezone varchar(200) NOT NULL
   )"));


        add_option('time_zone_version', $time_zone_version);


        /*     $wpdb->insert(
                $table_name,
                array(
                    'id_user' => 22,
                    'timezone' => '$welcome_name',
                )
            );*/

    }


    function deactivation()
    {


    }

    function uninstall()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "time_zone";

        $wpdb->query($wpdb->prepare(
            "DROP TABLE IF  EXISTS $table_name "));

    }

    function enqueue_backend()
    {
        wp_enqueue_style('cssBackend', plugins_url('/assets/backend/style.css', __FILE__));
        wp_enqueue_script('jsBackend', plugins_url('/assets/backend/scripts.js', __FILE__));
    }

    function enqueue_front()
    {
        wp_enqueue_style('cssBackend', plugins_url('/assets/front/style.css', __FILE__));
        wp_enqueue_script('jsBackend', plugins_url('/assets/front/scripts.js', __FILE__));
    }


    function register()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_backend']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_front']);
        add_action('admin_menu', [$this, 'add_admin_menu']);

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'add_action_links']);


        add_action('admin_init', [$this, 'settings_init']);

    }

    //Register settings
    public function settings_init()
    {

        register_setting('booking_settings', 'booking_settings_options');

        add_settings_section('booking_settings_section', esc_html__('Settings', 'time_zone'), [$this, 'settings_section_html'], 'time_zone_settings');

        // add_settings_field('timeZoneSelect', esc_html__('Posts per page', 'time_zone'), [$this, 'posts_per_page_html'], 'time_zone_settings', 'booking_settings_section');

    }


    //Settings section html
    public function settings_section_html()
    {
        global $wpdb;
        $idUSer = wp_get_current_user()->ID;
        if (!empty($idUSer)) {
            $table_name = $wpdb->prefix . "time_zone";

            $res = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM $table_name WHERE id_user = $idUSer"));

            if (empty($res)) {
                $defaultZone = 'Europe/Minsk';
                $wpdb->insert(
                    $table_name,
                    array(
                        'id_user' => $idUSer,
                        'timezone' => $defaultZone,
                    )
                );
                $res->timezone = $defaultZone;
            }
            $date = new DateTime("now", new DateTimeZone($res->timezone));

            echo '<h1> Time Zone User: <h1 id="TZ"> ' . $res->timezone . '</h1></h1><br>';

            echo '<h1> Time Now : <h1 id="time">  ' . $date->format('m/d/Y, h:i:s A') . '</h1> </h1><br>';


            $timezone_identifiers = DateTimeZone::listIdentifiers();
            echo '<select name="timeZoneSelect" id="zone" >';
            foreach ($timezone_identifiers as $timezone) {
                $selected = $timezone == $res->timezone ? " selected " : "";
                echo "<option $selected>" . $timezone . '</option>';
            }
            echo '</select>';
        }
    }


    function add_action_links($links)
    {
        $action_links = array(
            'settings' => '<a href="' . admin_url('admin.php?page=time_zone_settings') . '">' . esc_html__('Settings', 'time_Zne') . '</a>',
        );

        return array_merge($action_links, $links);
    }

    function add_admin_menu()
    {
        add_menu_page(
            esc_html__('TimeZone', 'time_zone'),
            'TimeZone',
            'manage_options',
            'time_zone_settings',
            [$this, 'time_zone_settings_page'],
            'dashicons-admin-multisite',
            677
        );
    }

    function time_zone_settings_page()
    {
        require_once plugin_dir_path(__FILE__) . 'backend/settings.php';
    }

}

if (class_exists('TimeZone')) {
    $timeZone = new TimeZone();
    $timeZone->register();

    register_activation_hook(__FILE__, array($timeZone, 'activation'));

    register_deactivation_hook(__FILE__, array($timeZone, 'deactivation'));

    register_uninstall_hook(__FILE__, array($timeZone, 'uninstall'));


}



