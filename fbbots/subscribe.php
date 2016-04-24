<?php
require_once 'inc/import.php';
global $bot_config;
$curl = new Curl();
$curl->post("https://graph.facebook.com/v2.6/me/subscribed_apps?access_token=" . $bot_config['page_access_token']);
echo "<pre>"; print_r($curl->response); echo "</pre>";