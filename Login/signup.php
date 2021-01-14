<?php

	// $userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $userpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$username = $_POST['nickname'];
  $user_email = $_POST['email'];
  $phone = $_POST['phone'];


  
  $conn = mysqli_connect("localhost", "mysql_user", '1q2w3e4r');
  mysqli_select_db($conn, "shopdatabase");
  $query = "select * from user where email='$email'";
  // echo var_dump(mysqli_select_db($conn, "shopdatabase"));
  
  $result = $conn->query($query);
  $row=mysqli_fetch_assoc($result);
  
    if(mysqli_num_rows($result)==1){
      echo ("<script>alert('아이디가 중복됩니다.');history.back();</script>");

    }else if($_POST['password']!==$_POST['chpassword']){
      echo ("<script>alert('비밀번호가 일치하지 않습니다.');history.back();</script>");
    }else
    {
    $sql ="INSERT INTO user (email,pw,name,Adr,Adr2,Adr3,ph,agr)
    VALUES(
    '".$_POST['email']."',
    '".$_POST['password']."',
    '".$_POST['nickname']."',
    '".$adr1."',
    '".$adr2."',
    '".$adr3."',
    '".$_POST['phone']."',
    0)";
  
    // echo '\n';
    $conn = mysqli_connect("localhost", "user", '1q2w3e4R@@');
    mysqli_select_db($conn, "shopdatabase");
    $result = mysqli_query($conn, $sql);
    
    echo $sql;

    echo var_dump($result);
    
    
    // echo ("<script>alert('회원가입이 완료되었습니다.');</script>");
    
    // header('Location: ./login.html');
  }
?>