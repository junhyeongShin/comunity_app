<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $user_id = $_POST['user_id'];
  $clan_id = $_POST['clan_id'];

  // $user_id = $_GET['user_id'];
  // $clan_id = $_GET['clan_id'];

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

   $db->where('clan_id', $clan_id);
   $db->where('user_id', $user_id);

   $count = $db->getValue ("clan_join_list", "count(*)");

   $db = MysqliDb::getInstance();

   if( $count===0){
    $data = Array ("user_id" => $user_id,
                    "clan_id" =>$clan_id,
                     );

      $id = $db->insert ('clan_join_list', $data);

      if($id)
      echo 'success';
      else{
      echo 'insert failed: ' . $db->getLastError();
      }

   }else{
    echo 'already success';
   }


?>