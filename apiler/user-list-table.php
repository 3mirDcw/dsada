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

$sql = "SELECT * FROM users";
$stmt = $con->prepare($sql) or die ($con->error);
$stmt->execute();
$users_result = $stmt->get_result();
$totalData = $users_result->num_rows;
$totalFiltered = $totalData;


$sql = "SELECT * FROM users";
if(isset($_REQUEST['search']['value'])){
  $sql .= " WHERE uid LIKE '%" . $_REQUEST['search']['value']. "%' ";
  $sql .= " OR username LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR ip LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR pre LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR bakiye LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR status LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  
}

$stmt = $con->prepare($sql) or die ($con->error);
$stmt->execute();
$users_result = $stmt->get_result();
$totalData = $users_result->num_rows;
$totalFiltered = $totalData;



if(isset($_REQUEST['order']) ){
  $sql .= ' ORDER '.
  $_REQUEST['order'][0]['column'].
  ' '.
  $_REQUEST['order'][0]['dir'].
  ' ';
}else{
  $sql .= ' ORDER BY uid DESC ';
}


if($_REQUEST['length'] != -1){
  $sql .= ' LIMIT '.
  $_REQUEST['start'].
  ' ,'.
  $_REQUEST['length'].
  ' ';
}






$stmt = $con->prepare($sql) or die ($con->error);
$stmt->execute();
$users_result = $stmt->get_result();

$data = [];

while($row = $users_result->fetch_assoc()){

  if($row['status'] == 'ACTIVE'){
    $status = '<span class="badge badge-light-success">'.$row['status'].'</span>';
  }else{
    $status = '<span class="badge badge-light-danger">'.$row['status'].'</span>';
  }
  $duzenlebut = '<a href="kullanicigoruntule.php?kid='.$row['uid'].'" class="btn btn-primary"> Edit </a>';
  $subdata = [];
  $subdata[] = $row['uid'];
  $subdata[] = $row['username'];
  $subdata[] = $row['ip'];
  $subdata[] = $row['pre'];
  $subdata[] = $row['bakiye'];
  $subdata[] = $status;
  $subdata[] = $duzenlebut;


  $data[] = $subdata;

}


$json_data = [
  // 'draw' => intval($_REQUEST['draw']),
  'recordsTotal' => intval($totalData),
  'recordsFiltered' => intval($totalFiltered),
  'data' => $data,
];

echo json_encode($json_data);












?>