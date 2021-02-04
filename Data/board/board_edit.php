<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  $id = $_GET['id'];
  $category = $_GET['category'];
  $content = $_GET['content'];
  $title = $_GET['title'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_update ="UPDATE board SET category = '".$category."', title = '".$title."', content = '".$content."' WHERE id = $id ";
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_update);
  
  if($result){
    echo json_encode($result);
    exit;
  }else{
    echo json_encode($result);
    exit;
  }

?>