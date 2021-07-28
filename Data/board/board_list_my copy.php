<?php

require dirname(__FILE__,2).'/db_user_info.php';

 header('Content-Type: application/json; charset=utf-8');

 $user_id = $_GET['user_id'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_board_list ="SELECT board.id, title, content, writer, views, board.create_time, category, user.email, user.username, user.img_profile, user.intro_profile
  from board join user on `writer` WHERE writer = user.index AND writer = '".$user_id."' ORDER BY board.id DESC ";
  

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_board_list);

    // echo $query_board_list;

    $resultArray = array();

    // echo $query_board_list;

    while($row = mysqli_fetch_assoc($result)){
      array_push($resultArray,
      array(
       'id' => $row['id'],
       'writer' => $row['writer'],
       'email' => $row['email'],
       'title' => $row['title'],
       'content' => $row['content'],
       'username' => $row['username'],
       'img_profile' => $row['img_profile'],
       'intro_profile' => $row['intro_profile'],
       'create_time' => $row['create_time'],
       'views' => $row['views'],
       'category' => $row['category']));
    }
    
    if($result){
      echo json_encode ($resultArray);
      // echo json_encode(array('result_code' => '200','result_check' => 'OK','result_list'=>$resultArray));
    }else{
      echo json_encode(array('result_code' => '200','result_check' => 'NO','$query_board_list' => $query_board_list));
    }


?>