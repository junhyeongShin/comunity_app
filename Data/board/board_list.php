<?php
//DB 에서 게시판 리스트를 보여주는 역할
//1. 받은 요청 확인 (카테고리)
//2. 요청받은 (전체보기, 인기순, 즐겨찾기)에 해당하는 리스트 보내줌
//3. 리스트는 json 형식

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  // 컨텐츠 타입이 JSON 인지 확인한다
  if(!in_array('application/json',explode(';',$_SERVER['CONTENT_TYPE']))){
  echo json_encode(array('result_code' => '400'));
  exit;
  
  }else{
  
  $__rawBody = file_get_contents("php://input"); // 본문을 불러옴
  // $__getData = array(json_decode($__rawBody)); // 데이터를 변수에 넣고

  $postData = json_decode($__rawBody, true);

  $category = $postData['category'];

  if($postData['request_list']==='views'){
  
  // DB에서 입력받은 회원정보를 조회합니다.
  $query_board_list ="SELECT * FROM board WHERE $category = $postData['category'] ORDER BY views DEC ";

  
  }else if($postData['request_list']==='favorites'){

  $query_user_favorites = "SELECT favorites FROM user WHERE id = $postData['user_id']";

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_user_favorites);

    //DB 에서 어레이로 저장되어있던 자료 파싱
    $count = explode(',',$result['favorites']);

    $array_result = array();

    if(is_array($count)){
      foreach($count as $key){
        $query_board_list ="SELECT * FROM board WHERE $category = $postData['category'] AND id = $key ";
        $result_favorites = $conn->query($query_board_list);
        $row_result=mysqli_fetch_assoc($result_favorites);

        array_push($array_result,$row_result);
      }
      echo json_encode(array('result_code' => '200','result_check' => 'OK','result_list'=>$array_result));
    }else if(isset($count)){
      echo json_encode(array('result_code' => '200','result_check' => 'NO $count is empty.'));
    }

  exit;

  }else{

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_board_list ="SELECT * FROM board WHERE $category = $postData['category'] ORDER BY id DEC ";

  }

    //DB에 연결합니다.
    $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
    mysqli_select_db($conn, $database);
    $result = $conn->query($query_board_list);
    $row_result=mysqli_fetch_assoc($result);

    
    if($result){
      echo json_encode(array('result_code' => '200','result_check' => 'OK','result_list'=>$row_result));
    }else{
      echo json_encode(array('result_code' => '200','result_check' => 'NO','$query_signup_check' => $query_signup_check));
    }
    exit;

}
?>