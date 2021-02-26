<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/Data/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

  // DB에서 입력받은 회원정보를 조회합니다.
  $query ="SELECT friend_list FROM user WHERE user.index = 1 ";

  echo $query;
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query);

  $row = mysqli_fetch_assoc($result);

  print_r($row);

  $string = implode(",",$row);

  print_r($string);

  $array = explode(',',$string);

  print_r($array);

  //검사하는 코드 시작

  // $test_array = array();

  // for($i=0;$i<count($array);$i++){
  //   print_r($array[$i]);

  //   if($array[$i]==8){
  //   array_push($test_array,$array[$i]);
  //   }

  // }
  // print_r($test_array);

  // print_r(implode(",",$test_array));

  // echo count($test_array);

    //검사하는 코드 종료



?>
