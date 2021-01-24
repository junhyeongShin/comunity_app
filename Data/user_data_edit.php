<?php

//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database

require './db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');
 
// 컨텐츠 타입이 JSON 인지 확인한다
if(!in_array('application/json',explode(';',$_SERVER['CONTENT_TYPE']))){
echo json_encode(array('result_code' => '400'));
exit;

}else{

$__rawBody = file_get_contents("php://input"); // 본문을 불러옴
// $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

$postData = json_decode($__rawBody, true);


$user_id = $postData['user_id'];
$column = $postData['column'];
$content = $postData['content'];

// DB에서 입력받은 회원정보를 조회합니다.
$sql ="UPDATE user SET '$column' = '$content' WHERE email = '$user_id'";

//DB에 연결합니다.
$conn = mysqli_connect($db_address, $db_userid, $db_userpw);
mysqli_select_db($conn, $database);
$result = $conn->query($sql);

$row=mysqli_fetch_assoc($result);

echo json_encode(array('result_code' => '200','result_check' => 'OK','result_data' =>$row));

exit;
}

?>