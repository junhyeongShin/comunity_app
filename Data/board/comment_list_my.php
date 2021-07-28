<?php

require dirname(__FILE__,2).'/db_user_info.php';

 header('Content-Type: application/json; charset=utf-8');

 $user_id = $_GET['user_id'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_re_comment_list ="SELECT c.board_id,r.content,r.create_time,r.id,r.user_id,b.title,r.is_recomment
                          from re_comment r
                          join comment c on r.comment_id = c.id
                          left join board b on board_id = b.id
                          WHERE r.user_id = ".$user_id."
                          UNION 
                          (select board_id,c.content,c.create_time,c.id,user_id,b.title,c.is_recomment
                          from comment c
                          left join board b on board_id = b.id
                          where user_id = ".$user_id." )ORDER BY create_time DESC;";
  

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_re_comment_list);

    // echo $query_re_comment_list;

    $resultArray = array();

    // echo $query_board_list;

    while($row = mysqli_fetch_assoc($result)){
      array_push($resultArray,
      array(
       'id' => $row['id'],
       'user_id' => $row['user_id'],
       'content' => $row['content'],
       'title' => $row['title'],
       'create_time' => $row['create_time'],
       'is_recomment' => $row['is_recomment'],
       'board_id' => $row['board_id']));
    }
    
    if($result){
      echo json_encode ($resultArray);
    }else{
      echo json_encode(array('result_code' => '200','result_check' => 'NO','$query_board_list' => $query_board_list));
    }
?>