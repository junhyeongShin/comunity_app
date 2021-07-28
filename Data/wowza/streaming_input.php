<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
  require dirname(__FILE__,2).'/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');

  $user_id = $_POST['user_id'];
  $id = $_POST['id'];
  // $img = $_POST['img'] ;
  $play_hls = $_POST['play_hls'];
  $sdp_url = $_POST['sdp_url'] ;
  $Aname = $_POST['Aname'] ;
  $Sname = $_POST['Sname'] ;
  $title = $_POST['title'] ;
  // $create_time = $_POST['create_time'] ;
  // $update_time = $_POST['update_time'] ;
  // $is_del = $_POST['is_del'] ;
  // $viewer = $_POST['viewer'] ;
  // $category = $_POST['category'] ;

  $db = new MysqliDb (Array (
   'host' => $db_address,
   'username' => $db_userid, 
   'password' => $db_userpw,
   'db'=> $database,
   'port' => 3306,
   'charset' => 'utf8'));

   //유저 id 조회하기
   $db->where ("email", $user_id);
   $db_get = $db->get ("user");
   $index =  $db_get[0]['index'];


  $data = Array ("id" => $id,
                 "user_id" =>$index,
                 "sdp_url" =>$sdp_url,
                 "play_hls" =>$play_hls,
                 "Aname" =>$Aname,
                 "Sname" =>$Sname,
                 "title" =>$title
                //  "create_time" =>$create_time
  );


  $result = $db->insert ('streaming', $data);
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