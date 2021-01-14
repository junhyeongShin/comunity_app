<?php
session_start();

function check_login(){
if(isset($_SESSION['userid'])){
return $_SESSION['userid'];
} else{
  return NULL;
}
}

?>