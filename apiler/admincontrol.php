<?php
include_once '../includes/baglan.php';
if(isset($_SESSION['uid']) && isset($_SESSION['username'])){
    $uid = $_SESSION['uid'];
	$username = $_SESSION['username'];

  $sql_account = "SELECT * FROM users WHERE uid = ? ";
  $stmt = $con->prepare($sql_account) or die ($con->error);
  $stmt->bind_param('s',$uid);
  $stmt->execute();
  $result_account = $stmt->get_result();
  $row = $result_account->fetch_assoc();
  if($row['pre']<7){
    echo'
         <script>
            window.location.href="../404.html";
        </script>
    ';
  }
}
else{
    echo'
     <script>
        window.location.href="../auth/auth-login";
    </script>
    ';
}
?>