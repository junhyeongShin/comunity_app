<?php

$timestamp = 100000;
$path = "api/v1.6/live_streams";
$wscApiKey = "ZU5iQaPSt14WHFvQPZ1DGRDxBOc0R7bSHa2vN0W4JA0Q3hXONsRtr0T8uQoA3010";

$wscApiKey_hash = hash('sha256',$wscApiKey);

$hmacData = ($timestamp.' : '.$path.' : '.$wscApiKey);
echo $hmacData;
echo '<br>';
hmacData
$hash_key = hash_hmac('sha256',$wscApiKey_hash,$wscApiKey_hash,false);
echo $hash_key;
echo '<br>';


?>