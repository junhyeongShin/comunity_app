<?php

//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database

require './db_user_info.php';

// header('Content-Type: application/json; charset=UTF-8');
 
//   $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
//   // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

//   $postData = json_decode($__rawBody, true);

  // $user_id = $_POST['user_id'];
  $column = $_POST['column'];
  $content = $_POST['content'];

  echo $column;
  echo $content;

  // DB에서 입력받은 회원정보를 조회합니다.
  // $sql ="UPDATE user SET '$column' = '$content' WHERE email = '$user_id'";

  // //DB에 연결합니다.
  // $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  // mysqli_select_db($conn, $database);
  // $result = $conn->query($sql);

  // $row=mysqli_fetch_assoc($result);

  $response =array();

  $response["result_code"] = 200;
  $response["result_check"] = 'OK';
  $response["column"] = $column;
  $response["content"] = $content;


  // echo json_encode(array('result_code' => '200','result_check' => 'OK','response' =>$response));

  echo json_encode($response);

  exit;


?>