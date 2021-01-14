
<?php
log_message('login.php : start');

//DB의 정보를 가져옵니다. 
require 'localhost/Data/db_user_info.php'

// 회원가입 화면에서 입력받은 비밀번호를 가져옵니다
$user_passwd = $_POST['user_passwd'];
$user_id = $_POST['user_id'];

log_message('login.php user_passwd : '.$user_passwd);
log_message('login.php user_id : '.$user_id);

// 비밀번호를 암호화 합니다
$encrypted_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);
log_message('login.php user_passwd : password_hash');


// DB에서 입력받은 회원정보를 조회합니다.
$query_user_check = " SELECT user_id, user_pw from user where user_id = '$user_id'";
log_message('login.php $query :'.$query_user_check);

log_message('login.php : end');

//db에 쿼리문 대입

//DB에 연결합니다.
$conn = mysqli_connect($db_address, $db_userid, $db_userpw);
mysqli_select_db($conn, $database);
$result = $conn->query($query_user_check);
$row=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result)==1 & $_POST['login_pw']===$row['password']){
  echo 'success';

  }else if(mysqli_num_rows($result)==0){
      echo 'Login fail';
    echo ("<script>alert('없는 Email입니다.');    history.back();</script>");
  }
  else{
    echo 'Login fail';
    echo ("<script>alert('비밀번호가 틀렸습니다.');    history.back();</script>");
  }

?>