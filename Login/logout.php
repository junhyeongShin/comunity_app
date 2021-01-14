<?php
 include 'session.php';
if(check_login()!=false){
  session_destroy();
  echo ("<script>alert('로그아웃 되었습니다.');    history.back();</script>");
}else{
  echo ("<script>alert('잘못된 접근 입니다.');    history.back();</script>");

}
?>