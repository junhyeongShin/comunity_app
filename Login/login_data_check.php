<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/Data/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
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
  $user_passwd = $postData['user_passwd'];
  $password_check = 'NO' ;
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_user_check = " SELECT * from user where email = '$user_id'";
  
  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_user_check);
  $row=mysqli_fetch_assoc($result);  

  if(password_verify($user_passwd, $row['user_pw'])){
    $password_check = 'OK';
  }

  if(!isset($row['user_pw'])){
    echo json_encode(array('result_code' => '200','result_check' => 'E_pw'));
  }else{

  if(mysqli_num_rows($result)==1 & $password_check==='OK'){
    

    //로그인 성공 세션 시작, 성공 반환.
    session_start();
    $_SESSION['userid'] = $user_id;
    // echo 'success';
    // header('localhost/home/index.html');

    echo json_encode(array('result_code' => '200','result_check' => 'OK','result_data'=>$row));

  
    }else if(mysqli_num_rows($result)==0){
        echo json_encode(array('result_code' => '200','result_check' => 'E_id'));
    }
    else{
      echo json_encode(array('result_code' => '200','result_check' => 'E_pw'));
    }
  }
    
}
?>