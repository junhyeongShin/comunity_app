<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/Data/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');

          // 유저 신청 리스트에서 제거.
        // DB에서 입력받은 회원정보를 조회합니다.
        $query_get_user_clan_list ="SELECT clan FROM user WHERE user.index =10";

        //DB에 연결합니다.
        $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
        mysqli_select_db($conn, $database);
        $result_get_user_clan_list = $conn->query($query_get_user_clan_list);
      
        //조회된 리스트를 배열로 변경합니다.
        //배열값중 하나
        $row_get_user_clan_list = mysqli_fetch_assoc($result_get_user_clan_list);
        print_r($row_get_user_clan_list);

                if((strpos($row_get_user_clan_list['clan'], ',')) !== false){

                      echo ' 포함';
                }else{
                  echo ' 비포함';

                }
                  

?>
