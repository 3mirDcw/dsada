<?php

include_once '../includes/baglan.php';
session_start();
if(isset($_SESSION['uid']) && isset($_SESSION['username'])){
$username=$_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $con->prepare($sql) or die ($con->error);
$stmt->bind_param('s',$username);
$stmt->execute();
$result_username = $stmt->get_result();
$row = $result_username->fetch_assoc();
if($row['pre']<7){

header("Location:/404.html");

}}else{

  header("Location:/auth/auth-login");
}
try{
  $uid = $con->real_escape_string($_POST['uid']);
  $username = $con->real_escape_string($_POST['modalEditUserFirstName']);
  $password = $con->real_escape_string($_POST['modalEditUserLastName']);
  $bakiye =  $con->real_escape_string($_POST['modalEditUserPhone']);
  $pre =  $con->real_escape_string($_POST['modalEditUserRank']);
  $passwordd = password_hash($password, PASSWORD_DEFAULT);
  $status = $con->real_escape_string($_POST['modalEditUserStatus']);


  $sql_check_username = "SELECT username FROM users WHERE username = ? AND uid != ?";
  $stmt_check_username = $con->prepare($sql_check_username) or die ($con->error);
  $stmt_check_username->bind_param('ss',$username,$uid);
  $stmt_check_username->execute();
  $result_check_username = $stmt_check_username->get_result();
  $count_check_username = $result_check_username->num_rows;


  if($count_check_username > 0){
    exit('error1');
  }
  if(!empty($password)){
  $sql_update = "UPDATE users SET username = ?, status = ?, password = ?, pre = ?, bakiye = ? WHERE uid = ?";
  $stmt_update = $con->prepare($sql_update) or die ($con->error);
  $stmt_update->bind_param('ssssss',$username,$status,$passwordd,$pre,$bakiye,$uid);
  $stmt_update->execute();
  $stmt_update->close();

}
  else{
  $sql_update = "UPDATE users SET username = ?, status = ?, pre = ?, bakiye = ? WHERE uid = ?";
  $stmt_update = $con->prepare($sql_update) or die ($con->error);
  $stmt_update->bind_param('sssss',$username,$status,$pre,$bakiye,$uid);
  $stmt_update->execute();
  $stmt_update->close();
  }




}catch(Exception $e){
  echo $e->getMessage();
}





?>