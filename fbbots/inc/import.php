<?php
define('BOT_DIR', dirname(dirname(__FILE__)) .'/');

$bot_config = require_once BOT_DIR . 'config.php';
require_once BOT_DIR . 'lib/CaseInsensitiveArray.php';
require_once BOT_DIR . 'lib/Curl.php';
require_once BOT_DIR . 'inc/FacebookMessageReceive.php';
require_once BOT_DIR . 'inc/FacebookMessageResponse.php';
require_once BOT_DIR . 'inc/MessengerBot.php';