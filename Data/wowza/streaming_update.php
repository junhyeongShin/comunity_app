<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');

  $name = $_GET['name'];

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

  $data = Array (
  	'title' => $name
  );

   //유저 id 조회하기
   $db->where ("id", $_GET['id']);

  $result = $db->update('streaming', $data);
  //DB에 유저 추가 성공시
  if($result)
{
    echo json_encode('success');
} 
  //DB에 유저 추가 실패시
  else{
    echo 'insert failed: ' . $db->getLastError();
  }


   

?>