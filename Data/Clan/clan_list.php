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

  $resultArray = array();

  $db->join("image i", "c.clan_img=i.id", "RIGHT");

  $products = $db->get ("Clan c", null,"c.id,c.master,i.img_path,c.member_count,c.clan_introduce,c.category,c.title");
  echo json_encode($products);

?>