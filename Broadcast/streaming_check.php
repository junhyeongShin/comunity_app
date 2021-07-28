<?php
// 만들었던 스트리밍이 있으면 publish 페이지로
// 만들었던 스트리밍이 없으면 생성 페이지로

session_start();

if(!isset($_SESSION['userid'])){
  echo ("<script>alert('로그인이 되어있지 않습니다.');    location.href='login.php';</script>");
}


//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require dirname(__FILE__,2).'/Data/db_user_info.php';
require dirname(__FILE__,2).'/Data/DB/db_class.php';


// header('Content-Type: application/json; charset=UTF-8');

$user_id = $_SESSION['userid'];
// $user_id = $_POST['user_id'];
// $clan_id = $_POST['clan_id'];

$db = new MysqliDb (Array (
 'host' => $db_address,
 'username' => $db_userid, 
 'password' => $db_userpw,
 'db'=> $database,
 'port' => 3306,
 'charset' => 'utf8'));

 $db->where ("email", $user_id);
 $db_get = $db->get ("user");
 $index =  $db_get[0]['index'];

 $db->where ("user_id",  $index);
 $count = $db->get ("streaming");

  echo json_encode($count);


?>