<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

 $comment_id = $_GET['comment_id'];

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_comment_list ="SELECT * FROM re_comment join user on user_id = user.index WHERE comment_id = $comment_id ORDER BY id";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_comment_list);

  $resultArray = array();

  // echo $query_comment_list;

  // echo $query_board_list;

  while($row = mysqli_fetch_assoc($result)){
    array_push($resultArray,
    array(
     'id' => $row['id'],
     'content' => $row['content'],
     'comment_id' => $row['comment_id'],
     'user_id' => $row['user_id'],
     'username' => $row['username']));
}
  
  if($result){
    echo json_encode($resultArray);
    exit;
  }else{

    echo json_encode($query_comment_list);
    exit;
  }

?>