<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');
 
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $from = $_POST['from'];
  $to = $_POST['to'];
  $content = $_POST['content'];
  $time = $_POST['time'];
  $from_id = $_POST['from_id'];
  $to_id = $_POST['to_id'];
  $type = $_POST['type'];

  // $user_id = $_GET['user_id'];
  // $clan_id = $_GET['clan_id'];

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

    $data = Array ("from" => $from,
                    "to" =>$to,
                    "content" =>$content,
                    "time" =>$time,
                    "from_id" =>$from_id,
                    "to_id" =>$to_id,
                    "type" =>$type,
                     );

      $id = $db->insert ('chat_message', $data);

      if($id)
      echo 'success';
      else{
      echo 'insert failed: ' . $db->getLastError();
      }


?>