<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$origin = "";
$method = "";
$headers = "";

if(isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];
}
if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
    $method = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'];
}
if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
    $headers = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
}

/* ここに$origin、$method、$headersをチェックする処理を入れる */

header('Access-Control-Allow-Origin: ' . $origin);
header('Access-Control-Allow-Method: ' . $method);
header('Access-Control-Allow-Headers: ' . $headers);

$json = array(
    array('name'=>'Google', 'url'=>'https://www.google.co.jp/'),
    array('name'=>'Yahoo!', 'url'=>'http://www.yahoo.co.jp/'),
);
 
header("Content-Type: text/javascript; charset=utf-8");
echo json_encode($json); // 配列をJSON形式に変換してくれる


?>