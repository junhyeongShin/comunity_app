<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__).'/db_user_info.php';
  require dirname(__FILE__).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');

  $user_id = $_GET['id'];
  $friend_id = $_GET['friend_id'];

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

  $data = Array ("user_id" => $user_id,
               "friend_id" =>$friend_id,
  );


  $id = $db->insert ('friends', $data);
  //DB에 유저 추가 성공시
  if($id)
{
    echo 'success';
} 
  //DB에 유저 추가 실패시
  else{
    echo 'insert failed: ' . $db->getLastError();
  }


   

?>