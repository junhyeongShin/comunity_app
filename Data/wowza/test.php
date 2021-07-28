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
  
    $db->where ('user_id', $_GET['id']);
   
  
    $db->join("user u", "u.index=friend_id", "LEFT");
    $db->join("image i", "i.id = u.img_profile","LEFT");
    
  
    $products = $db->get ("friends", null);
    echo json_encode($products);

?>