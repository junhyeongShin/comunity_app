<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__).'/Data/db_user_info.php';
require dirname(__FILE__).'/Data/DB/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');


  // DB 클래스 생성
  // 1 정규식
 $db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));


  $db->join("table u", "p.tenantID=u.tenantID", "LEFT");
  $db->where("u.id", 6);
  $products = $db->get ("table p", null, "t1.col, t2.col");
  print_r ($products);
  // Gives: SELECT t1.col, t2.col FROM table LEFT JOIN users u ON p.tenantID=u.tenantID WHERE u.id = 6

?>
