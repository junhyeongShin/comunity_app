<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $user_id = $_POST['user_id'];
  $board_id = $_POST['comment_id'];
  $content = $_POST['content'];

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_re_comment_add ="INSERT INTO re_comment (user_id,comment_id,content,create_time)
  VALUES(
  $user_id,
  $board_id,
  '".$content."',
  now())";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_re_comment_add);
  
  if($result){
    echo $result;
    exit;
  }else{
    echo $query_re_comment_add;
    exit;
  }

?>