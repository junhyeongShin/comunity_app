<?php
include 'session.php';
include 'config.php';

if(!isset($_SESSION['userid'])){
  echo ("<script>alert('로그인이 되어있지 않습니다.');    location.href='login.php';</script>");
}

if(!isset($_POST['id'])){
  echo ("<script>alert('잘못된 접근 입니다.');    location.href='index.php';</script>");
}

?>

<!DOCTYPE html>
<!--
 *  Copyright (c) 2018 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
-->
<html>
<head>

  <meta charset="utf-8">
  <meta name="description" content="WebRTC BroadCast">
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1, maximum-scale=1">
  <meta itemprop="description" content="WebRTC BroadCast">
  <meta itemprop="name" content="WebRTC BroadCast">
  <meta name="mobile-web-app-capable" content="yes">
  <meta id="theme-color" name="theme-color" content="#ffffff">
  <base target="_blank">

  <title>LiveStreaming</title>

  <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
  <link href="./css/css.css" rel="stylesheet" type="text/css">
  
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">
  
  <style>
    #streaming_container{
      max-width: 1300px;
      height:600px;
      margin:auto;
      margin-top:2%;
      margin-bottom:2%;
      position: relative;
    }
    .right{
      text-align:right;
    }
    .left{
      text-align:left;
    }
    body{
      margin-top:5%;
    }
    #streaming_title{
      font-size:20px;
      font-family:"Noto Sans KR", AppleSDGothicNeo-Regular, "Malgun Gothic", "맑은 고딕", dotum, 돋움, sans-serif;
    }
    .container{
      text-align:center;
    }

    .center{
      text-align:center;
    }

    .modal_setting{ 
      position:absolute; 
      width:100%; 
      height: 100vh; 
        /*  모달창 뒤에 회색배경 */
      background: rgba(0,0,0,0.8); 
      top:0; left:0; display:none;
    }

    .modal_setting_content{
      width:1000px; height:560px;
      border-radius:10px;
      position:relative; 
      /* top:50%;  */
      left:50%;
      text-align:center;
      /* margin-top:-100px;  */
      margin-left:-500px;
      margin-top:200px;
      /* box-sizing:border-box;  */
      padding:74px 0;
      line-height:23px; 
    }
    #broad_cast{
      cursor: pointer;
    }
    #setting_title{
      width: 600px;
      font-size: 25px;
    }
    #btn_title_update{
      height: 50px;
      width: 600px;
      font-size: 25px;

    }
    #setting_title_text{
      font-size: 25px;
    }
    #publish-video{
      width:1200px;
      height:650px;
    }
    .dropbtn {
      background-color: #007bff;
      color: white;
      padding: 8px;
      padding-left: 25px;
      padding-right: 25px;
      font-size: 16px;
      border: none;
      border-radius: .25rem;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #007bff;
      min-width: 130px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {background-color: #ddd;}

    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: #007bff;}

    #camButton,#startButton{
      width: 100%;
    }
    #canvas{
      position: absolute ;
    }
    #publish-video{
      position: absolute ;
    }

  </style>

  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- 마스크 -->
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-core"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs-converter"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/blazeface"></script>


  <script type="text/javascript">   
  var web_url_for_model ="<?php echo $SERVER_ADDRESS; ?>" ;

  $(document).ready( function() {
  
  $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
  $("#footers").load("footer_info.html");   
  // $("#footers").load("common/footer.html");  // 추가 인클루드를 원할 경우 이런식으로 추가하면 된다
  });


  </script>

