<?php

//DB의 정보를 가져옵니다. 
require '/mnt/c/Users/82104/workplace/Data/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

 $ip = $_SERVER['REMOTE_ADDR'];
 
  // 컨텐츠 타입이 JSON 인지 확인한다
  if(!in_array('application/json',explode(';',$_SERVER['CONTENT_TYPE']))){
  echo json_encode(array('result_code' => '400'));
  exit;
  }else{
  
    $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
    // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고
  
    $postData = json_decode($__rawBody, true);
    // echo var_dump($postData);
    // exit;
  
    // echo var_dump($postData);
    // exit;
  
  
    $user_id = $postData['user_id'];  
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_user_check = " SELECT email from user where email = '$user_id'";
  // echo json_encode(array('$query_user_check' => '$query_user_check'));

  //db에 쿼리문 대입
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_user_check);
  $row=mysqli_fetch_assoc($result);

  // echo json_encode(array('mysqli_num_rows($row)' => mysqli_num_rows($row),'$query_user_check' => $query_user_check);
  //   return json_encode(array('mysqli_num_rows($row)' => mysqli_num_rows($row),'$query_user_check' => $query_user_check);
  if(isset($row)){
    //중복 있음 , 사용 불가능 ID
    echo json_encode(array('result_code' => '200','result_check' => 'NO'));

    }else if(!isset($row)){
      // echo ("<script>alert('없는 Email입니다.');    history.back();</script>");
    //중복 없음 , 사용 가능 ID

      echo json_encode(array('result_code' => '200','result_check' => 'OK'));

    }
    
}
?>