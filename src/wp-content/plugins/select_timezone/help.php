<?php

function getUserId() {
    require_once( ABSPATH . 'wp-includes/pluggable.php' );
    if ( ! function_exists( 'wp_get_current_user' ) ) {
        return 0;
    }
    $user = wp_get_current_user();
    return ( isset( $user->ID ) ? (int) $user->ID : 0 );
}


function tableName(){
    global $wpdb;

    return $wpdb->prefix . 'timezone';

}