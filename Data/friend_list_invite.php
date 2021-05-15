<?php


//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

 $user_id = $_GET['user_id'];
 $chat_id = $_GET['chat_id'];


  // DB에서 입력받은 회원정보를 조회합니다.
  $query_comment_list ='SELECT * From friends f
        LEFT JOIN user u on f.friend_id = u.`index`
        LEFT JOIN image i on i.id = u.img_profile
        WHERE user_id = '.$user_id.' and friend_id not in 
        (select chat_member.user_id from chat_member where chat_id = '.$chat_id.')';
  // $query_comment_list ="SELECT * FROM comment  ";
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_comment_list);


  $resultArray = array();

  // echo $query_board_list;
  // $row_img = mysqli_fetch_assoc($result_img);

  while($row = mysqli_fetch_assoc($result)){

    array_push($resultArray,
    array(
     'friend_id' => $row['index'],
     'username' => $row['username'],
     'img_path' => $row['img_path'],
     'intro_profile' => $row['intro_profile'],
    ));
}

  if($result){
    echo json_encode($resultArray);
    exit;
  }else{
    echo json_encode($query_comment_list);
    exit;
  }
?>