<?php
include 'session.php';
include 'config.php';

if(isset($_SESSION['userid'])){
  echo ("<script>alert('이미 로그인이 되어있습니다.');    history.back();</script>");
}
?>

<!DOCTYPE html>
<html>
  
<!-- 페이지 상단 탭  -->
<title>Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Shop Homepage - Start Bootstrap Template</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">   
  $(document).ready( function() {
  
  $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
  $("#footers").load("footer_info.html");   
  
  });
  </script>



<body>
<nav id="navigation"></nav>

<!------ Include the above in your HEAD tag ---------->
<form action="logincheck.php" method="post" class="form-horizontal" >
<div style="margin-left:30%; margin-top:5%">

<div class="col-md-4" alt="logo">
  <img src="<?php echo $SERVER_ADDRESS; ?>img/42935632-방송-아이콘.jpg" class="card-img-top" style="margin-left:30%;">
</div>


<fieldset>  

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-6 control-label" for="ID">아이디</label>  
      <div class="col-md-6">
      <input name="login_email" id="inputEmail" class="form-control" placeholder="ID" required autofocus>

      </div>
    </div>


    <div class="form-group">
      <label class="col-md-6 control-label" for="ID">비밀번호</label>  
      <div class="col-md-6">
      <input name="login_pw" type="password" id="inputPassword" class="form-control" placeholder="Password" required>

      </div>
    </div>


  <!-- 회원가입 버튼 -->
  <div class="col-md-6">
    <a href="<?php echo $SERVER_ADDRESS; ?>signup1.php"" class="w3-button w3-blue">회원가입</a>
    <input style="float:right;" type="submit" class="w3-button w3-blue" value="로그인">  

  </div>
</div>
</form>
  <!-- Footer -->
  <footer id="footers">
  </footer>

</body>
</html>
</fieldset>
