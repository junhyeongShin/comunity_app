<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $id = $_POST['id'];
  $content = $_POST['content'];

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_comment_edit ="UPDATE re_comment SET content = '".$content."' WHERE id = $id ";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_comment_edit);
  
  if($result){
    echo 'OK';
    exit;
  }else{
    echo $query_comment_edit;
    exit;
  }

?>