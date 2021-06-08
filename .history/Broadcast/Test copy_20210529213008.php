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

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>


      <script>

      var time_stamp = Math.floor(+ new Date() / 1000);
      console.log(time_stamp);

        const ajax = (ajax_url, ajax_type, ajax_data, ajax_data_type, ajax_signature,ajax_timestamp) => {
        $.ajax({

          // 요청을 보낼 URL
          url: ajax_url,

          // HTTP 요청 방식 (GET, POST)
          type: ajax_type,

          // HTTP 요청과 함께 서버로 보낼 데이터
          data: ajax_data,

          // 해더정보 추가하기
          headers: {
            "wsc-api-key" : 'oQ01jbLhYrEV4DJwVQZRbfcuQtcfBJyxIzrgaGxnp7SKc0CCktiWhLnOqhIN362e',
            'wsc-access-key' : 'VK0ENJ7F7UwUOIIMfxs3t2VZvkxFU2lfVZL5XxrvlFo677kwXSNQLtS8cOK63253',
            'wsc-timestamp' : ajax_timestamp,
            'wsc-signature' : ajax_signature,
          },

          // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
          dataType: ajax_data_type,
        })
          .done(function (data) {
            console.log('성공적으로 데이터 수신 : ' + JSON.stringify(data));
          })
          .fail((data) => {
            console.log('실패 : ' + JSON.stringify(data));
          })
          .always((data) => {
            console.log('종료되었습니다.');
          });
      };

    const ajax_signature = (ajax_url, ajax_type, ajax_data_type) => {
      $.ajax({

        // 요청을 보낼 URL
        url: ajax_url,
        
        // HTTP 요청 방식 (GET, POST)
        type: ajax_type,

        // HTTP 요청과 함께 서버로 보낼 데이터
        data: JSON.stringify(
          
        ),
        headers: {
          "Access-Control-Allow-Origin" : '*'
        },

        // 서버에서 보내줄 데이터의 타입 ( xml, text, html, json 등)
        dataType: ajax_data_type,
      })
        .done(function (data) {
          console.log('성공적으로 데이터 수신 : ' + JSON.stringify(data));
          console.log('signature : ' + JSON.stringify(data['signature']));
          console.log('timestamp : ' + JSON.stringify(data['timestamp']));

          ajax('https://api-sandbox.cloud.wowza.com/api/v1.6/live_streams', 
          'POST', 
          Create_live_stream(), 
          'json',
          JSON.stringify(data['signature']),
          JSON.stringify(data['timestamp'])
          );

        })
        .fail((data) => {
            console.log('실패 : ' + JSON.stringify(data));
        
        })
        .always((data) => {
          console.log('종료되었습니다.');
        });
    };
    
    ajax_signature('http://192.168.56.1:8080', 'POST', 'json');


    function Create_live_stream(){
      
      return JSON.stringify({
        "live_stream": {
     "aspect_ratio_height": 1080,
     "aspect_ratio_width": 1280,
     "billing_mode": "pay_as_you_go",
     "broadcast_location": "us_west_california",
     "encoder": "other_webrtc",
     "name": "MyLiveStream",
     "transcoder_type": "transcoded"
      }
    }                        
        );

    }

  </script>

<nav id="navigation"></nav>
  

</head>

<body>
 
<div class="container" style ="margin-top:2%">

    <div class="row">


      <div class="col-lg-12">


        <div class="row">

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Two</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Two</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Three</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Four</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Five</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur! Lorem ipsum dolor sit amet.</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">Item Six</a>
                </h4>
                <h5>$24.99</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
              </div>
              <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div>
            </div>
          </div>

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