</head>
<nav id="navigation"></nav>
<body>
  <div class="center" id="loading_item" >  
    <img id="publish_top_img" src="./loading_ani.gif" style="width:100px; height:auto;">
    <p id="publish_top_text1"><strong>서버와 연결중 입니다.</strong></p>
    <p id="publish_top_text2"><strong>연결이 완료되면 방송 송출이 가능해 집니다.</strong></p>
  </div>
  <!-- 상단 -->
  <div class="left " style="margin-left:5%; max-width:1200px; margin:auto;">
      <div class="right">
        <!-- 방송 환경설정 (방송이름 변경)-->
        <div class="dropdown">
          <button class="dropbtn ">화면 선택 하기</button>
            <div class="dropdown-content">
              <button  type="button" id="camButton" class="btn btn-primary" >카 메 라</button>
              <button  type="button" id="startButton" class="btn btn-primary" >화 면 공 유</button>
            </div>
        </div>
        <button  type="button" id="mask_btn" class="btn btn-primary" >마스크 확인</button>
        <button  type="button" id="sendButton" class="btn btn-primary" disabled >방송 송출 하기</button>
        <button  type="button" id="closeButton" class="btn btn-primary" disabled >방송 끊기</button>
        <button type="button" id="update_setting" onclick="setting()" class="btn btn-primary" >방송 설정 변경</button>
      </div>
    <!-- 방송 제목 -->
    <p id="streaming_title"> 방송 제목 :  <?php echo $_POST['name']; ?>  </p>
  </div>
    <!-- 방송 시작하기 버튼 -->
    <!-- <div class="right" style="max-width:1200px; margin:auto;"> -->
    <!-- <button  type="button" id="sendButton" class="btn btn-primary" disabled >방송 송출 하기</button> -->
  <!-- </div> -->

  <div id="streaming_container">
    <video style="float:left" id="publish-video" autoplay playsinline muted></video>
    <canvas style="float:left" id="canvas" width="1200" height="650"></canvas>
    
  </div>

  <!-- 화면 선택하기 버튼 -->


  <script type="text/javascript">

    var sdp_url = <?php echo $_POST['sdp_url']; ?>;
    var application_name = <?php echo $_POST['application_name']; ?>;
    var stream_name = <?php echo $_POST['stream_name']; ?>;
    var id = "<?php echo $_POST['id']; ?>";
    var name = "<?php echo $_POST['name']; ?>";
    // var created_at = "<?php // echo $_POST['created_at']; ?>";
    var is_starting = true;
    var stream_info = {};


    console.log('sdp_url',sdp_url);
    console.log('application_name',application_name);
    console.log('stream_name',stream_name);
    console.log('id',id);
    console.log('name',name);
    // console.log('created_at',created_at);

    const ajax_start = (ajax_url, ajax_type, ajax_data_type) => {
      $.ajax({
      
      // 요청을 보낼 URL
      url: ajax_url,
      
      // HTTP 요청 방식 (GET, POST)
      type: ajax_type,
      
      // HTTP 요청과 함께 서버로 보낼 데이터
      data: {
        'id':id
      },
      headers: {
        "Access-Control-Allow-Origin" : '*',
        'Access-Control-Allow-Headers' : '*'
      },
      // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
      dataType: ajax_data_type,
      })
      .done(function (data) {
        console.log('ajax_start 성공 : ' + JSON.stringify(data));
        check_state();
      })
      .fail((data) => {
        console.log('실패 : ' + JSON.stringify(data));
      })
      .always((data) => {
        console.log('종료되었습니다.');
      });
    };

    const ajax_state = (ajax_url, ajax_type, ajax_data_type) => {
      console.log('ajax_state');
      console.log('is_starting : ',is_starting);
      $.ajax({
      
      // 요청을 보낼 URL
      url: ajax_url,
      
      // HTTP 요청 방식 (GET, POST)
      type: ajax_type,
      
      // HTTP 요청과 함께 서버로 보낼 데이터
      data: {
        'id':id
      },
      headers: {
        "Access-Control-Allow-Origin" : '*',
        'Access-Control-Allow-Headers' : '*'
      },
      // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
      dataType: ajax_data_type,
      })
      .done(function (data) {
        console.log(' ajax_state 성공 : ' + JSON.stringify(data));
        //방송 시작 중 이니 5초마다 방송이 실행되었는지 확인한 후 알려줌.
        
        if((data["live_stream"]["state"])=='started'){
          is_starting=false;
          console.log('is_starting',is_starting)
          console.log('방송 연결 완료!')
          start();
        }else{
          check_state();
        }
      
      })
      .fail((data) => {
        console.log('실패 : ' + JSON.stringify(data));
      })
      .always((data) => {
        console.log('종료되었습니다.');
      });
    };

  const ajax_update_title = (ajax_url, ajax_type, ajax_data_type,text) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'id':id,
      'name':text
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {
      console.log('ajax_update 성공 : ' + JSON.stringify(data));
      ajax_update_title_db('<?php echo $SERVER_ADDRESS_DB; ?>wowza/streaming_update.php', 'GET', 'json',text)
      // document.getElementById('setting_title').value = text
      // document.getElementById('streaming_title').innerHTML = text

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
    };

  const ajax_update_title_db = (ajax_url, ajax_type, ajax_data_type,text) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'id':id,
      'name':text
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {

      console.log('ajax_update_db 성공 : ' + JSON.stringify(data));
      document.getElementById('setting_title').value = text
      document.getElementById('streaming_title').innerHTML = '방송 제목 : '+text

      $(".modal_setting").fadeOut();

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
    };

    const ajax_update_img_db = (ajax_url, ajax_type, ajax_data_type,img) => {
      $.ajax({
      
      // 요청을 보낼 URL
      url: ajax_url,
      
      // HTTP 요청 방식 (GET, POST)
      type: ajax_type,
      
      // HTTP 요청과 함께 서버로 보낼 데이터
      data: {
        'id':id,
        'img':img
      },
      headers: {
        "Access-Control-Allow-Origin" : '*',
        'Access-Control-Allow-Headers' : '*'
      },
      // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
      dataType: ajax_data_type,
      })
      .done(function (data) {

      console.log('ajax_update_db_img 성공 : ' + JSON.stringify(data));

      })
      .fail((data) => {
        console.log('실패 : ' + JSON.stringify(data));
      })
      .always((data) => {
        console.log('종료되었습니다.');
      });
    };

  const ajax_update_stream_db = (ajax_url, ajax_type, ajax_data_type,text) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'id':id,
      'name':text
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {

      console.log('ajax_update_db_img 성공 : ' + JSON.stringify(data));

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
    };

  const ajax_get_img = (ajax_url, ajax_type, ajax_data_type) => {
      $.ajax({
      
      // 요청을 보낼 URL
      url: ajax_url,
      
      // HTTP 요청 방식 (GET, POST)
      type: ajax_type,
      
      // HTTP 요청과 함께 서버로 보낼 데이터
      data : {
        'id':id
      },
      headers: {
        "Access-Control-Allow-Origin" : '*',
        'Access-Control-Allow-Headers' : '*'
      },
      // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
      dataType: 'text',
      })
      .done(function (data) {
        console.log('썸네일 이미지 수신 성공 : ' + JSON.stringify(data));
        // console.log(data);
        ajax_update_img_db('<?php echo $SERVER_ADDRESS_DB; ?>wowza/streaming_update_img.php', 'GET', 'json',data)

      
      })
      .fail((data) => {

        console.log('실패 : ' + JSON.stringify(data));

      })
    };

  const ajax_get_stream = (ajax_url, ajax_type, ajax_data_type) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      "id" : id
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
      stream_info = data;
      console.log(stream_info);
      // update db stream

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    };

  function check_state(){

    if(is_starting){

      setTimeout(function(){
        ajax_state('<?php echo $SERVER_ADDRESS_PORT; ?>state_live_streaming', 'GET', 'json')
      }, 5000);

    }

    }

  function setting(){
    console.log('update_setting click');
    $('.modal_setting').fadeIn();
    }

  function start(){

    console.log('start funtion');
    $('#publish_top_img').attr('src','./img_live_ready.GIF');
    $('#publish_top_text1').remove();
    $('#publish_top_text2').remove();

    $('#sendButton').attr('disabled',false);
    $('#closeButton').attr('disabled',false);

    ajax_get_img('<?php echo $SERVER_ADDRESS_PORT; ?>get_thumbnail', 'GET', 'json');
    // 스트림의 정보 + 썸네일 가져와서 stream_info 추가하기

    }

  function update_title(){
    console.log('update_title')
    
    text = document.getElementById('setting_title').value
    
    console.log('text',text)

    if(text===''){
      alert('제목을 입력하세요.')
    }else{
      // 서버로 변경 요청
      console.log('send update')
      ajax_update_title('<?php echo $SERVER_ADDRESS_PORT; ?>update_live_stream', 'GET', 'json',text)

    }

    }

  function update_stream(data){

      // 서버로 변경 요청
      console.log('send update')
      ajax_update_title('<?php echo $SERVER_ADDRESS_PORT; ?>update_live_stream', 'GET', 'json',text)

    }


  $(function(){ 

    var modal_content = $(this).find(".modal_setting_content");
    var modal = $(this).find(".modal_setting");
    var btn_close = $(this).find(".btn_close");

    // 버튼을 클릭하면 모달창이 생성되게끔

    // $("#broad_cast").click(function(){
    //   $(".modal").fadeIn();
    // });

    //모달내부나 모달 밖을 클릭하였을때 사라지게 하는 코드
    // 여기서는 로딩이 완료되면 페이지가 이동되니 필요없음.
    //  $(".modal_content_setting").click(function(){
    //    $(".modal_setting").fadeOut();
    //  });

    $("#btn_close").click(function(){
      $(".modal_setting").fadeOut();
    });

    // $(".modal_setting_content").click(function(){
      // $(".modal_setting").fadeOut();
    // });

    //스크롤 위치를 계속 확인해서
    // 모달창  위치를 변경해줌.
    $(window).scroll(function(){

      var aa =Math.max(0,(($(window).height()-$(this).outerHeight())/2) + $(window).scrollTop());

      // modal_content.css('top',aa+'px');
      modal.css('top',aa+'px');

    });

    });

    var is_mask = false;
    var canvas = document.getElementById('canvas');

    var vid = document.getElementById('publish-video');

    var image = new Image();

    image.src="war3_logo_nav_small.png";

    function draw() {

      if (canvas.getContext) {

        var ctx = canvas.getContext('2d');

        ctx.drawImage(vid, 0, 0, canvas.width, canvas.height);

        // ctx.drawImage(image,50, 10, 50, 50)
      }

    }

    //update canvas for every 25ms

    // setInterval(function() { draw(); }, 30);

    // var canvas_stream = canvas.captureStream();

    //capture stream from canvas

    ajax_start('<?php echo $SERVER_ADDRESS_PORT; ?>start_live_streaming', 'GET', 'json')

  </script>

  <!-- <script src="libraries/p5.js"></script>  -->
	<!-- <script src="libraries/p5.dom.js"></script> -->
	<!-- <script src="libraries/p5.sound.js"></script> -->
	<!-- <script src="https://unpkg.com/ml5@0.4.3/dist/ml5.min.js"></script> -->

  <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
  <script type="text/javascript" src="wowza_publish.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/blazeface"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet@1.0.0"> </script> -->
  <!-- <script src="https://unpkg.com/ml5@latest/dist/ml5.min.js"></script> -->
  <script src="./javascript/mask.js"></script>
	<!-- <script src="script.js"></script> -->


  <script>
  set(application_name,stream_name,sdp_url);

  const mask_btn = document.getElementById('mask_btn');
  var is_first = true;
  
  mask_btn.addEventListener('click', () => {

      if(is_mask){
        is_mask = false;
        mask_btn.style.backgroundColor = '#007bff';
      }else{
        is_mask = true;
        mask_btn.style.backgroundColor = 'green';
      }

      if(is_first){
        main();
        is_first = false ;
      }
      
    });

    // setInterval(function() { }, 30);

    var canvas_stream = canvas.captureStream();

  </script>

    <!-- Footer -->
    <footer id="footers">
  </footer>

</body>

<!-- 모달창 -->
<div class="modal_setting">
  <div class="modal_setting_content" style="text-align: center;" title="환경설정">
    <img src="./war3_logo_nav_small.png" style="width:150px; height:150px;" />
    <br>
    <strong>
    <p id="setting_title_text" style="text-align: center; color:#fff;"> 방송 제목 설정 </p>
    </strong>
    <input type="text" id="setting_title" style="height:50px;" value="<?php echo $_POST['name'];?>"></input>
    <br>
    <button  type="button" id="btn_title_update" onclick="update_title()" class="btn btn-primary" >변경</button>
    <br>
    <button  type="button" id="btn_close" class="btn" style="color:#fff;font-size:20px;" >닫기</button>
  </div>
</div>

</html>


<!-- <html lang="en">
    <head>
    </head>
    <style>
      #player-video {
        width: 640px;
      }
    </style>
  

    <body>
      <video id="publish-video" autoplay playsinline muted></video>
      
      <script type="text/javascript" src="https://webrtchacks.github.io/adapter/adapter-latest.js"></script>
      <script type="text/javascript" src="wowza_publish.js"></script>
    </body>
</html>  -->