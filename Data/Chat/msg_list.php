<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
require dirname(__FILE__,2).'/DB/db_class.php';

 
 header('Content-Type: application/json; charset=UTF-8');

 $db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));

  $db->where ('chat_id', $_GET['id']);

  $products = $db->get ("messages", null);
  echo json_encode($products);

?>