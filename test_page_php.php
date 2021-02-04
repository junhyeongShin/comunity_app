<?php
//db의 아이디 비밀번호 데이터 베이스를 가져옵니다
//아이디 : db_userid
//비밀번호 : db_userpw
//데이터 베이스 : db_database
require './Data/db_user_info.php';

// 비밀번호를 암호화 합니다
$encrypted_passwd = password_hash($user_passwd, PASSWORD_DEFAULT);

// DB에서 입력받은 회원정보를 조회합니다.
$sql ="INSERT INTO user (Inum,Un,num,Sta,Iuid,Muid,Anum,Adr,Adr2,Adr3,pr,Sn)
VALUES(
'".$array_num."',
'".$Un."',
'".$array_count."',
'0',
'".$Iuid."',
'".$Muid."',
'".$Anum."',
'".$Adr."',
'".$Adr2."',
'".$Adr3."',
'$pr',
'".$array_Sn."')";

//db에 쿼리문 대입

//DB에 연결합니다.
$conn = mysqli_connect($db_address, $db_userid, $db_userpw);
mysqli_select_db($conn, $database);
$result = $conn->query($sql);

$row=mysqli_fetch_assoc($result);

echo var_dump($row);
echo var_dump($result);


?>