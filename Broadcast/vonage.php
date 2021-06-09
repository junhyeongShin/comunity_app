<?php
require "<projectpath>/vendor/autoload.php";
include 'config.php';

use OpenTok\OpenTok;

$opentok = new OpenTok($apiKey, $apiSecret);

?>