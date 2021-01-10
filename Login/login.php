<?php
log_message('login.php : start');

// 회원가입 화면에서 입력받은 비밀번호를 가져옵니다
$user_passwd = $_POST['user_passwd'];
$user_id = $_POST['user_id'];

log_message('login.php user_passwd : '.$user_passwd);
log_message('login.php user_id : '.$user_id);


// 비밀번호를 암호화 합니다
$encrypted_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);
log_message('login.php user_passwd : password_hash');


// DB에서 입력받은 회원정보를 조회합니다.
$query = " SELECT user_id, user_pw from user where user_id = '$user_id'";
log_message('login.php $query :'.$query);

log_message('login.php : end');

?>