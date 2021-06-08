<?php
include 'config.php';


$timestamp = time();
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
echo '<br>';


$headers = array();
$headers[] = "wsc-api-key: ZU5iQaPSt14WHFvQPZ1DGRDxBOc0R7bSHa2vN0W4JA0Q3hXONsRtr0T8uQoA3010";
$headers[] = "wsc-access-key: mstPlRkXe7mYayBY3BrfjI0H1TuNr1sVwJkWkSoFRNSDXba5zR3guns3s9uw3614";
$headers[] = "Content-Type: application/json";
$headers[] = "wsc-timestamp : ".$timestamp;
$headers[] = "wsc-signature : ".$hash_key;

// $headers = array(
//   'wsc-api-key : ZU5iQaPSt14WHFvQPZ1DGRDxBOc0R7bSHa2vN0W4JA0Q3hXONsRtr0T8uQoA3010',
//   'wsc-access-key : mstPlRkXe7mYayBY3BrfjI0H1TuNr1sVwJkWkSoFRNSDXba5zR3guns3s9uw3614',
//   'Content-Type : application/json'
// );

// var signature = crypto.createHmac('sha256',wscApiKey).update(hmacData).digest('hex')

$url = "https://api-sandbox.cloud.wowza.com/api/v1.6/live_streams";
print_r($headers);
echo '<br>';
echo '<br>';

$ch = curl_init();                                 //curl 초기화


curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

curl_setopt($ch, CURLOPT_POSTFIELDS, print_r($data));       //POST data

curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송 

$response = curl_exec($ch);
curl_close($ch);

// return $response;



echo '<br>';
echo '<br>';

echo $response;

?>