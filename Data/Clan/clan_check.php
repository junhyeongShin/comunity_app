<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require dirname(__FILE__,2).'/db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['id'];
// $user_id = $_POST['user_id'];
// $clan_id = $_POST['clan_id'];

$query_get_clan ="SELECT clan FROM user WHERE user.index = $user_id ";

  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_get_clan);

  $row_get_clan = mysqli_fetch_assoc($result);
   
  if(strlen($row_get_clan['clan'])!=0){
    echo 'true';
  }else{
    echo 'false';
  }


?>