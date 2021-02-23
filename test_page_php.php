<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/Data/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

 $array = [
                  'special_key' => 'replacement_value',
                  'key_one' => 'testing',
                  'key_two' => 'value',
                  'four' => 'another value'
];

$string = implode(', ', $array);

  // DB에서 입력받은 회원정보를 조회합니다.
  $query_comment_edit ="UPDATE user SET friend_list = '".$string."' WHERE user.index = 1 ";

  //db에 쿼리문 대입
  $query_test_get ="SELECT * FROM user WHERE user.index = 1 ";

  echo $query_test_get;
  echo '<br>';
  
  //DB에 연결합니다.
  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
  mysqli_select_db($conn, $database);
  $result = $conn->query($query_test_get);

  $row_result=mysqli_fetch_assoc($result);

  echo var_dump($row_result['friend_list']);



  // echo var_dump($result);
  // echo $query_comment_edit;
//   if($result){
//     echo 'OK';
//     exit;
//   }else{
//     echo $query_comment_edit;
//     exit;
//   }

// // JSON 파일 읽어오기
// $json_string = file_get_contents('weather.json');
// // 다차원 배열 반복처리
// $R = new RecursiveIteratorIterator(
//     new RecursiveArrayIterator(json_decode($json_string, TRUE)),
//     RecursiveIteratorIterator::SELF_FIRST);
// // $R : array data
// // json_decode : JSON 문자열을 PHP 배열로 바꾼다
// // json_decode 함수의 두번째 인자를 true 로 설정하면 무조건 array로 변환된다.

// foreach ($R as $row) {
//   print $row['lastName'];
//   print $row['firstName'];
//   print ' , ';
//   print $row['email'];
//   print ' , ';
//   print $row['mobile'];
//   print '<br />';
// }


?>
