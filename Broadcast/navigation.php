<?php

// 네이게이션 동작방법
// 1. 세션을 통해서 현재 로그인 상태를 확인한다
// 2. 로그인 중이면 로그아웃, 방송하기 메뉴를 보여주고
//    아니라면 로그인 메뉴만 보여주도록 한다.
// 3. 방송 하기 버튼을 누르면 현재 유저의 방송 데이터 여부를 확인한다.
// 4. 기존 DB에 조회해서 방송 데이터가 있는경우 해당 데이터를 POST로 방송 페이지로 보낸다.
// 5. 기존 DB 데이터가 없는경우
// 5-1. 서버에 방송생성을 요청한다. 여기서부터 모달창으로 로딩중을 표시한다.
// 5-2. 요청받은 응답을 DB에 저장한다.
// 5-3. 요청받은 응답을 POST로 방송 페이지로 보낸다.

// 모든 요청은 ajax로 하고 POST의 경우는 페이지를 같이 이동한다.

include 'session.php';
include 'config.php';

$user_id = null;
if (isset($_SESSION['userid'])){
  $user_id = $_SESSION['userid'];
}else{
  $user_id = 'name_';
}

?>
  <!-- Navigation -->
<style> 
.modal{ 
  position:absolute; 
  width:100%; 
  height: 100vh; 
    /*  모달창 뒤에 회색배경 */
  background: rgba(0,0,0,0.8); 
  top:0; left:0; display:none;
}

.modal_content{
  width:1000px; height:560px;
  border-radius:10px;
  position:relative; 
  /* top:50%;  */
  left:50%;
  text-align:center;
  /* margin-top:-100px;  */
  margin-left:-500px;
  /* box-sizing:border-box;  */
  padding:74px 0;
  line-height:23px; 
}
#broad_cast{
  cursor: pointer;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <nav id="navigation">
  <nav  class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" style="padding: 20px;">
    <div class="container">
      <a class="navbar-brand" href="<?php echo $SERVER_ADDRESS; ?>">
      <img src="<?php echo $SERVER_ADDRESS;?>war3_logo_nav_small.png" 
      style="width : 30px; height : auto; background: transparent;">
      Us
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php

            if(isset($_SESSION['userid'])){
              echo '<a class="nav-link" href="'.$SERVER_ADDRESS.'logout.php">로그아웃</a>';
            }else{
              echo '<a class="nav-link" href="'.$SERVER_ADDRESS.'login.php">로그인</a>';
            }
            ?>
          </li>
          <li class="nav-item">
            <!-- <a class="nav-link" onclick="">방송하기</a> -->
            <?php
            if(isset($_SESSION['userid'])){
              echo '<p class="nav-link" id="broad_cast" onclick="broadcast()" >방송하기</p>';
            }else{
              echo '';
            }
            ?>
          </li>
        </ul>
      </div>

