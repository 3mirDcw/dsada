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
  $reason = $con->real_escape_string($_POST['modalBanUserReason']);


  $sql_check_ip_k = "SELECT * FROM users WHERE uid = ?";
  $stmt_check_ip_k = $con->prepare($sql_check_ip_k) or die ($con->error);
  $stmt_check_ip_k->bind_param('s',$uid);
  $stmt_check_ip_k->execute();
  $result_check_ip_k = $stmt_check_ip_k->get_result();
  $row_k = $result_check_ip_k->fetch_assoc();
  $k_ip = $row_k['ip'];
  $result_check_ip = "SELECT * FROM banned_table WHERE ip_address = ?";
  $stmt_check_ip = $con->prepare($result_check_ip) or die ($con->error);
  $stmt_check_ip->bind_param('s',$k_ip);
  $stmt_check_ip->execute();
  $result_check_ip = $stmt_check_ip->get_result();
  $row_ka = $result_check_ip_k->fetch_assoc();
  $count_check_ip = $result_check_ip->num_rows;

  if($count_check_ip > 0){
    exit('error1');
  }
  else{
    $null = 0;
    $banned = '2147483647';
    $sql_insert = "INSERT INTO banned_table (`uid`,`ip_address`,`banned`,`login_count`,`sebep`)VALUES(?,?,?,?,?)";
    $stmt_insert = $con->prepare($sql_insert) or die ($con->error);
    $stmt_insert->bind_param('sssss',$uid,$k_ip,$banned,$null,$reason);
    $stmt_insert->execute();
    $stmt_insert->close();
    $status = "INACTIVE";
    $sql_update = "UPDATE users SET status = ? WHERE uid = ?";
    $stmt_update = $con->prepare($sql_update) or die ($con->error);
    $stmt_update->bind_param('ss',$status,$uid);
    $stmt_update->execute();
    $stmt_update->close();
  }



}catch(Exception $e){
  echo $e->getMessage();
}





?>