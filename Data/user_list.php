<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_comment_list ="SELECT * FROM user  join image on img_profile = image.id ";
  // $query_comment_list ="SELECT * FROM comment  ";

  // echo $query_comment_list;
  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_comment_list);


  // //DB에서 img_path를 받아 옵니다
  // $query_img_path ="SELECT img_path FROM image WHERE id = ".$row['id']." ";
  // $result_img = $conn->query($query_img_path);

  $resultArray = array();

  // echo $query_board_list;
  // $row_img = mysqli_fetch_assoc($result_img);


  while($row = mysqli_fetch_assoc($result)){

    array_push($resultArray,
    array(
     'id' => $row['index'],
     'username' => $row['username'],
     'img_path' => $row['img_path'],
     'intro_profile' => $row['intro_profile'],
    ));
}


// while($row_img = mysqli_fetch_assoc($result_img)){

//   array_push($resultArray,
//   array('img_path' => $row_img['img_path']));
// }


  if($result){
    echo json_encode($resultArray);
    exit;
  }else{
    echo json_encode($query_comment_list);
    exit;
  }

?>