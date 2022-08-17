<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require($path . '/wp-load.php');

$idUSer = wp_get_current_user()->ID;
$timeZoneSelect = $_POST['timeZoneSelect'];
if (!empty($timeZoneSelect) && !empty($idUSer)) {

    global $wpdb;

    $table_name = $wpdb->prefix . "time_zone";


    $wpdb->query($wpdb->prepare(
        "UPDATE $table_name
SET timezone = '" . $timeZoneSelect . "'
WHERE id_user =  $idUSer;"));


    return 'OK';
}
