<?php

// <!-- 유저 정보를 업데이트 하는 곳
// 1. DB 정보를 미리 가져옵니다
// 2. post로 받은 컨텐츠 타입이 json 인지 확인한다
// 3. 받아온 json 데이터를 decode 해줘서 필요한 데이터 추출한다
// 4. DB에 데이터를 ID로 조회하고 칼럼과 컨텐츠를 업데이트 한다
// 5. 결과를 반환한다 -->


//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require './db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');
 
  
  $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고
  
  $postData = json_decode($__rawBody, true);
  
  $user_id = $postData['user_id'];
  $column = $postData['column'];
  $content = $postData['content'];

  // DB에서 입력받은 회원정보를 업데이트 합니다.
  $sql ="UPDATE user SET $column = '$content' WHERE email = '$user_id'";
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($sql);

  // echo "<br>";
  // echo $sql;
  // echo "<br>";
  
  echo json_encode(array('result_code' => '200','result_check' => 'OK','result_data' =>$result));
  

?>