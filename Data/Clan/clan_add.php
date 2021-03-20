<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

  $master = $_POST['user_id'];
  $clan_name = $_POST['clan_name'];
  $clan_intro = $_POST['clan_intro'];
  $clan_img = $_POST['clan_img'];
  $clan_category = $_POST['clan_category'];


  // $master = $_GET['user_id'];
  // $clan_name = $_GET['clan_name'];
  // $clan_intro = $_GET['clan_intro'];
  // $clan_img = $_GET['clan_img'];
  // $clan_category = $_GET['clan_category'];

  $now = date_create('now')->format('Y-m-d H:i:s');

  $data = Array ("master" => $master,
               "title" =>$clan_name,
               "clan_introduce" => $clan_intro,
               "category" => $clan_category,
               "clan_img" => $clan_img,
               "create_time" =>  $now
  );
  $id = $db->insert ('Clan', $data);
  if($id)
    echo 'user was created. Id =' . $id;
  else{
    echo 'insert failed: ' . $db->getLastError();
  }


    $clan_id = $id;


    $data_member = Array ("clan_id" => $clan_id,
                 "user_id" => $master,
                 "master" => 1
    );
    $id_member = $db->insert ('clan_member', $data_member);
    if($id_member)
      echo 'user was created. Id=' . $id_member;
    else
    echo 'insert failed: ' . $db->getLastError();


?>