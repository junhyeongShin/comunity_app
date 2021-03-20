<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
require dirname(__FILE__,2).'/DB/db_class.php';

 
 header('Content-Type: application/json; charset=UTF-8');
 

 $clan_id = $_GET['clan_id'];

 $db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));


  $db->where('id', $clan_id);

  if($db->delete('Clan')){

    $db->where('clan_id', $clan_id);

    if($db->delete('clan_member')){
      $db->where('clan_id', $clan_id);

      if($db->delete('clan_join_list')){
        echo 'success';
      }
    }
  }


      
      
      

?>