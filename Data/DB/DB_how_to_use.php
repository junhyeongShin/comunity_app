<?php

//DB의 정보를 가져옵니다. 
require dirname(__FILE__,2).'/db_user_info.php';
require dirname(__FILE__).'/db_class.php';

 header('Content-Type: application/json; charset=UTF-8');


//  https://github.com/ThingEngineer/PHP-MySQLi-Database-Class#insert-query


  // DB 클래스 생성
  // 1 정규식
 $db = new MysqliDb (Array (
  'host' => $db_address,
  'username' => $db_userid, 
  'password' => $db_userpw,
  'db'=> $database,
  'port' => 3306,
  'charset' => 'utf8'));

  //2 간단하게 표현
//   $mysqli = new mysqli ('host', 'username', 'password', 'databaseName');
// $db = new MysqliDb ($mysqli);
// $db->setPrefix ('my_');





  //이미 만들어진 DB가 있을경우
//   function init () {
//     // db staying private here
//     $db = new MysqliDb ('host', 'username', 'password', 'databaseName');
// }
// ...
// function myfunc () {
//     // obtain db object created in init  ()
//     $db = MysqliDb::getInstance();
//     ...
// }



// --------------------------------------------------------------------------------------------------------
// //INSERT



// $data = Array ("user_id" => 10,
//                "friend_id" => 3
// );
// $id = $db->insert ('friends', $data);
// if($id)
//     echo 'friends was created. Id=' . $id;




// $data = Array(
//   Array ("admin", "John", "Doe"),
//   Array ("other", "Another", "User")
// );
// $keys = Array("login", "firstName", "lastName");

// $ids = $db->insertMulti('users', $data, $keys);
// if(!$ids) {
//   echo 'insert failed: ' . $db->getLastError();
// } else {
//   echo 'new users inserted with following id\'s: ' . implode(', ', $ids);
// }








//     --------------------------------------------------------------------------------------------------------

//UPDATE

// $data = Array (
// 	'firstName' => 'Bobby',
// 	'lastName' => 'Tables',
// 	'editCount' => $db->inc(2),
// 	// editCount = editCount + 2;
// 	'active' => $db->not()
// 	// active = !active;
// );
// $db->where ('id', 1);
// if ($db->update ('users', $data))
//     echo $db->count . ' records were updated';
// else
//     echo 'update failed: ' . $db->getLastError();
// update() also support limit parameter:

// $db->update ('users', $data, 10);
// // Gives: UPDATE users SET ... LIMIT 10                  

//     --------------------------------------------------------------------------------------------------------



// Select Query
// After any select/get function calls amount or returned rows is stored in $count variable

// $users = $db->get('users'); //contains an Array of all users 
// $users = $db->get('users', 10); //contains an Array 10 users
// or select with custom columns set. Functions also could be used

// $cols = Array ("id", "name", "email");
// $users = $db->get ("users", null, $cols);
// if ($db->count > 0)
//     foreach ($users as $user) { 
//         print_r ($user);
//     }
// or select just one row

// $db->where ("id", 1);
// $user = $db->getOne ("users");
// echo $user['id'];

// $stats = $db->getOne ("users", "sum(id), count(*) as cnt");
// echo "total ".$stats['cnt']. "users found";
// or select one column value or function result

// $count = $db->getValue ("users", "count(*)");
// echo "{$count} users found";
// select one column value or function result from multiple rows:

// $logins = $db->getValue ("users", "login", null);
// // select login from users
// $logins = $db->getValue ("users", "login", 5);
// // select login from users limit 5
// foreach ($logins as $login)
//     echo $login;



?>
