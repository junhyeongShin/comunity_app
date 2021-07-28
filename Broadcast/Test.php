<?php
include 'config.php';

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Us</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script type="text/javascript">   
  $(document).ready( function() {
  
  $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
  $("#footers").load("footer_info.html");   
  // $("#footers").load("common/footer.html");  // 추가 인클루드를 원할 경우 이런식으로 추가하면 된다
  
  });
  

  </script>

<script src="/Broadcast/socket.io/client-dist/socket.io.js"></script>


  <script>
  const socket = io('http://localhost.com:3000');
  socket.emit('send message', $('#name').val(), $('#message').val());
        $('#message').val('');
        $('#message').focus();
  
  </script>

  <script>


  </script>

<nav id="navigation"></nav>
  

</head>

<body>
 
  <div class="container" style ="margin-top:2%">


  <input type="text" name="input_text" id="chat_input"/>

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer id="footers">
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
