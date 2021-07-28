<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/db_user_info.php';
require dirname(__FILE__).'/DB/db_class.php';

header('Content-Type: application/json; charset=UTF-8');

$user_id = $_GET['id'];
// $user_id = $_POST['user_id'];
// $clan_id = $_POST['clan_id'];

$db = new MysqliDb (Array (
 'host' => $db_address,
 'username' => $db_userid, 
 'password' => $db_userpw,
 'db'=> $database,
 'port' => 3306,
 'charset' => 'utf8'));

 $db->where ("user_id", $user_id);
 $count = $db->getValue ("clan_member", "count(*)");

  if($count>0)
  echo 'true';
  else
  echo 'false';

?>