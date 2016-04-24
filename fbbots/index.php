<?php
/** You have to set allow_url_fopen in case of your environment haven't this turned on */
ini_set( 'allow_url_fopen', true );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** Page subscription verification */
if ( isset( $_REQUEST['hub_verify_token'] ) && $_REQUEST['hub_verify_token'] == 'FacebookMessengerBots' ) { //The token
	echo $_REQUEST['hub_challenge'];
	exit;
}
/** After page subscription success, you can delete above code */

require_once 'inc/import.php';
require_once 'sample/sample.php';