<?php

//DB의 정보를 가져옵니다. 
// require '/mnt/c/Users/82104/workplace/Data/db_user_info.php';
require dirname(__FILE__).'/db_user_info.php';

 
 header('Content-Type: application/json; charset=utf-8');
 
  // 컨텐츠 타입이 JSON 인지 확인한다
  if(!in_array('application/json',explode(';',$_SERVER['CONTENT_TYPE']))){
  echo json_encode(array('result_code' => '400'));
  exit;
  
  }else{
  
  $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  echo var_dump($__rawBody);

  $postData = json_decode($__rawBody, true);

  $user_index = $postData['user_index'];
  $title = $postData['title'];
  $category = $postData['category'];
  $content = $postData['content'];

  // $user_index = 10;
  // $title = 'title';
  // $category = 'category';
  // $content = 'content';
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_signup_check ="INSERT INTO board (writer,title,category,content,views,create_time)
  VALUES('".$user_index."','".$title."','".$category."','".$content."', 0, now())";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_signup_check);
  
  if($result){
    echo json_encode(array('result_code' => '200','result_check' => 'OK'));
    exit;
  }else{
    echo json_encode(array('result_code' => '200','result_check' => 'NO','$query_signup_check' => $query_signup_check));
    exit;
  }

}
?>