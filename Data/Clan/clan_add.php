<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $master = $_POST['user_id'];
  $clan_name = $_POST['clan_name'];
  $clan_intro = $_POST['clan_intro'];
  $clan_img = $_POST['clan_img'];

  // $master = $_GET['user_id'];
  // $clan_name = $_GET['clan_name'];
  // $clan_intro = $_GET['clan_intro'];
  // $clan_img = $_GET['clan_img'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_clan_add ="INSERT INTO Clan (master,title,clan_introduce,clan_img,create_time)
  VALUES(
  $master,
  '".$clan_name."',
  '".$clan_intro."',
  $clan_img,
  now())";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_clan_add);
  
  if($result){
    echo $result;
    exit;
  }else{
    echo $query_clan_add;
    exit;
  }

?>