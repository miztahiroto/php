<?php

$dsn = 'mysql:dbname=co_751_it_3919_com;host=localhost';
$user = 'co-751.it.3919.c';
$password = 'Yvy85hE';

//Ú‘±
$pdo = new PDO($dsn, $user, $password);

//ƒe[ƒuƒ‹ì¬
$sql = 'CREATE TABLE asd
(
id int(11) AUTO_INCREMENT PRIMARY KEY,
name varchar(255) UNIQUE KEY NOT NULL,
comment varchar(255),
image BLOB,
date datetime NOT NULL,
pass varchar(225) NOT NULL
)ENGINE=MyISAM DEFAULT CHARSET=utf8';

$result = $pdo->query($sql);

?>