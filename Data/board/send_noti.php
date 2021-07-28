<?php

  require dirname(__FILE__,2).'/db_user_info.php';

  header('Content-Type: application/json; charset=utf-8');
  $user_id = $_GET['user_id'];
  $board_id = $_GET['board_id'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_board_noti ="SELECT board.id, title, user.username, user.img_profile, user.token
                      from board join user on `writer` WHERE writer = user.index 
                      AND board.id = '".$board_id."' limit 1 ";

  $query_user ="SELECT * from user u left join image i on i.id = u.img_profile 
                      where `index`=".$user_id ;
  

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result_board = $conn->query($query_board_noti);
    $result_user = $conn->query($query_user);

    // echo $query_board_list;

    $resultArray = array();

    // echo $query_board_list;

    $row_board = mysqli_fetch_assoc($result_board);
    $row_user = mysqli_fetch_assoc($result_user);

      //  'id' => $row['id'],
      //  'username' => $row['username'],
      //  'token' => $row['token'],
      //  'img_profile' => $row['img_profile']

    $title ="US 알림";

    $msg = $row_user['username']."님 께서 ".$row_board['title']."에 댓글을 등록하셨습니다.";

    $array = array('msg'=>$msg,'board_id'=>$row_board['id']);

    $body = json_encode($array);

    
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");
    $header = array("Content-Type:application/json", "Authorization:key=AAAAAcZ6RBo:APA91bFCl_NT_6hi1w9Zk-KrbwZ4r-t1KnXTgTYBoA41rO4YwfZiQwXqq4csckOkIAMw6HR3Up5sLzyKfXgfam7IfOWG5WYXAwfu57UoOiIdJB1JhsZCNy56fEDm_pl2hB_EZ9qB9MXI");
    $data = json_encode(array(
      "to" => $row_board['token'],
      "notification" => array(
        "title"   => $title,
        "message" => $body)
      ));

      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_exec($ch);


      $array_result = array('result'=>'OK','board_id'=>$row_board['id'],'token'=>$row_board['token']);
      echo json_encode($array_result);

  
?>
