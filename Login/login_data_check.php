<?php

//DB의 정보를 가져옵니다. 
require '/mnt/c/Users/82104/workplace/Data/db_user_info.php';

// 회원가입 화면에서 입력받은 비밀번호를 가져옵니다
if(isset($_POST['user_id']))
{
  echo 'Login fail';
  // echo ("<script>alert('잘못된 접근입니다.');    history.back();</script>");
}else{
  $user_passwd = $_POST['user_passwd'];
  $user_id = $_POST['user_id'];
  
  
  // 비밀번호를 암호화 합니다
  $encrypted_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);
  
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_user_check = " SELECT email, user_pw from user where email = '$user_id'";
  
  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_user_check);
  $row=mysqli_fetch_assoc($result);

  echo 
  
  // if(mysqli_num_rows($result)==1 & $_POST['login_pw']===$row['password']){
  //   echo 'success';
  
  //   }else if(mysqli_num_rows($result)==0){
  //       echo 'Login fail';
  //     echo ("<script>alert('없는 Email입니다.');    history.back();</script>");
  //   }
  //   else{
  //     echo 'Login fail';
  //     echo ("<script>alert('비밀번호가 틀렸습니다.');    history.back();</script>");
  //   }
    
}
?>