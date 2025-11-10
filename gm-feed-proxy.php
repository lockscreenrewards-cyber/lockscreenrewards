<?php
// gm-feed-proxy.php — يسحب JSON من GameMonetize ويعيده للمتصفح لتجاوز CORS
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

$qs = $_SERVER['QUERY_STRING'] ?? '';
$feed = isset($_GET['__feed']) ? $_GET['__feed'] : 'https://gamemonetize.com/feed.php';

// ازل بارامتر __feed من الاستعلام النهائي
$qs = preg_replace('/(^|&)__feed=[^&]*/', '', $qs);
$qs = ltrim($qs, '&');

$url = $feed . (strpos($feed,'?') !== false ? '&' : '?') . $qs;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$out = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($status ?: 200);
echo $out ?: '[]';
