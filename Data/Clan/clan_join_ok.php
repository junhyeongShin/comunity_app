<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $user_id = $_GET['user_id'];
  $clan_id = $_GET['clan_id'];

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

  $data = Array ("user_id" => $user_id,
               "clan_id" =>$clan_id,
  );


  $id = $db->insert ('clan_member', $data);
  //DB에 유저 맴버 추가 성공시
  if($id)
{
  $db->where('user_id', $user_id);
  $db->where('clan_id', $clan_id);

  if($db->delete('clan_join_list')){
    echo 'success';
  }

} 
  //DB에 유저 맴버 추가 실패시

  else{
    echo 'insert failed: ' . $db->getLastError();
  }


   

?>