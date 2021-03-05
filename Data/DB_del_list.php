<?php

//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require './db_user_info.php';

header('Content-Type: application/json; charset=UTF-8');


class DB_del_list {

  private $conn = mysqli_connect($db_address, $db_userid, $db_userpw);

  private $array = array();
  private $array_col = array();

  private $array = array();

  private $item;
  private $position;




  public function delete_position($table_name,$col_name,$position){

      // DB에서 입력받은 회원정보를 조회합니다.
    $query_delete ="DELETE FROM $table_name WHERE $col_name = $position ";

    mysqli_select_db($conn, $database);
    $result = $conn->query($query_delete);

    return $result;

  }

  public function delete_item($table_name,$col_name,$col_find,$position,$item){

    $query_get_data_list ="SELECT $col_name FROM $table_name WHERE $col_find = $position ";



    // DB에서 입력받은 회원정보를 조회합니다.
  $query_delete ="DELETE FROM $table_name WHERE $col_name = $position ";

  mysqli_select_db($conn, $database);
  $result = $conn->query($query_delete);

  return $result;

}






  

}







?>
