<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');


  //DB에서 유저의 친구 리스트를 조회하고
  //조회된 정보가 배열형식의 스트링일경우 배열로 변경해줍니다
  //배열로 된 친구 리스트를 
  //다시 DB에 조회합니다. 친구의 user 정보를 가져옵니다.
  //user + image 로 조인해서 조회된 정보를 클라이언트로 넘겨줍니다.

  $id = $_GET['id'];  
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_get_user_friend ="SELECT join_request_list FROM Clan WHERE id = $id ";
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result_get = $conn->query($query_get_user_friend);
  
      //배열값중 하나
      //조회된 친구 리스트를 배열로 변경합니다.
      $row_get = mysqli_fetch_assoc($result_get);

      if($row_get!=null){

      //배여을 파싱
      $string = implode(",",$row_get);
      
      //파싱한 스트링을 배열로 변환
      $array = explode(',',$string);


  $resultArray = array();

  for($i = 0;$i<count($array);$i++){

          // DB에서 입력받은 회원정보를 조회합니다.
          $query_comment_list ="SELECT * FROM user  join image on img_profile = image.id WHERE user.index =$array[$i]";
          //DB에 연결합니다.
          $result = $conn->query($query_comment_list); 
          $row = mysqli_fetch_assoc($result);
          if($row!=null){
            array_push($resultArray,
            array(
             'id' => $row['index'],
             'username' => $row['username'],
             'img_path' => $row['img_path'],
             'intro_profile' => $row['intro_profile'],
            ));
          }
  }

  if($result){
    echo json_encode($resultArray);
    exit;
  }else{
    echo json_encode($query_comment_list);
    exit;
  }
}else{
  echo '신청한 유저가 없습니다.';
}

?>