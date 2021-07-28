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
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
  <title>Us</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style>

    #index_container{
      height: 1000px;
    }
    .box {
      float: left;
      width: 30px;
      height: 30px; 
      border-radius: 70%;
      overflow: hidden;
      margin-left: 15px;
      margin-bottom: 10px;  
    }
    .profile {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .profile_tx{
      float: left;
      margin-left: 15px;
      font-size: 20px;
      font-weight: 200;
      font-family:"Noto Sans",sans-serif;
    }

  </style>

  <script type="text/javascript">   

    var stream_list ; 
  
    $(document).ready( function() {
    
    $("#navigation").load("navigation.php");  // 원하는 파일 경로를 삽입하면 된다
    $("#footers").load("footer_info.html");   
    // $("#footers").load("common/footer.html");  // 추가 인클루드를 원할 경우 이런식으로 추가하면 된다
    
    });
  
    const ajax_get_list = (ajax_url, ajax_type, ajax_data_type) => {
      $.ajax({
      
      // 요청을 보낼 URL
      url: ajax_url,
      
      // HTTP 요청 방식 (GET, POST)
      type: ajax_type,
      
      // HTTP 요청과 함께 서버로 보낼 데이터
      headers: {
        "Access-Control-Allow-Origin" : '*',
        'Access-Control-Allow-Headers' : '*'
      },
      // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
      dataType: ajax_data_type,
      })
      .done(function (data) {
        console.log('성공 : ' + JSON.stringify(data));
        stream_list = data;
        get_img(stream_list);
        // console.log(stream_list[0]['id'])
        // console.log(stream_list.length)
      
      
        // get_img();
      })
      .fail((data) => {
        console.log('실패 : ' + JSON.stringify(data));
      })
    };
  
    const ajax_get_img = (ajax_url, ajax_type, ajax_data_type,id,position) => {
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
      dataType: ajax_data_type,
      })
      .done(function (data) {
        // console.log('성공 : ' + JSON.stringify(data));
        // console.log(position);
        stream_list[position]['img'] = data;
        create_item(stream_list[position]);
      
      })
      .fail((data) => {
        console.log('실패 : ' + JSON.stringify(data));
        stream_list[position]['img'] = data['responseText'];
        create_item(stream_list[position]);
      })
    };
  
    ajax_get_list('<?php echo $SERVER_ADDRESS_DB; ?>wowza/streaming_list.php', 'GET');
  
    function get_img(stream_list){
      
      for (var i = 0; i <stream_list.length; i++){
        ajax_get_img('<?php echo $SERVER_ADDRESS_PORT; ?>get_thumbnail', 'GET', 'json',stream_list[i]['id'],i);
      }

    }
  
    function create_item(stream_item){
    
      var text = '';
      
        var img = stream_item['img'];
        var img_ = '<?php echo $SERVER_ADDRESS; ?>streaming_ready.gif';
        if(img === null){
          img = img_
        }else if (stream_item['responseText']!==null){
          console.log('썸네일 있음')
          console.log(stream_item['img'])
        }

        var sdp_url = stream_item['sdp_url'];
        var Aname = stream_item['Aname'];
        var Sname = stream_item['Sname'];
        
        text = text + '<div class="col-lg-4 col-md-6 mb-4">';
        text = text + '<div class="card h-100">';
        text = text + "<a style='text-align:center;' href='<?php echo $SERVER_ADDRESS; ?>view2.0.php?sdp_url="+sdp_url+"&&Aname="+Aname+"&&Sname="+Sname+"'>";
        text = text + '<img style="width:100%" src="'+img+'" onerror="this.src=`'+img_+'`"></a>';
        text = text + '<div class="card-body">';
        text = text + '<h4 class="card-title">';
        text = text + '<a href="<?php echo $SERVER_ADDRESS; ?>view.php?id='+stream_item['id']+'">'+stream_item['title']+'</a>';
        text = text + '</h4>';
        text = text + '</div>';
        text = text + '<div>';
        text = text + '<div class="box" style="background: #BDBDBD;">';
        text = text + '<img class="profile" src="<?php echo $SERVER_ADDRESS_DB; ?>img_file/'+stream_item['img_path']+'">';
        text = text + '</div>';
        text = text + '<p class="profile_tx">'+stream_item['username'];
        text = text + '</p>';
        text = text + '</div>';
        text = text + '</div>';
        text = text + '</div>';

      // console.log(stream_item['title']);        
      // console.log(data); 
      // var stream_item = document.getElementById('stream_item');
      
      $("#stream_item").append(text);
      
      // stream_item.append(text);
    }
  
  
  </script>

<nav id="navigation"></nav>
  
</head>

<body>

<div class="container" id="index_container" style ="margin-top:10%">

    <div class="row">

      <div class="col-lg-12">
        <div class="row" id="stream_item">

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-12 -->

    </div>
    <!-- /.row -->

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
