<?php

$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';

$pdo = new PDO($dsn, $user, $password);//接続情報
$stmt = $pdo->query('SET NAEMS utf8');

//show create tableを使用
$stmt = $pdo->query('SHOW CREATE TABLE kkreino');
foreach ($stmt as $re){
   print_r($re);

}
?>