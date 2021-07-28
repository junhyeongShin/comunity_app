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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- CSS  -->
  <link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet">

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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>
  <script src="https://vjs.zencdn.net/7.2.3/video.js"></script>

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
    ajax_stream('<?php echo $SERVER_ADDRESS_PORT; ?>get_live_stream', 'GET');
    
  });
  
  const ajax_stream = (ajax_url, ajax_type, ajax_data_type) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      "id" : '<?php echo $_GET['id']?>'
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {

      console.log('성공 : ' + JSON.stringify(data));

      create_item(data);

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    };

  
    function create_item(data){


    console.log('create_item');
    console.log(data['player_hls_playback_url']);

    // var text = '';

    $("#view_title").append('방송 제목 : '+data['name']);

    $("#video_src").attr('src',data['player_hls_playback_url']);
    player = videojs('hls-player');
    player.play();
    is_starting = true;

    player.on('error',  evt => { 
      // code you want to happen when the video plays
      console.log(evt);

      if(player.error().code ==4){
        alert('아직 준비중인 방송입니다. 잠시후 다시 시도해 주세요.')
      }

    });



    // player.error()['code']==4

  }


  

  </script>

  <!-- JS code -->
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->

<nav id="navigation"></nav>
  
</head>

<body>

<div class="container" style ="margin-top:10%;">

        <div style ="margin-left:5%;">
          <h id="view_title"></h>
            <video id='hls-player' width="1000px" height="auto" class="video-js vjs-default-skin" controls autoplay>
              <source id="video_src" src="" type="application/x-mpegURL">
            </video>
        </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer id="footers">
  </footer>

</body>
</html>

<?php
 // include 'config.php';
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Us</title>

  <!-- Bootstrap core CSS -->
  <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom styles for this template -->
  <!-- <link href="css/shop-homepage.css" rel="stylesheet"> -->

  <!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <!-- CSS  -->
  <!-- <link href="https://vjs.zencdn.net/7.2.3/video-js.css" rel="stylesheet"> -->

  <!-- <style>
  #view_title{
    font-size:25px;
    font-family:"Noto Sans KR", sans-serif;
  }
  .vjs-modal-dialog-content{
    width:900px;
    height:600px;
  }
  
  </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.js"></script>
  <script src="https://vjs.zencdn.net/7.2.3/video.js"></script> -->

    <!-- Bootstrap core JavaScript -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">   

  var player ;
  var is_starting = false; 

  $(document).ready( function() {
  
    $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
    $("#footers").load("footer_info.html");   
    // $("#footers").load("common/footer.html");  // 추가 인클루드를 원할 경우 이런식으로 추가하면 된다
    ajax_stream('<?php // echo $SERVER_ADDRESS_PORT; ?>get_live_stream', 'GET');

  });

  const ajax_stream = (ajax_url, ajax_type, ajax_data_type) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      "id" : '<?php// echo $_GET['id']?>'
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {

      console.log('성공 : ' + JSON.stringify(data));

      create_item(data);

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    };

  function create_item(data){


    console.log('create_item');
    console.log(data['player_hls_playback_url']);

    // var text = '';

    $("#view_title").append('방송 제목 : '+data['name']);

    $("#video_src").attr('src',data['player_hls_playback_url']);
    player = videojs('hls-player');
    player.play();
    is_starting = true;

    player.on('error',  evt => { 
      // code you want to happen when the video plays
      console.log(evt);

      if(player.error().code ==4){
        alert('아직 준비중인 방송입니다. 잠시후 다시 시도해 주세요.')
      }
      
    });



    // player.error()['code']==4

  }


  

  </script> -->

  <!-- JS code -->
  <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->

<!-- <nav id="navigation"></nav>
  
</head>

<body>

<div class="container" style ="margin-top:10%;">

        <div style ="margin-left:5%;">
          <h id="view_title"></h>
            <video id='hls-player' width="1000px" height="auto" class="video-js vjs-default-skin" controls autoplay>
              <source id="video_src" src="" type="application/x-mpegURL">
            </video>
        </div>
    <!-- /.row -->

  <!-- </div>
  <!-- /.container -->

  <!-- Footer -->
  <!-- <footer id="footers">
  </footer>

</body>
</html> --> 