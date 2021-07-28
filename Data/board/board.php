<?php

require dirname(__FILE__,2).'/db_user_info.php';

 header('Content-Type: application/json; charset=utf-8');

 $id = $_GET['id'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_board ="SELECT * from board left join user u on u.index= writer 
                  left join image i on u.img_profile = i.id 
                  where board.id =".$id;

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_board);

    // echo $query_re_comment_list;

    $resultArray = array();

    // echo $query_board_list;

    while($row = mysqli_fetch_assoc($result)){
      array_push($resultArray,
      array(
       'id' => $row['id'],
       'user_id' => $row['index'],
       'content' => $row['content'],
       'create_time' => $row['create_time'],
       'title' => $row['title'],
       'user_name' => $row['username'],
       'category' => $row['category'],
       'user_email' => $row['email'],
       'user_img' => $row['img_path']
      ));
    }
    // $row = mysqli_fetch_assoc($result);
    // print_r($row);
    
    if($result){
      echo json_encode ($resultArray);
    }else{
      echo json_encode(array('result_code' => '200','result_check' => 'NO','$query_board_list' => $query_board_list));
    }
?>