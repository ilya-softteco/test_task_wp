<?php
/*
    Plugin Name: Set TimeZone
    Author: Martinkevich Ilya
    Version: 1.0
*/

if (!defined("ABSPATH")) {
    die();
}

class SelectTimeZone
{
    public function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));

    }

    function activate()
    {
        flush_rewrite_rules();
        echo 'plugin was activated';
    }

    function deactivate()
    {
        flush_rewrite_rules();

        echo 'plugin was deactivate';
    }

    function uninstall()
    {
        $posts = get_posts(array('post_type' => 'timezone'));
        foreach ($posts as $data){
            wp_delete_post($data->ID);
        }
    }

    function custom_post_type()
    {
        register_post_type('TimeZone', ['public' => true, 'label' => 'TimeZone']);
    }
}

if (class_exists('SelectTimeZone')) {
    $selectTimeZone = new SelectTimeZone();

    register_activation_hook(__FILE__, array($selectTimeZone, 'activate'));

    register_deactivation_hook(__FILE__, array($selectTimeZone, 'deactivate'));

    register_uninstall_hook(__FILE__, array($selectTimeZone, 'uninstall'));

}
/*
require_once 'help.php';
function my_plugin_activate()
{

    $query = "CREATE TABLE if not exists  tableName()(
        id bigint(20) PRIMARY KEY auto_increment,
        id_user bigint(20) unsigned NOT NULL UNIQUE,
        timezone varchar(200) NOT NULL
   )";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($query);
}

function displayTimeZoneList()
{
    $timezone_identifiers = DateTimeZone::listIdentifiers();
    echo '<select name="timeZoneSelect" id="zone">';
    foreach ($timezone_identifiers as $timezone) {
        echo '<option>' . $timezone . '</option>';
    }
    echo '</select>';
}




function mytheme_scripts() {
    wp_enqueue_script('jquery', get_template_directory_uri().'/js/jquery.min.js', array('jquery'));
  //  wp_enqueue_script('main', '/wp-content/plugins/select_timezone/js/main.js');

}
add_action( 'wp_enqueue_scripts', 'mytheme_scripts' );

//displayTimeZoneList();
register_activation_hook(__FILE__, 'my_plugin_activate');*/

