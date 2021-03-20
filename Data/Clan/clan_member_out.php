<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require dirname(__FILE__,2).'/db_user_info.php';
require dirname(__FILE__,2).'/DB/db_class.php';

header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['user_id'];
$clan_id = $_GET['clan_id'];


$db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));


  $db->where('user_id', $user_id);
  $db->where('clan_id', $clan_id);

  if($db->delete('clan_member')){
    echo 'success';
  }  else{
    echo 'insert failed: ' . $db->getLastError();
  }








?>