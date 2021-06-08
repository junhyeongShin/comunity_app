<?php
//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/Data/db_user_info.php';
  

  $user_id = $_POST['login_email'];
  $user_passwd = $_POST['login_pw'];
  $password_check = 'NO' ;

  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_user_check = " SELECT * from user u LEFT JOIN image i on i.id = u.img_profile where email = '$user_id'";
  
  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_user_check);
  $row=mysqli_fetch_assoc($result);  


  $hash = password_hash('1111', PASSWORD_BCRYPT);

  if(password_verify($user_passwd,$hash)){
    $password_check = 'OK';
    echo 'password_check = OK';
  }


  if(!isset($row['user_pw'])){
    echo json_encode(array('result_code' => '200','result_check' => 'E_pw'));
  }else{

  if(mysqli_num_rows($result)==1 & $password_check==='OK'){
    

    //로그인 성공 세션 시작, 성공 반환.
    session_start();
    $_SESSION['userid'] = $user_id;
    $_SESSION['user_img'] = $row['img_path'];

    // echo 'success';
    // header('localhost/home/index.html');

    echo json_encode(array('result_code' => '200','result_check' => 'OK','result_data'=>$row));

    header("location: /Broadcast");

    }else if(mysqli_num_rows($result)==0){
        echo json_encode(array('result_code' => '200','result_check' => 'E_id'));
    }
    else{
      echo json_encode(array('result_code' => '200','result_check' => 'E_pw'));
    }
  }
    

  
?>