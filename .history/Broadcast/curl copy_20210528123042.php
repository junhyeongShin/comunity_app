<?php

$timestamp = 100000;
$path = "api/v1.6/live_streams";
$wscApiKey = "ZU5iQaPSt14WHFvQPZ1DGRDxBOc0R7bSHa2vN0W4JA0Q3hXONsRtr0T8uQoA3010";

$hmacData = ($timestamp.' : '.$path.' : '.$wscApiKey);
echo $hmacData;
echo '<br>';


// function changeCharset(&$item) {
//   if(is_string($item)==true) { $encoding = array('UTF-8'); if(detectEncoding($item, $encoding)!='UTF-8') $item = iconv('EUC-KR', 'UTF-8', $item); }
// }
// function detectEncoding($str, $encodingSet) {
//   foreach ($encodingSet as $v) { $tmp = iconv($v, $v, $str); if(md5($tmp) == md5($str)) return $v; } return false;
// }

$hash_key = hash_hmac('sha256',$hmacData,$wscApiKey);
echo $hash_key;
echo '<br>';

$hex = bin2hex($hash_key);

echo $hex;


?>