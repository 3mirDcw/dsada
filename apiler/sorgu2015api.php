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
if($row['pre']<1){

header("Location:/404.html");

}}else{

  header("Location:/auth/auth-login");
}
include_once 'baglanv2.php';

if($_POST){
if(!empty($_POST['ad']) && !empty($_POST['soyad']) && empty($_POST['adresil']) && empty($_POST['anaadi']) && empty($_POST['babaadi'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE ADI='$ad' and SOYADI='$soyad'";
}
else if(!empty($_POST['ad']) && !empty($_POST['soyad']) && !empty($_POST['adresil'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $adresil = $_POST['adresil'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE ADI='$ad' and SOYADI='$soyad' and ADRESIL='$adresil'";
}
else if(!empty($_POST['ad']) && !empty($_POST['soyad']) && !empty($_POST['babaadi']) && empty($_POST['anaadi'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $babaadi = $_POST['babaadi'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE ADI='$ad' and SOYADI='$soyad' and BABAADI='$babaadi'";
}
else if(!empty($_POST['ad']) && !empty($_POST['soyad']) && !empty($_POST['anaadi']) && empty($_POST['babaadi'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $anaadi = $_POST['anaadi'];
  $babaadi = $_POST['babaadi'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE ADI='$ad' and SOYADI='$soyad' and ANAADI='$anaadi'";
}
else if(!empty($_POST['ad']) && !empty($_POST['soyad']) && !empty($_POST['anaadi'])&& !empty($_POST['babaadi'])){
  $ad = $_POST['ad'];
  $soyad = $_POST['soyad'];
  $anaadi = $_POST['anaadi'];
  $babaadi = $_POST['babaadi'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE ADI='$ad' and SOYADI='$soyad' and ANAADI='$anaadi' and BABAADI='$babaadi'";
}
else if(!empty($_POST['tc'])){
  $tc = $_POST['tc'];
  $start = $_REQUEST['start'];
  $len = $_REQUEST['length'];
  $sql = "SELECT * FROM secmen2015 WHERE TC='$tc'";
}
else{
  $data = [];
  $json_data = [
    'draw' => intval($_REQUEST['draw']),
    'recordsTotal' => intval('0'),
    'recordsFiltered' => intval('0'),
    'data' => $data,
  ];
  
  exit(json_encode($json_data));
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
}

if($_REQUEST['length'] != -1){
  $sql .= ' LIMIT '.
  $start.
  ' ,'.
  $len.
  ' ';
}


$stmt = $con->prepare($sql) or die ($con->error);
$stmt->execute();
$users_result = $stmt->get_result();
$data = [];

while($row = $users_result->fetch_assoc()){

  $subdata = [];
  $subdata[] = $row['TC'];
  $subdata[] = $row['ADI'];
  $subdata[] = $row['SOYADI'];
  $subdata[] = $row['ANAADI'];
  $subdata[] = $row['BABAADI'];
  $subdata[] = $row['DOGUMYERI'];
  $subdata[] = $row['DOGUMTARIHI'];
  $subdata[] = $row['CINSIYETI'];
  $subdata[] = $row['NUFUSILI'];
  $subdata[] = $row['NUFUSILCESI'];
  $subdata[] = $row['ADRESIL'];
  $subdata[] = $row['ADRESILCE'];
  $subdata[] = $row['MAHALLE'];
  $subdata[] = $row['CADDE'];
  $subdata[] = $row['KAPINO'];
  $subdata[] = $row['DAIRENO'];


  $data[] = $subdata;

}


$json_data = [
  'draw' => intval($_REQUEST['draw']),
  'recordsTotal' => intval($totalData),
  'recordsFiltered' => intval($totalFiltered),
  'data' => $data,
];

echo json_encode($json_data);
}
else{
  $data = [];
  $json_data = [
    'draw' => intval($_REQUEST['draw']),
    'recordsTotal' => intval('1'),
    'recordsFiltered' => intval('1'),
    'data' => $data,
  ];
  
  exit(json_encode($json_data));
}




?>