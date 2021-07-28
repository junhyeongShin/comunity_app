
<?php
 include 'config.php';
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

  <style>
  #view_title{
    font-size:25px;
    font-family:"Noto Sans KR", sans-serif;
  }
  .vjs-modal-dialog-content{
    width:900px;
    height:600px;
  }
  
  </style>

    <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">   

  var player ;
  var is_starting = false; 

  $(document).ready( function() {
  
    $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
    $("#footers").load("footer_info.html");   
    // $("#footers").load("common/footer.html");  // 추가 인클루드를 원할 경우 이런식으로 추가하면 된다

  });


  </script>

  <!-- JS code -->
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->

<nav id="navigation"></nav>
  
</head>

<body>

<div class="container" style ="margin-top:10%;">

        <div style ="margin-left:5%;">
          <h id="view_title"></h>
          <video class="vjs-modal-dialog-content" id="player" autoplay playsinline muted controls>
          </video>
        </div>
    <!-- /.row -->

  </div>
  <!-- /.container

  <!-- Footer -->
  <footer id="footers">
  </footer>
  
  <script type="text/javascript" src="//webrtchacks.github.io/adapter/adapter-latest.js"></script>
  <script src="//unpkg.com/wowzartcplayerjs@1.0.3/dist/WowzaWebRtcPlayer.browser.js"></script>

  <script>      
      (function () {
          var player = new WowzaRtc.WowzaWebRtcPlayer('player');
          player.start("<?php echo $_GET['sdp_url']; ?>","<?php echo $_GET['Aname']; ?>","<?php echo $_GET['Sname']; ?>");
          // player.start("wss://c97728.entrypoint.cloud.wowza.com/webrtc-session.json","app-6H56cr15","T294aWI2");
      })();
  </script>

</body>
</html> 