<?php

header('Context-Type: text/html; charset=UTF-8');

//DB接続
$dsn = 'mysql:dbname=co_751_it_3919_com;host=localhost;charset=utf8;';
$user = 'co-751.it.3919.c';
$password = 'Yvy85hE';
$pdo = new PDO($dsn, $user, $password);

//パス、確認パスの一致確認
//不一致のときはプログラム終了
$pass = md5($_POST['pass']);
$pass2 = md5($_POST['pass2']);
$name = $_POST['name'];

//パス、確認パスが一致しているか
if($pass !=$pass2){
    echo '<font color="RED">パスワードが一致しません。もう一度登録しなおしてください。</font><br>';
}

//フォームのチェック
    if(isset($_POST['submit'])){
//nameが未入力のとき
    	if(empty($_POST['name'])){
    	    echo '<font color="RED">登録に失敗しました。<br>名前を入力してください。</font><br>';
}//name
//passが未入力のとき
    	    if(empty($_POST['pass'])){
    		echo '<font color="RED">登録に失敗しました。<br>パスワードを入力してください。</font><br>';
}//pass
		if($pass == $pass2){
			if(!empty($_POST['name']) && !empty($_POST['pass'])){

//データベースに値を挿入
			   	$sql="INSERT INTO mok(name, pass) VALUES (:name, :pass)";
			   	$stmt = $pdo->prepare($sql);
			   	$params = array(':name' => $name, ':pass' => $pass);
			   	$stmt ->execute($params);
   echo '登録完了';
}//ifname
}//ifpass
}//ifsubmit
?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<title>インターン</title>
</head>
<body>

   <form action="mission_3-6.php" method="post">
   <h1>ユーザ登録</h1>
   名前　　　：<input type="text" name="name"><br>
   パスワード：<input type="text" name="pass"><br>
   確認用パス：<input type="text" name="pass2"><br>
   <input type="submit" name="submit" value="登録"><br>
   </form>

   <form action="mission_3-7.php" method="post">
   <input type="submit" value="ログインページへ"><br>

  <h2>ユーザ一覧</h2>
<?php
$sql = 'SELECT * FROM mok';
$result = $pdo->query($sql);
foreach($result as $row){
   echo $row['id'].': ';
   echo $row['name'].'<br>';

}//foreach
?>

</body>
</html>
