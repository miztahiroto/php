<?php

$dsn = '�f�[�^�x�[�X��';
$user = '���[�U��';
$password = '�p�X���[�h';

$pdo = new PDO($dsn, $user, $password);//�ڑ����
$stmt = $pdo->query('SET NAEMS utf8');

//show create table���g�p
$stmt = $pdo->query('SHOW CREATE TABLE kkreino');
foreach ($stmt as $re){
   print_r($re);

}
?>