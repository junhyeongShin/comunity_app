<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require dirname(__FILE__,2).'/db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');

// $user_id = $_GET['user_id'];
$user_id = $_GET['user_id'];
$clan_id = $_GET['clan_id'];


        // DB에서 입력받은 정보를 조회합니다.
        $query_get_member_count ="SELECT member_count FROM Clan WHERE id = $clan_id ";

        //DB에 연결합니다.
        $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
        mysqli_select_db($conn, $database);
        $result_count = $conn->query($query_get_member_count);
        $row_count = mysqli_fetch_assoc($result_count);

if($row_count['member_count']>=100){

  echo 'over_member_count';
  exit;

}else{

      // DB에서 입력받은 정보를 조회합니다.
  $query_get_member_list ="SELECT member FROM Clan WHERE id = $clan_id ";

  //DB에 연결합니다.
  $result_get_member_list = $conn->query($query_get_member_list);

  //조회된 리스트를 배열로 변경합니다.
  //배열값중 하나
  $row_get_member_list = mysqli_fetch_assoc($result_get_member_list);

  //배여을 파싱
  $string_get_member_list = implode(",",$row_get_member_list);

  //파싱한 스트링을 배열로 변환
  $array_get_member_list = explode(',',$string_get_member_list);


  // 검사하는 코드 시작

  $test_array_get_member_list = array();

  for($i=0;$i<count($array_get_member_list);$i++){
    if($array_get_member_list[$i]==$user_id){
    array_push($test_array_get_member_list,$array_get_member_list[$i]);
    }
  }

    // 검사하는 코드 종료
    //이미 목록에 있을경우
    if(count($test_array_get_member_list)>0){
      echo '클랜원 목록에 이미 있을경우';

      print_r($test_array_get_member_list);
      exit;
    }
    //없을경우
    else{
    
      if(strlen($string_get_member_list)===0){
        $update_member = $user_id;
      }else{
        $update_member = $string_get_member_list.','.$user_id;
      }

      $query_update_count ="UPDATE Clan SET member_count = member_count +1 WHERE id = $clan_id "; 

      //DB에 연결합니다.
    $result_increase = $conn->query($query_update_count);

      
      $query_update_member_list ="UPDATE Clan SET member = '$update_member' WHERE id = $clan_id ";

        //DB에 연결합니다.
      $result = $conn->query($query_update_member_list);


        // 유저 신청 리스트에서 제거.
        // DB에서 입력받은 회원정보를 조회합니다.
  $query_get_join_request_list ="SELECT join_request_list FROM Clan WHERE id = $clan_id ";

  //DB에 연결합니다.
  $result_join_request_list = $conn->query($query_get_join_request_list);

  //조회된 리스트를 배열로 변경합니다.
  //배열값중 하나
  $row_join_request_list = mysqli_fetch_assoc($result_join_request_list);


          if(strlen($row_join_request_list['join_request_list'])>2){
            
              //배여을 파싱
          $string_join_request_list = implode(",",$row_join_request_list['join_request_list']);
          
          //파싱한 스트링을 배열로 변환
          $array_join_request_list = explode(',',$string_join_request_list);
          
            // 검사하는 코드 시작
          
            $test_array_join_request_list = array();
            $delete_point;
          
            for($i=0;$i<count($array_join_request_list);$i++){
              if($array_join_request_list[$i]==$user_id){
              array_push($test_array_join_request_list,$array_join_request_list[$i]);
              $delete_point = $i;
              }
            }
          
                // 검사하는 코드 종료
            //이미 목록에 있을경우
            if(count($test_array_join_request_list)>0){
            
              if(strlen($string)===0){
              
              
              }else{
              
                unset($array_join_request_list[$delete_point]);
              
                $string_requset_list = implode(",",$array_join_request_list);
              
                $update_requset_list = $string_requset_list;

              }
            
            
            
            
              $query_update_join_request_list ="UPDATE Clan SET join_request_list = '$update' WHERE id = $clan_id ";
            
                //DB에 연결합니다.
              $result_update_join_request_list = $conn->query($query_update_join_request_list);
            
            
            
           }else{
          
            $query_update_join_request_list ="UPDATE Clan SET join_request_list = null WHERE id = $clan_id ";
          
            //DB에 연결합니다.
           $result_update_join_request_list = $conn->query($query_update_join_request_list);

            }

    }else{
      $query_update_join_request_list ="UPDATE Clan SET join_request_list = null WHERE id = $clan_id ";
          
      //DB에 연결합니다.
     $result_update_join_request_list = $conn->query($query_update_join_request_list);
    
    }
  }



          // 유저 신청 리스트에서 제거.
        // DB에서 입력받은 회원정보를 조회합니다.
        $query_get_user_clan_list ="SELECT clan FROM user WHERE user.index = $user_id ";

        //DB에 연결합니다.
        $result_get_user_clan_list = $conn->query($query_get_user_clan_list);
      
        //조회된 리스트를 배열로 변경합니다.
        //배열값중 하나
        $row_get_user_clan_list = mysqli_fetch_assoc($result_get_user_clan_list);


              if((strpos($row_get_user_clan_list['clan'], ',')) !== false){
                
                // echo ', 포함';
                    //배여을 파싱
                $string_get_user_clan_list = implode(",",$row_get_user_clan_list);
                
                //파싱한 스트링을 배열로 변환
                $array_get_user_clan_list = explode(',',$string_get_user_clan_list);
                
                  // 검사하는 코드 시작
                
                  $test_array_get_user_clan_list = array();
                
                  for($i=0;$i<count($array_get_user_clan_list);$i++){
                    if($array_get_user_clan_list[$i]==$clan_id){
                    array_push($test_array_get_user_clan_list,$array_get_user_clan_list[$i]);
                    }
                  }
                
                      // 검사하는 코드 종료
                  //이미 목록에 있을경우
                  if(count($test_array_get_user_clan_list)>0){
                    echo '이미 가입되어 있는 클랜입니다.';
                    exit;
                  
                  }else{

                    if(strlen($string_get_user_clan_list)===0){
                      $update_user_clan_list = $clan_id;
                    }else{
                      $update_user_clan_list = $string_get_user_clan_list.','.$clan_id;
                    }

                  
                    $query_update_get_user_clan_list ="UPDATE user SET clan = '$update_user_clan_list' WHERE user.index = $user_id ";
                  

                    // echo  $query_update_get_user_clan_list;
                      //DB에 연결합니다.
                    $result_update_get_user_clan_list = $conn->query($query_update_get_user_clan_list);


                  }
                }else{

                  // echo ', 포함 안함';


                    $update_user_clan_list = $clan_id;
                
                  $query_update_get_user_clan_list ="UPDATE user SET clan = '$update_user_clan_list' WHERE user.index = $user_id ";
                
                    //DB에 연결합니다.
                  $result_update_get_user_clan_list = $conn->query($query_update_get_user_clan_list);

                }


                echo 'success';




}



?>