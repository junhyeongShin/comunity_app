<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
 
 header('Content-Type: application/json; charset=UTF-8');
 
  $clan_id = $_GET['clan_id'];
                    
                          // DB에서 입력받은 회원정보를 조회합니다.
                  $query_get_member_clan ="SELECT member FROM Clan WHERE id = $clan_id ";
                  $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
                  mysqli_select_db($conn, $database);


                  $result_get_member_clan = $conn->query($query_get_member_clan);
                  $row_get_member_clan = mysqli_fetch_assoc($result_get_member_clan);
                  
                  if(!$row_get_member_clan){
                    echo '조회 불가능';
                    exit;
                  }else{


                  
                  if((strpos($row_get_member_clan['member'], ',')) !== false){

                    print_r($row_get_member_clan['member']);

                      //배여을 파싱
                  $string_get_member_clan = implode(",",$row_get_member_clan);
                  
                  //파싱한 스트링을 배열로 변환
                  $array_get_member_clan = explode(',',$string_get_member_clan);
                  
                  // DB 리스트 각 데이터에 적용.
                  for($i=0;$i<count($array_get_member_clan);$i++){


                    echo ' count($array_get_member_clan) : '.count($array_get_member_clan);



                    $user_id =  $array_get_member_clan[$i];


                                // DB에서 입력받은 회원정보를 조회합니다.
                            $query_get_user_clan ="SELECT clan FROM user WHERE user.index = $array_get_member_clan[$i] ";

                            //DB에 연결합니다.
                            $result_user_clan = $conn->query($query_get_user_clan);

                            //조회된 친구 리스트를 배열로 변경합니다.
                            //배열값중 하나
                            $row_user_clan = mysqli_fetch_assoc($result_user_clan);

                            if((strpos($row_user_clan['clan'], ',')) !== false){


                        

                                        //배여을 파싱
                                        $string_user_clan = implode(",",$row_user_clan);

                                        //파싱한 스트링을 배열로 변환
                                        $array_user_clan = explode(',',$string_user_clan);


                                        // 검사하는 코드 시작

                                        $test_array_user_clan = array();
                                        $delete_point;

                                        for($i=0;$i<count($array_user_clan);$i++){
                                          if($array_user_clan[$i]==$clan_id){
                                          array_push($test_array_user_clan,$array_user_clan[$i]);
                                          $delete_point = $i;
                                          }
                                        }
                                      
                                        // 검사하는 코드 종료
                                        //이미 목록에 있을경우
                                        if(count($test_array_user_clan)>0){
                                        
                                          if(strlen($string_user_clan)===0){
                                          
                                            echo 'success';
                                          
                                          }else{
                                          
                                            unset($array_user_clan[$delete_point]);
                                            $string_user_clan = implode(",",$array_user_clan);
                                            $update_user_clan = $string_user_clan;
                                          
                                          }
                                        


                                          $query_update_user_clan ="UPDATE user SET clan = '$update_user_clan' WHERE user.index = $user_id ";
                                        
                                            //DB에 연결합니다.
                                          $result_update_user_clan = $conn->query($query_update_user_clan);
                                        
                                          if($result_update_user_clan){
                                              echo ' 성공 : '.$query_update_user_clan;

                                          }else{
                                            echo $query_update_user_clan;
                                          }
                                        
                                        }
                                        //없을경우
                                        else{
                                          echo '목록에 없을경우';
                                        
                                        }
                                      
                              }else{
                              


                                          $query_update_user_clan ="UPDATE user SET clan = null WHERE user.index = $user_id ";

                                            //DB에 연결합니다.
                                          $result_update_user_clan = $conn->query($query_update_user_clan);

                                          if($result_update_user_clan){
                                            echo 'success';
                                          
                                          }else{
                                            echo $query_update_user_clan;
                                          }
                                        
                                      
                              }

                  }
                
                  }else{

                      $tmp = $row_get_member_clan['member'];

                        // DB에서 입력받은 회원정보를 조회합니다.
                        $query_get_user_clan ="SELECT clan FROM user WHERE user.index =  $tmp";

                        //DB에 연결합니다.
                        $result_user_clan = $conn->query($query_get_user_clan);

                        if(!$result_user_clan){
                            echo '유저 정보 잘못됨';
                        }else{

                  

                        //조회된 친구 리스트를 배열로 변경합니다.
                        //배열값중 하나
                        $row_user_clan = mysqli_fetch_assoc($result_user_clan);

                        //배여을 파싱
                        $string_user_clan = implode(",",$row_user_clan);

                        //파싱한 스트링을 배열로 변환
                        $array_user_clan = explode(',',$string_user_clan);


                        // 검사하는 코드 시작

                        $test_array_user_clan = array();
                        $delete_point;

                        for($i=0;$i<count($array_user_clan);$i++){
                          if($array_user_clan[$i]==$clan_id){
                          array_push($test_array_user_clan,$array_user_clan[$i]);
                          $delete_point = $i;
                          }
                        }
                      
                        // 검사하는 코드 종료
                        //이미 목록에 있을경우
                        if(count($test_array_user_clan)>0){
                          echo '이미 목록에 있을경우';
                        
                          if(strlen($string_user_clan)===0){
                          
                            echo 'success';
                          
                          }else{
                          
                            unset($array_user_clan[$delete_point]);
                          
                            $string_user_clan = implode(",",$array_user_clan);
                            $update_user_clan = $string_user_clan;
                          
                          }
                        
                          $query_update_user_clan ="UPDATE user SET clan = '$update_user_clan' WHERE user.index = $id ";
                        
                            //DB에 연결합니다.
                          $result_update_user_clan = $conn->query($query_update_user_clan);
                        
                          if($result_update_user_clan){
                            echo 'success';
                          
                          }else{
                            echo $query_update_user_clan;
                          }
                        
                        }
                        //없을경우
                        else{
                          echo '목록에 없을경우';
                          echo  $query_get_user_clan;
                        
                        }
                  
                  }


              }

              $query_delete ="DELETE FROM Clan WHERE id = $clan_id ";

              mysqli_select_db($conn, $database);
              $result = $conn->query($query_delete);

              echo 'success';

              }
      
      
      
      

?>