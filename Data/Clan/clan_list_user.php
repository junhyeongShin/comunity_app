<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');


 $id = $_GET['id'];  
  
 // DB에서 입력받은 회원정보를 조회합니다.
 $query_get_user_friend ="SELECT clan FROM user WHERE user.index = $id ";
 
 //DB에 연결합니다.
 $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
 mysqli_select_db($conn, $database);
 $result_get = $conn->query($query_get_user_friend);
 
     //배열값중 하나
     //조회된 친구 리스트를 배열로 변경합니다.
     $row_get = mysqli_fetch_assoc($result_get);

     //배여을 파싱
     $string = implode(",",$row_get);
     
     //파싱한 스트링을 배열로 변환
     $array = explode(',',$string);

    //  print_r($array);

     // echo count($array);

 // //DB에서 img_path를 받아 옵니다
 // $query_img_path ="SELECT img_path FROM image WHERE id = ".$row['id']." ";
 // $result_img = $conn->query($query_img_path);

 $resultArray = array();

 // echo $query_board_list;
 // $row_img = mysqli_fetch_assoc($result_img);

 for($i = 0;$i<count($array);$i++){

         // DB에서 입력받은 회원정보를 조회합니다.
         $query_get_clan ="SELECT Clan.id,title,img_path,clan_introduce,master,Clan.member_count,category FROM Clan  join image on clan_img = image.id WHERE Clan.id = $array[$i]";
     
         //DB에 연결합니다.
         $result = $conn->query($query_get_clan); 

         $row = mysqli_fetch_assoc($result);

         if($row!=null){

          array_push($resultArray,
          array(
           'id' => $row['id'],
           'title' => $row['title'],
           'img_path' => $row['img_path'],
           'category' => $row['category'],
           'clan_introduce' => $row['clan_introduce'],
           'member_count' => $row['member_count'],
           'master' => $row['master']
          ));

         }
         

   // echo $i;

 }

  if($result){
    echo json_encode($resultArray);
    exit;
  }else{
    echo json_encode($query_comment_list);
    exit;
  }

?>