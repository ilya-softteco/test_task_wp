<?php
require_once 'help.php';

require_once  dirname( __DIR__ ) . '/'  . 'wp-includes/formatting.php' ;
$timeZone = esc_sql($_POST['timezoneName']);
var_dump($timeZone);
die();

$idUser = getUserId();
/*if(!empty($idUser)) {
    $query = "SELECT id FROM tableName() where id  = getUserId()";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $getData  = dbDelta($query);
}

return'';