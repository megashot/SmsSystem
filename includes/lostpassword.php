<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	}
if(isset($_POST['lostpassword']))
{
   $user = addslashes($_POST['user']);
   $email =  addslashes(strip_tags(trim($_POST['email'])));
   if (!preg_match($regex, $email))
   {
   echo "<div class=\"message errormsg\"><p>Въведеният имейл адрес е невалиден.<p></div>";
   }
   else
   {
	$check = $mysqli->prepare("SELECT `username`, `email` FROM `users` WHERE `email`= ? AND `username` = ?")or die(mysqli_error());
	$check->bind_param('ss', $email, $user);
	$check->execute();
	$check->bind_result($lostpassword[username], $lostpassword[email]);    
	$check->store_result(); 
   if($check->num_rows > 0)
   {
   $check->fetch();  
    $acckey = md5($lostpassword[username].$timehook);
    $keyexp = $timehook+3600;
	$insert_key = $mysqli->query("INSERT INTO `keys` (username,`key`,vreme) VALUES ('$lostpassword[username]', '$acckey','$keyexp')");
    $subject = "Zabravena parola za $_SERVER[SERVER_NAME]";
    $directory = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$message = "Моля кликнете върху линк-а, за да си възстановите паролата. \nТой е активен само 1 час.
    \nЛинка е -----> http://$directory/?key=$acckey";
   $headers = "From: admin@$_SERVER[SERVER_NAME]" . "\r\n" .
    "Reply-To: http://$_SERVER[SERVER_NAME]" . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email, $subject, $message, $headers);
    echo "<div class=\"message success\"><p>Указания за получаване на нова парола са изпратени на вашия имейл адрес.</p></div>";    
   }else{
   echo "<div class=\"message errormsg\"><p>Потребителското име или имейл адреса не съществуват.<p></div>";
   }     
   }
 }
?>
<form method="post" action="">
<p>
							<label>Потребителско име:</label> <br>
							<input type="text" class="text" name="user">
						</p>
						
						<p>
							<label>Имейл:</label> <br>
							<input type="text" class="text" name="email">
						</p><center>
<input type='submit' class="buttonsub mid" name='lostpassword' value='Изпрати' /><br /><br />
<hr>
						<input type="submit" name="back" class="buttonsub" value="Назад"/></center>
</form>
</center>