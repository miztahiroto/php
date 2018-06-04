<?php

$datafile = 'mission_2-6(2).txt';

function h($s){
return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

//普通の投稿
if(isset($_POST['submit']) && !isset($_POST['henshu'])) { //henshuがない時の送信
   $name    = $_POST['name'];//post送信されたnameを取得
   $comment = $_POST['comment'];//post送信されたcommentを取得
   $date    = date('y/m/d H:i:s');//dateを取得
   $pass    = $_POST['pass'];
//名前が空欄で送信されたら未入力と表示
   if ($comment !== ''){
	$name = ($name === '') ? '未入力' : $name;

  $fp = fopen($datafile, 'a');//$datafileを追記モードで開く
	$lines = file('mission_2-6(2).txt');//file内容を配列に格納
	$cnt = count($lines);//最終行までカウント
	$cnt += 1;//一行ごとにカウント数を増やしていく
        $a = ($cnt."<>".$name."<>".$comment."<>". $date."\n");//ファイルに書き込む内容
	$a_pass =  ($cnt."<>".$name."<>".$comment."<>". $date."<>".$pass."\n");
	$a_pass = rtrim($a_pass);
//echo "check1|".$a."|<hr>";
   fwrite($fp, $a_pass);//$datafileに$aを書き込み
   fclose($fp);//$datafileを閉じる
  }//if$comment !
}//if isset

$posts = file($datafile);//mission_2-2.txtを配列に格納

//削除ボタンを押した時
if(isset($_POST['delete'])){
   for($i=0; $i<count($posts); $i++){//最終行までループ
   $items = explode("<>", $posts[$i]);//$aをパーツごとに分解
     if($items[0] == $_POST['deleteNo']){ //もし行番号と削除指定番号が一致したら
	array_splice($posts, $i, 1);//選択した行を削除
	file_put_contents($datafile, $posts);//$datafileに結果を書き出す
}
}
}

//編集
//echo "check2|".isset($_POST['submit'])."|<hr>";
//echo "check3|".isset($_POST['henshu'])."|<hr>";
if(isset($_POST['submit']) && isset($_POST['henshu'])) {//'henshu'があるときの送信

   for($i=0; $i<count($posts); $i++){//最終行までループ
//echo "check4|".$i."|<hr>";
//echo "check12|".$ano."|<hr>";

	$parts = explode("<>", $posts[$i]);//行を<>で分割
	$ano = $_POST['editNo'];//editNoを受けとり変数に入れる
	$name = $_POST['name'];//nameを受けとり変数に入れる
	$comment = $_POST['comment'];//commentを受けとり変数に入れる
	$date = date('y/m/d H:i:s');//dateを変数に入れる

//echo "check18|".$ano."|<hr>";
//echo "check7|".$parts[0] == $ano."|<hr>";
if($parts[0] == $ano){//投稿番号と編集対象番号を比較
//$newlineに置き換え

//echo "check5|".isset($_POST['name'])."|".isset($_POST['comment'])."|<hr>";
	if(isset($_POST['name']) && isset($_POST['comment'])){//もし行番号と編集指定番号が一致したら
	   $newline =$ano."<>".$name."<>".$comment."<>". $date."\n";//新しく書き込む内容
//echo "check8|".$newline."|<hr>";

	   array_splice($posts, $i, 1, $newline); //指定行消し$newlineに置き換え
//echo "check9|".array_splice($posts, $i, 1, $newline)."|<hr>";

}//ifnemecomment
}//$parts[0] == $ano
}//for
$fp1 = fopen($datafile, 'w');//$datafileを書き込みモードで開く
//echo "check10|".$fp1."|<hr>";

flock($fp1, LOCK_EX);//ファイルをロック
foreach($posts as $post){//配列の個数分ループ
fputs($fp1, $post);//$datafileに書き込み
}//foreach
flock($fp1, LOCK_UN);//ファイルをアンロック
fclose($fp1);//ファイル閉じる
}//if henshu


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
  <form action = "mission_2-6(2).php" method = "post">
     名前<br>	
	<input type="text" name="name"><br />
     コメント<br />
	<input type="text" name="comment"><br />
     pass
		<input type="text" name="pass"><br />

     <input type="submit" name="submit" value="送信"><br /><br /><br />
</form>
<?php
}//if edit
?>



<?php
//編集ボタン押した時
//echo "check11|".isset($_POST['edit'])."|<hr>";
if(isset($_POST['edit'])){
   $ano=$_POST['editNo'];//編集指定番号を$anoに入れる
//echo "check12|".$ano."|<hr>";

	for($i=0; $i<count($posts); $i++){//最終行までループ
//echo "check13|".$i."|<hr>";

	   $parts = explode("<>", $posts[$i]);//行を<>で分割
//echo "check14|".$parts."|<hr>";


//echo "check15|".$parts[0] == $ano."|<hr>";
	   if($parts[0] == $ano){//もし行番号と編集指定番号が一致したら
		$name_a = $parts[1];//配列の値を取得
		$comment_a = $parts[2];//配列の値を取得
//echo "check16|".$name_a."|<hr>";
//echo "check17|".$comment_a."|<hr>";


?>
  <form action = "mission_2-6(2).php" method = "post">
     名前<br>	
<?php echo "<input type='text' name='name' value='". $name_a ."'><br />"; ?>
     コメント<br />
<?php echo "<input type='text' name='comment' value='". $comment_a ."'><br />";?>
     編集行番号<br>
<?php echo "<input type='text' name='editNo' size='5' value='".$ano."'><br />";?>

     <input type="submit" name="submit" value="送信"><br /><br /><br />
<?php echo "<input type='hidden' name='henshu' value='". $ano ."'>"; ?>
</form>

<?php

}
}
}
?>

 <form action = "mission_2-6(2).php" method = "post">
     削除対象番号<br>
     <input type="text" name="deleteNo" size="5">
     <input type="text" name="deletePa" size="5">
     <input type="submit" name="delete" value="削除"><br />
</form>
  <form action = "mission_2-6(2).php" method = "post">
     編集対象番号<br>
     <input type="text" name="editNo" size="5">
     <input type="submit" name="edit" value="編集"><br />
<?php echo "<input type='hidden' name='uwagaki' value='". $ano ."'>"; ?>
</form>


  <h2>投稿一覧</h2>
  <?php if (count($posts)) : ?>
	 <?php foreach ($posts as $post) :?>
	 <?php list($cnt, $name, $comment, $date) = explode("<>", $post); ?>
  	 <?php echo h($cnt); ?>: <?php echo h($name); ?> <?php echo h($comment); ?> - <?php echo h($date);?> <br /> 
 	 <?php endforeach; ?>
	 <?php endif; ?>

</body>
</html>

