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
if($row['username']==$username){

header("Location:/404.html");

}}else{

  header("Location:/auth/auth-login");
}
try{

  $uid = $con->real_escape_string($_SESSION['uid']);
  $result_check_ip = "SELECT * FROM users WHERE uid= ?";
  $stmt_check_ip = $con->prepare($result_check_ip) or die ($con->error);
  $stmt_check_ip->bind_param('s',$uid);
  $stmt_check_ip->execute();
  $result_check_ip = $stmt_check_ip->get_result();
  $row_ka = $result_check_ip->fetch_assoc();

  $oldpasswordd = $con->real_escape_string($_POST['password']);
  $passwordd = $con->real_escape_string($_POST['new-password']);
  $repassword =  $con->real_escape_string($_POST['confirm-new-password']);
  if(isset($oldpasswordd) && isset($passwordd) && isset($repassword)){
    $passwordrow = $row_ka['password'];
  if(password_verify($oldpasswordd, $passwordrow)){
  if(password_verify($passwordd, $passwordrow)){
    exit('error1');
}
else{
    if($passwordd == $repassword){
        $password = password_hash($passwordd, PASSWORD_DEFAULT);
        $sql_update = "UPDATE users SET password = ? WHERE uid = ?";
        $stmt_update = $con->prepare($sql_update) or die ($con->error);
        $stmt_update->bind_param('ss',$password,$uid);
        $stmt_update->execute();
        $stmt_update->close();
        exit('success');
      }
      else{
        exit('error3');
      }
}
}
else{
    exit('error2');
  }
}

}catch(Exception $e){
  echo $e->getMessage();
}



?>