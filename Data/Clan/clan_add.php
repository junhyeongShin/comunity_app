<?php

  //DB의 정보를 가져옵니다. 
  require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  
  // $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  // $postData = json_decode($__rawBody, true);

  $master = $_POST['user_id'];
  $clan_name = $_POST['clan_name'];
  $clan_intro = $_POST['clan_intro'];
  $clan_img = $_POST['clan_img'];
  $clan_category = $_POST['clan_category'];


  // $master = $_GET['user_id'];
  // $clan_name = $_GET['clan_name'];
  // $clan_intro = $_GET['clan_intro'];
  // $clan_img = $_GET['clan_img'];
  // $clan_category = $_GET['clan_category'];

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_clan_add ="INSERT INTO Clan (master,member,title,clan_introduce,category,clan_img,create_time)
  VALUES(
  $master,
  $master,
  '".$clan_name."',
  '".$clan_intro."',
  '".$clan_category."',
  $clan_img,
  now())";

  //db에 쿼리문 대입
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_clan_add);


    // DB에서 입력받은 회원정보를 조회합니다.
    $query_get_user_clan ="SELECT clan FROM user WHERE user.index = $master ";

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_get_user_clan);
  
    //조회된 친구 리스트를 배열로 변경합니다.
    //배열값중 하나
    $row = mysqli_fetch_assoc($result);
  
    //배여을 파싱
    $string = implode(",",$row);
  
    //파싱한 스트링을 배열로 변환
    $array = explode(',',$string);
  
    // 검사하는 코드 시작
    $test_array = array();


    for($i=0;$i<count($array);$i++){
      if($array[$i]==$master){
      array_push($test_array,$array[$i]);
      }
    }
  
      // 검사하는 코드 종료
      //이미 목록에 있을경우
      if(count($test_array)>0){
        echo '이미 목록에 있을경우';
        exit;
      }
      
      //없을경우
      else{
        
        
    // DB에서 입력받은 회원정보를 조회합니다.
    $query_get_clan_id ="SELECT id FROM Clan WHERE master = $master ORDER BY id DESC limit 1";

    //DB에 연결합니다.
    $result_get_clan_id = $conn->query($query_get_clan_id);
    $row_get_clan_id = mysqli_fetch_assoc($result_get_clan_id);
    $clan_id = $row_get_clan_id['id'];


        
        if(strlen($string)===0){
          $update = $clan_id;
        }else{
          $update = $string.','.$clan_id;
        }
        $query_update_friend ="UPDATE user SET clan = '$update' WHERE user.index = $master ";
        
          //DB에 연결합니다.
        $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
        mysqli_select_db($conn, $database);
        $result = $conn->query($query_update_friend);
        
      }
  
  
  if($result){
    echo $result;
    exit;
  }else{
    echo $query_clan_add;
    exit;
  }

?>