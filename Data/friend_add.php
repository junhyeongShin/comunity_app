<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require './db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');

$id = $_GET['id'];
$fiend_id = $_GET['friend_id'];

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_get_user_friend ="SELECT friend_list FROM user WHERE user.index = $id ";

  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_get_user_friend);

  //조회된 친구 리스트를 배열로 변경합니다.
  //배열값중 하나
  $row = mysqli_fetch_assoc($result);

  //배여을 파싱
  $string = implode(",",$row);

  //파싱한 스트링을 배열로 변환
  $array = explode(',',$string);


  // 검사하는 코드 시작

  $test_array = array();

  for($i=0;$i<count($array);$i++){
    if($array[$i]==$fiend_id){
    array_push($test_array,$array[$i]);
    }
  }

    // 검사하는 코드 종료
    //이미 목록에 있을경우
    if(count($test_array)>0){
      echo '이미 목록에 있을경우';
      exit;
    }
    //없을경우
    else{
      echo '목록에 없을경우';
    
      if(strlen($string)===0){
        $update = $fiend_id;
      }else{
        $update = $string.','.$fiend_id;
      }
      $query_update_friend ="UPDATE user SET friend_list = '$update' WHERE user.index = $id ";

        //DB에 연결합니다.
      $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
      mysqli_select_db($conn, $database);
      $result = $conn->query($query_update_friend);

      if($result){
        echo 'success';

      }else{
        echo $query_update_friend;
      }

    }

  

?>