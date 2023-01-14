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
$result_check_ip = "SELECT * FROM banned_table WHERE id= ?";
$stmt_check_ip = $con->prepare($result_check_ip) or die ($con->error);
$stmt_check_ip->bind_param('s',$uid);
$stmt_check_ip->execute();
$result_check_ip = $stmt_check_ip->get_result();
$row_ka = $result_check_ip->fetch_assoc();
$count_check_ip = $result_check_ip->num_rows;
if($count_check_ip == 0){
  exit('error1');
}
else{
$kid = $row_ka['uid'];
$sql = "DELETE FROM banned_table WHERE id='$uid'";
if ($con->query($sql) === TRUE) {
    $status = "ACTIVE";
    $sql_update = "UPDATE users SET status = ? WHERE uid = ?";
    $stmt_update = $con->prepare($sql_update) or die ($con->error);
    $stmt_update->bind_param('ss',$status,$kid);
    $stmt_update->execute();
    $stmt_update->close();
    exit('succsess');
  } else {
    exit('error');
  }
}
}catch(Exception $e){
    echo $e->getMessage();
  }
?>