<script>


  var params_streaming = {};
  var params_db = {};
  var is_starting = true;
  var is_streamer = false;

  $('.broad_cast').click( function() {
    console.log('name is not null');
  });

  function create_broadcast(name) {

    console.log("create_live_streaming");
    console.log("name : ",name);

    const ajax_signature = (ajax_url, ajax_type, ajax_data_type,name) => {
    $.ajax({

    // 요청을 보낼 URL
    url: ajax_url,

    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,

    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'name':name
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {
      // console.log('성공 : ' + JSON.stringify(data));

      //스트리밍 데이터 셋 만들기
      params_streaming['sdp_url'] = JSON.stringify(data['source_connection_information']['sdp_url']);
      params_streaming['application_name'] = JSON.stringify(data['source_connection_information']['application_name']);
      params_streaming['stream_name'] = JSON.stringify(data['source_connection_information']['stream_name']);
      params_streaming['id'] = data['id'];
      params_streaming['name'] = data['name'];
      // params_streaming['created_at'] = data['created_at'];

      //DB에 저장할 데이터 셋 만들기
      params_db['sdp_url'] =  params_streaming['sdp_url'] ;
      params_db['Aname'] = params_streaming['application_name'] ;
      params_db['Sname'] = params_streaming['stream_name'] ;
      params_db['id'] = data['id'];
      params_db['title'] = data['name'];
      // params_db['create_time'] = data['created_at'];
      params_db['play_hls'] = data['player_hls_playback_url'];
      params_db['user_id'] = "<?php echo $user_id; ?>";

      console.log('성공 : ' + JSON.stringify(params_db));

      // 방송 생성 확인하고 시작 해줘야함.
      // source_connection_information 보내줘야함
      // id , name , created_at 보내줘야함
      // DB 에 업로드 해줘야함.
      // user_id and 방송_id
      // ajax_start('<?php // echo $SERVER_ADDRESS_PORT; ?>start_live_streaming', 'GET', 'json',data['id'],params_streaming);
      // ajax_stream('<?php // echo $SERVER_ADDRESS_PORT; ?>get_live_stream', 'GET','json',data['id']);
      ajax_input('<?php echo $SERVER_ADDRESS_DB; ?>wowza/streaming_input.php', 'POST', 'json',params_db);


    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
      // alert('잠시후 다시 시도해주세요.');
      $(".modal").fadeOut();  
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
    };  

  ajax_signature('<?php echo $SERVER_ADDRESS_PORT; ?>create_live_streaming', 'GET', 'json',name);

  }


  function sendPost(action, params) {

	  var form = document.createElement('form');

    //표현방식
	  form.setAttribute('method', 'post');

    //전송할 url
	  form.setAttribute('action', action);

	  document.charset = "utf-8";

	  for ( var key in params) {

	  	var hiddenField = document.createElement('input');

	  	hiddenField.setAttribute('type', 'hidden');

	  	hiddenField.setAttribute('name', key);

	  	hiddenField.setAttribute('value', params[key]);

	  	form.appendChild(hiddenField);

	  }

	  document.body.appendChild(form);

	  form.submit();

  }  

  const ajax_check = (ajax_url, ajax_type, ajax_data_type) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'id':'<?php echo $_SESSION['userid']?>'
    },
    headers: {
      "Access-Control-Allow-Origin" : '*',
      'Access-Control-Allow-Headers' : '*'
    },
    // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
    dataType: ajax_data_type,
    })
    .done(function (data) {

      if(data.length!==0){

        console.log('스트리머 체크 성공 :',data.length);
        data_get_db = data[0];
        is_streamer = true;
  
        params_streaming['sdp_url'] = data_get_db['sdp_url'];
        params_streaming['application_name'] = data_get_db['Aname'];
        params_streaming['stream_name'] = data_get_db['Sname'];
        params_streaming['id'] = data_get_db['id'];
        params_streaming['name'] = data_get_db['title'];
        
        // params_streaming['created_at'] =data[0][''] ;
      }else {
        console.log('스트리머 체크 실패 :',data);
      }
    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
  };
  
  const ajax_input = (ajax_url, ajax_type, ajax_data_type,params_db) => {
    $.ajax({
    
    // 요청을 보낼 URL
    url: ajax_url,
    
    // HTTP 요청 방식 (GET, POST)
    type: ajax_type,
    
    // HTTP 요청과 함께 서버로 보낼 데이터
    data: {
      'user_id':params_db['user_id'],
      'sdp_url':params_db['sdp_url'],
      'Aname':params_db['Aname'],
      'Sname':params_db['Sname'],
      'id':params_db['id'],
      'title':params_db['title'],
      'created_at':params_db['created_at'],
      'play_hls':params_db['play_hls']
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
      sendPost('./publish.php',params_streaming);

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
    .always((data) => {
      console.log('종료되었습니다.');
    });
  };

  
  const ajax_stream = (ajax_url, ajax_type, ajax_data_type,id) => {
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
    

      ajax_input('<?php echo $SERVER_ADDRESS_DB; ?>wowza/streaming_input.php', 'POST', 'json',params_db);

    })
    .fail((data) => {
      console.log('실패 : ' + JSON.stringify(data));
    })
  };



  function broadcast(){
    if(is_streamer){
      sendPost('./publish.php',params_streaming);
    }else{
      var name = '<?php echo $user_id; ?>';
      console.log('name :',name);

      if(name!=='name_'){
        $(".modal").fadeIn();  
        name = name + '의 방송입니다.';
        create_broadcast(name);
      }
    }
  };


  $(function(){ 

    var modal_content = $(this).find(".modal_content");
    var modal = $(this).find(".modal");
    
    // 버튼을 클릭하면 모달창이 생성되게끔
    
    // $("#broad_cast").click(function(){
    //   $(".modal").fadeIn();
    // });
    
    //모달내부나 모달 밖을 클릭하였을때 사라지게 하는 코드
    // 여기서는 로딩이 완료되면 페이지가 이동되니 필요없음.
    //  $(".modal_content").click(function(){
    //  $(".modal").fadeOut();
    //  });
    
    // $(".modal").click(function(){
    //   $(".modal").fadeOut();
    // });
    
    //스크롤 위치를 계속 확인해서
    // 모달창  위치를 변경해줌.
    $(window).scroll(function(){
    
      var aa =Math.max(0,(($(window).height()-$(this).outerHeight())/2) + $(window).scrollTop());

      modal_content.css('top',aa+'px');
    
    });

  });


  ajax_check('<?php echo $SERVER_ADDRESS; ?>streaming_check.php',"POST",'json');

</script>
      
    </div>
    
  </nav>

<!-- 모달창 -->
<div class="modal">
  <div class="modal_content" style="text-align: center;" title="로딩중 입니다.">
    <img src="./LoadingImg.gif" />
    <strong>
    <p style="text-align: center; color:#fff;"> 방송 생성 중 입니다.</p>
    <p style="text-align: center; color:#fff;"> 최대 5분 까지 소요 됩니다.</p>
    </strong>
  </div>
</div>

  