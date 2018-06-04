<?php
//文字コード指定
header('Context-Type: text/html; charset=UTF-8');

session_start();
$hoji = $_SESSION["LOGNAME"];

//ログイン状態のチェック
if(!isset($_SESSION["LOGNAME"])){
   header("location: mission_3-7.php");
   exit();
}

//mysql接続
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);

//ログインユーザ情報
echo "『${hoji}』でログイン中<br />";

//投稿
if(isset($_POST['submit']) && !isset($_POST['henshu']) && !empty($_POST['name'])) {
   $name    = $_POST['name'];
   $comment = $_POST['comment'];
   $date    = date('y/m/d H:i:s');
   $pass    = $_POST['pass'];

//データベースに値を挿入
$sql="INSERT INTO colors (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)";
$stmt = $pdo->prepare($sql);
$params = array(':name' => $name, ':comment' => $comment, ':date' => $date, ':pass' => $pass);
$stmt ->execute($params);
}//if isset

//削除ボタンを押した時
if(isset($_POST['delete'])){

   $delNo = $_POST['deleteNo'];
   $delPa = $_POST['deletePa'];

   $sql = $pdo->prepare("SELECT * FROM colors WHERE id =$delNo");
   $sql ->execute();

   while ($row = $sql->fetch(PDO::FETCH_ASSOC)){

//DBのpassと削除passが一致したとき
      if($delPa == $row['pass']){
	$del_sql = "DELETE FROM colors WHERE id = :id";
	$del_stmt = $pdo->prepare($del_sql);
   	$params = array(':id'=>$delNo);
   	$del_stmt->execute($params);
	
	echo '削除成功！！！！！';
} else {
	echo '削除失敗';
}
}//while
}//if isset

//編集
//'henshu'があるときの投稿
if(isset($_POST['submit']) && isset($_POST['henshu'])) {

	$name 	 = $_POST['name'];
	$comment = $_POST['comment'];
	$date 	 = date('y/m/d H:i:s');
   	$pass    = $_POST['pass'];
	$ano 	 = $_POST['editNo'];
	$bno 	 = $_POST['editPa'];

//投稿番号と編集対象番号を比較
   	$sql = $pdo->prepare("SELECT * FROM colors WHERE id =id");
   	$sql ->execute();

//1行取り出し
	while ($row = $sql->fetch(PDO::FETCH_ASSOC)){

//name, commentの再送信
	if(isset($_POST['name']) && isset($_POST['comment'])){

		   $edit_sql = "UPDATE colors SET name = :name, comment = :comment, pass = :pass WHERE id = :id";
		   $edit_stmt = $pdo->prepare($edit_sql);
		   $params = array(':name' => $name, ':comment' => $comment, ':pass' => $pass,':id' => $ano);
		   $edit_stmt ->execute($params);
}//if再送信
}//while
	echo '編集成功！！！！！';
}//ifisset

?>


<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<title>インターン</title>
</head>
<body>
  <h1>プログラミングブログ</h1>
<?php
if(!isset($_POST['edit'])) {//編集ボタンが押されないとき
?>
  <form action = "mission_main.php" method = "post">
     名前<br>	
<?php echo "<input type='text' name='name' value='". $hoji ."'><br />"; ?>
     コメント<br />
	<input type="text" name="comment"><br />
     パスワード<br>	
	<input type="text" name="pass" size="5"><br />

	<input type="submit" name="submit" value="送信"><br /><br />
</form>
<?php
}//if edit
?>

<?php
//編集ボタンを押したとき
if(isset($_POST['edit'])){
   $ano=$_POST['editNo'];
   $bno=$_POST['editPa'];

//投稿番号と編集対象番号を比較
   $edit_sql = $pdo->prepare("SELECT * FROM colors WHERE id =$ano");
   $edit_sql ->execute();

   while ($row = $edit_sql->fetch(PDO::FETCH_ASSOC)){

//DBのpassと編集passが一致したとき
      	if($bno == $row['pass']){

//配列の値を取得
	$name_a    = $row['name'];
	$comment_a = $row['comment'];

?>
  <form action = "mission_main.php" method = "post">
     名前<br>	
<?php echo "<input type='text' name='name' value='". $name_a ."'><br />"; ?>
     コメント<br />
<?php echo "<input type='text' name='comment' value='". $comment_a ."'><br />";?>
     編集対象番号／パスワード<br>
<?php echo "<input type='text' name='editNo' size='5' value='".$ano."'>";?> 
<?php echo "<input type='text' name='editPa' size='5' value='".$bno."' disabled='disabled'><br />";?>

     <input type="submit" name="submit" value="送信"><br /><br />
<?php echo "<input type='hidden' name='henshu' value='". $ano ."'>"; ?>
</form>

<?php

}//ifパスの一致
}//while
}//isset edit
?>

 <form action = "mission_main.php" method = "post">
     削除対象番号／パスワード<br>
     <input type="text" name="deleteNo" size="5">
     <input type="text" name="deletePa" size="5"><br />
     <input type="submit" name="delete" value="削除"><br />
</form>
  <form action = "mission_main.php" method = "post">
     編集対象番号／パスワード<br>
     <input type="text" name="editNo" size="5">
     <input type="text" name="editPa" size="5"><br />
     <input type="submit" name="edit" value="編集"><br />
<?php echo "<input type='hidden' name='uwagaki' value='". $ano ."'>"; ?>
</form>


  <h2>投稿一覧</h2>
<?php
$sql = 'SELECT * FROM colors';
$result = $pdo->query($sql);
foreach($result as $row){
   echo $row['id'].': ';
   echo $row['name'].' ';
   echo $row['comment'].' ';
   echo $row['date'].'<br>';
}//foreach
?>

 <form action = "mission_main.php" method = "post">
 <input type="submit" name="logout" value="ログアウト"><br /><br />
</body>
</html>


<?php
//ログアウト処理
if(!empty($_POST['logout'])){

//セッションの値を初期化
   $_SESSION = array();
//セッションクッキーの削除
   setcookie(session_name, '', time()-60);
//セッションを破棄
   session_destroy();
}
?>
