<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
if(isset($_GET['key']) && strlen($_GET['key'])==32)
{
  $kacc = $_GET['key'];
  $arr1 = array('"', "'", "+", "-", "@", "%", ">", "<","(",")","--");
  $arr2 = array('','','','','','','','','','');
  $keyacc = str_replace($arr1,$arr2,$kacc);
  $checkkey = $mysqli->prepare("SELECT `username` FROM `keys` WHERE `key` = ?")or die(mysqli_error());
  $checkkey->bind_param('s', $keyacc);
  $checkkey->execute();
  $checkkey->bind_result($cp[username]);    
  $checkkey->store_result(); 
  if($checkkey->num_rows > 0)
  {
  $checkkey->fetch(); 
     $newpass = rand(1500,15874054);
	 if ($md5_password)
	 {
	 $newpass = md5($newpass);
	 }
	 $insert = $mysqli->query("UPDATE `users` SET `password`='$newpass' WHERE `username`='$cp[username]'");
	 $mail_query = $mysqli->query("SELECT `email` FROM `users` WHERE `username`='$cp[username]'");
	 $mail = $mail_query->fetch_assoc();
     $subject = "Nova aprola za $_SERVER[SERVER_NAME]";
     $message = "Novata parola za $_SERVER[SERVER_NAME] e: $newpass";
    $headers = "From: admin@$_SERVER[SERVER_NAME]" . "\r\n" .
    "Reply-To: http://$_SERVER[SERVER_NAME]" . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
   mail($mail[email], $subject,$message,$headers);
   echo "<div class=\"message success\"><p>Новата парола току що беше изпратена на вашия имейл.<p></div>";
	$delete_key = $mysqli->query("DELETE FROM `keys` WHERE `username`='$cp[username]'");   
  }else{
   header('Location: ./?p=lostpassword');
   exit;
  }
 }else{
header('Location: ./?p=lostpassword');
exit;
}
 if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	} ?>
	<form method="post" action="">
	<hr>
	<center><input type="submit" name="back" class="buttonsub" value="Назад"/></center>
	</form>