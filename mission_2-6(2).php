<?php

$datafile = 'mission_2-6(2).txt';

function h($s){
return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

//���ʂ̓��e
if(isset($_POST['submit']) && !isset($_POST['henshu'])) { //henshu���Ȃ����̑��M
   $name    = $_POST['name'];//post���M���ꂽname���擾
   $comment = $_POST['comment'];//post���M���ꂽcomment���擾
   $date    = date('y/m/d H:i:s');//date���擾
   $pass    = $_POST['pass'];
//���O���󗓂ő��M���ꂽ�疢���͂ƕ\��
   if ($comment !== ''){
	$name = ($name === '') ? '������' : $name;

  $fp = fopen($datafile, 'a');//$datafile��ǋL���[�h�ŊJ��
	$lines = file('mission_2-6(2).txt');//file���e��z��Ɋi�[
	$cnt = count($lines);//�ŏI�s�܂ŃJ�E���g
	$cnt += 1;//��s���ƂɃJ�E���g���𑝂₵�Ă���
        $a = ($cnt."<>".$name."<>".$comment."<>". $date."\n");//�t�@�C���ɏ������ޓ��e
	$a_pass =  ($cnt."<>".$name."<>".$comment."<>". $date."<>".$pass."\n");
	$a_pass = rtrim($a_pass);
//echo "check1|".$a."|<hr>";
   fwrite($fp, $a_pass);//$datafile��$a����������
   fclose($fp);//$datafile�����
  }//if$comment !
}//if isset

$posts = file($datafile);//mission_2-2.txt��z��Ɋi�[

//�폜�{�^������������
if(isset($_POST['delete'])){
   for($i=0; $i<count($posts); $i++){//�ŏI�s�܂Ń��[�v
   $items = explode("<>", $posts[$i]);//$a���p�[�c���Ƃɕ���
     if($items[0] == $_POST['deleteNo']){ //�����s�ԍ��ƍ폜�w��ԍ�����v������
	array_splice($posts, $i, 1);//�I�������s���폜
	file_put_contents($datafile, $posts);//$datafile�Ɍ��ʂ������o��
}
}
}

//�ҏW
//echo "check2|".isset($_POST['submit'])."|<hr>";
//echo "check3|".isset($_POST['henshu'])."|<hr>";
if(isset($_POST['submit']) && isset($_POST['henshu'])) {//'henshu'������Ƃ��̑��M

   for($i=0; $i<count($posts); $i++){//�ŏI�s�܂Ń��[�v
//echo "check4|".$i."|<hr>";
//echo "check12|".$ano."|<hr>";

	$parts = explode("<>", $posts[$i]);//�s��<>�ŕ���
	$ano = $_POST['editNo'];//editNo���󂯂Ƃ�ϐ��ɓ����
	$name = $_POST['name'];//name���󂯂Ƃ�ϐ��ɓ����
	$comment = $_POST['comment'];//comment���󂯂Ƃ�ϐ��ɓ����
	$date = date('y/m/d H:i:s');//date��ϐ��ɓ����

//echo "check18|".$ano."|<hr>";
//echo "check7|".$parts[0] == $ano."|<hr>";
if($parts[0] == $ano){//���e�ԍ��ƕҏW�Ώ۔ԍ����r
//$newline�ɒu������

//echo "check5|".isset($_POST['name'])."|".isset($_POST['comment'])."|<hr>";
	if(isset($_POST['name']) && isset($_POST['comment'])){//�����s�ԍ��ƕҏW�w��ԍ�����v������
	   $newline =$ano."<>".$name."<>".$comment."<>". $date."\n";//�V�����������ޓ��e
//echo "check8|".$newline."|<hr>";

	   array_splice($posts, $i, 1, $newline); //�w��s����$newline�ɒu������
//echo "check9|".array_splice($posts, $i, 1, $newline)."|<hr>";

}//ifnemecomment
}//$parts[0] == $ano
}//for
$fp1 = fopen($datafile, 'w');//$datafile���������݃��[�h�ŊJ��
//echo "check10|".$fp1."|<hr>";

flock($fp1, LOCK_EX);//�t�@�C�������b�N
foreach($posts as $post){//�z��̌������[�v
fputs($fp1, $post);//$datafile�ɏ�������
}//foreach
flock($fp1, LOCK_UN);//�t�@�C�����A�����b�N
fclose($fp1);//�t�@�C������
}//if henshu


?>
		


<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = "UFT-8">
<title>�C���^�[��</title>
</head>
<body>
  <h1>�v���O���~���O�u���O</h1>

<?php
if(!isset($_POST['edit'])) {//�ҏW�{�^����������Ȃ��Ƃ�
?>
  <form action = "mission_2-6(2).php" method = "post">
     ���O<br>	
	<input type="text" name="name"><br />
     �R�����g<br />
	<input type="text" name="comment"><br />
     pass
		<input type="text" name="pass"><br />

     <input type="submit" name="submit" value="���M"><br /><br /><br />
</form>
<?php
}//if edit
?>



<?php
//�ҏW�{�^����������
//echo "check11|".isset($_POST['edit'])."|<hr>";
if(isset($_POST['edit'])){
   $ano=$_POST['editNo'];//�ҏW�w��ԍ���$ano�ɓ����
//echo "check12|".$ano."|<hr>";

	for($i=0; $i<count($posts); $i++){//�ŏI�s�܂Ń��[�v
//echo "check13|".$i."|<hr>";

	   $parts = explode("<>", $posts[$i]);//�s��<>�ŕ���
//echo "check14|".$parts."|<hr>";


//echo "check15|".$parts[0] == $ano."|<hr>";
	   if($parts[0] == $ano){//�����s�ԍ��ƕҏW�w��ԍ�����v������
		$name_a = $parts[1];//�z��̒l���擾
		$comment_a = $parts[2];//�z��̒l���擾
//echo "check16|".$name_a."|<hr>";
//echo "check17|".$comment_a."|<hr>";


?>
  <form action = "mission_2-6(2).php" method = "post">
     ���O<br>	
<?php echo "<input type='text' name='name' value='". $name_a ."'><br />"; ?>
     �R�����g<br />
<?php echo "<input type='text' name='comment' value='". $comment_a ."'><br />";?>
     �ҏW�s�ԍ�<br>
<?php echo "<input type='text' name='editNo' size='5' value='".$ano."'><br />";?>

     <input type="submit" name="submit" value="���M"><br /><br /><br />
<?php echo "<input type='hidden' name='henshu' value='". $ano ."'>"; ?>
</form>

<?php

}
}
}
?>

 <form action = "mission_2-6(2).php" method = "post">
     �폜�Ώ۔ԍ�<br>
     <input type="text" name="deleteNo" size="5">
     <input type="text" name="deletePa" size="5">
     <input type="submit" name="delete" value="�폜"><br />
</form>
  <form action = "mission_2-6(2).php" method = "post">
     �ҏW�Ώ۔ԍ�<br>
     <input type="text" name="editNo" size="5">
     <input type="submit" name="edit" value="�ҏW"><br />
<?php echo "<input type='hidden' name='uwagaki' value='". $ano ."'>"; ?>
</form>


  <h2>���e�ꗗ</h2>
  <?php if (count($posts)) : ?>
	 <?php foreach ($posts as $post) :?>
	 <?php list($cnt, $name, $comment, $date) = explode("<>", $post); ?>
  	 <?php echo h($cnt); ?>: <?php echo h($name); ?> <?php echo h($comment); ?> - <?php echo h($date);?> <br /> 
 	 <?php endforeach; ?>
	 <?php endif; ?>

</body>
</html>

