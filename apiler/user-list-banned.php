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

$sql = "SELECT * FROM banned_table";
$stmt = $con->prepare($sql) or die ($con->error);
$stmt->execute();
$users_result = $stmt->get_result();
$totalData = $users_result->num_rows;
$totalFiltered = $totalData;


$sql = "SELECT * FROM banned_table";
if(isset($_REQUEST['search']['value'])){
  $sql .= " WHERE id LIKE '%" . $_REQUEST['search']['value']. "%' ";
  $sql .= " OR ip_address LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR banned LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR login_count LIKE '%" .$_REQUEST['search']['value']. "%' "; 
  $sql .= " OR sebep LIKE '%" .$_REQUEST['search']['value']. "%' ";  
  
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
  $sql .= ' ORDER BY id DESC ';
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

  $silbut = '<button onclick="unban()" id="buttondel" class="btn ml-1 btn-outline-danger" value="'.$row['id'].'"> Ban Kaldır </button>';

  $subdata = [];
  $subdata[] = $row['id'];
  $subdata[] = $row['ip_address'];
  $subdata[] = $row['banned'];
  $subdata[] = $row['login_count'];
  $subdata[] = $row['sebep'];
  $subdata[] = $silbut;



  $data[] = $subdata;

}


$json_data = [
  'draw' => intval($_REQUEST['draw']),
  'recordsTotal' => intval($totalData),
  'recordsFiltered' => intval($totalFiltered),
  'data' => $data,
];

echo json_encode($json_data);












?>