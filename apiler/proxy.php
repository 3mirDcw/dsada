<?php
// $f_contents = file("proxy.txt"); 
// $proxy = $f_contents[rand(0, count($f_contents) - 1)];
$proxy = "191.96.42.80:8080";
$url = 'http://ip-api.com/json/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
echo $proxy;
$curl_scraped_page = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
echo "<br>".$info['http_code']."<br>";
echo $curl_scraped_page;
?>