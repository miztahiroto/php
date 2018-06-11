<?php

header('Context-Type: text/html; charset=UTF-8');

//セッション開始
session_start();

//DB接続
$dsn = 'mysql:dbname=co_751_it_3919_com;host=localhost;charset=utf8;';
$user = 'co-751.it.3919.c';
$password = 'Yvy85hE';
$pdo = new PDO($dsn, $user, $password);

//ログイン
$log_name = $_POST['logname'];
$log_pass = md5($_POST['logpass']);

//ログインボタン押した時
if($_POST['login']){
    $log_sql = $pdo->prepare("SELECT * FROM mok WHERE name ='$log_name'");
    $log_sql ->execute();

    while ($row = $log_sql->fetch(PDO::FETCH_ASSOC)){

//DBのpassと送信したpass値が一致した時
    if($log_pass == $row['pass']){

//認証成功したとき、セッションIDを発行する
	session_regenerate_id(true);
	$_SESSION["LOGNAME"] = $_POST["logname"];
	header("location: mission_3-8.php");
	exit();
}else{
	echo 'ログインできませんでした。';
}//pass
}//while
}//submit

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<title>インターン</title>
</head>
<body>
   <form action="mission_3-7.php" method="post">
   <h1>ユーザログイン</h1>
   名前　　　：<input type="text" name="logname"><br>
   パスワード：<input type="text" name="logpass"><br>
   <input type="submit" name="login" value="ログイン"><br><br>
   </form>

   <form action="mission_3-6.php" method="post">
   ユーザ登録されていない方<br>
   <input type="submit" name="touroku" value="新規登録">
   </form>
</body>
</html>
