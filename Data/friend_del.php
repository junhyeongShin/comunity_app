<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require dirname(__FILE__).'/db_user_info.php';
require dirname(__FILE__).'/DB/db_class.php';

$id = $_GET['id'];
$friend_id = $_GET['friend_id'];

$db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));

  $db->where('user_id', $id);
  $db->where('friend_id', $friend_id);

  if($db->delete('friends')){
    echo 'success';
  }  else{
    echo 'insert failed: ' . $db->getLastError();
  }

?>