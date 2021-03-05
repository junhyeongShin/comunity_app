<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require './db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');


        // DB에 연결합니다.
      $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
      mysqli_select_db($conn, $database);

  //   for($i = 0;$i<10000;$i++){

  //     $user_id = '100000_test_id'.(string)$i;
  //     $encrypted_passwd = '100000_test_pw';
  //     $user_name = '100000_test_name'.(string)$i;

  //     $master = $i+1000000;
  //     $clan_name = '100000_test_id'.(string)$i;
  //     $clan_intro = '100000_test_name'.(string)$i;
  //     $clan_img = 0;
  //     $clan_category = "뿔레전쟁";

  // // DB에서 입력받은 회원정보를 조회합니다.
  // $query_clan_add ="INSERT INTO Clan (master,title,clan_introduce,category,clan_img,create_time)
  // VALUES(
  // $master,
  // '".$clan_name."',
  // '".$clan_intro."',
  // '".$clan_category."',
  // $clan_img,
  // now())";

  //     $result = $conn->query($query_clan_add);

  //   }
  // echo $i;

?>