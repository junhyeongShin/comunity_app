<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database

require dirname(__FILE__,2).'/db_user_info.php';


header('Content-Type: application/json; charset=UTF-8');
 
$img_id = $_GET['img_porfile'];

// DB에서 입력받은 회원정보를 조회합니다.
$sql ="SELECT * FROM image WHERE id = '$img_id'";

//DB에 연결합니다.
$conn = mysqli_connect($db_address, $db_userid, $db_userpw);
mysqli_select_db($conn, $database);
$result = $conn->query($sql);

$row = mysqli_fetch_assoc($result);


$img_path = $row['img_path'];

echo json_encode($img_path);

?>