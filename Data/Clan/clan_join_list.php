<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
require dirname(__FILE__,2).'/DB/db_class.php';

 
 header('Content-Type: application/json; charset=UTF-8');

  $id = $_GET['id'];  


  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));


   $array_result = array();


   $db->join("user u", "u.index=c.user_id", "LEFT");
   $db->join("image i", "u.img_profile=i.id", "LEFT");

   $db->where ('clan_id', $_GET['id']);
   $results = $db->get ("clan_join_list c", null,"u.username,i.img_path,u.intro_profile,u.index");

       echo json_encode($results);


?>