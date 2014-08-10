<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (!isset($_SESSION['logged'])) {
if ($_POST[register]) {
if (isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
$username = $_POST[username];
$password = $_POST[pass];
$cpassword = $_POST[cpass];
$email = $_POST[emai1];

$check_username = $mysqli->prepare('SELECT `username` FROM `users` WHERE `username`= ?')or die(mysqli_error());
$check_username->bind_param('s', $username);
$check_username->execute();
$check_username->store_result();  

$check_email = $mysqli->prepare('SELECT `email` FROM `users` WHERE `email`= ?')or die(mysqli_error());
$check_email->bind_param('s', $email);
$check_email->execute();
$check_email->store_result();  

if($username==NULL || $password==NULL || $cpassword==NULL || $email==NULL) {
$message = "<div class=\"message errormsg\"><p>Някое от полетата е празно.</p></div>";
}
else if($password != $cpassword) {
$message = "<div class=\"message errormsg\"><p>Паролите не съвпадат.</p></div>";
}
else if($check_username->num_rows > 0) {
$message = "<div class=\"message errormsg\"><p>Потребителското име е заето.</p></div>";
}
else if($check_email->num_rows > 0) {
$message = "<div class=\"message errormsg\"><p>Имейлът е зает.</p></div>";
}
else if (!preg_match($regex, $email)) {
$message = "<div class=\"message errormsg\"><p>Невалиден имейл.</p></div>";
}
else
{
$register_user = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES(?, ?, ?)")or die(mysqli_error());
$register_user->bind_param('sss', $username, $password, $email);
$register_user->execute();
$message = "<div class=\"message success\"><p>Вие се регистрирахте успешно.</p></div>";
}
$check_email->close();
$check_username->close();
}
else
{
$message = "<div class=\"message info\"><p>Ника и паролата, които въвеждате по-долу се използват и за сървърите.</p></div>";
}
echo $message;
	if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	}
?>
<form method="post" action="">
						<p>
							<label>Потребителско име:</label> <br>
							<input type="text" class="text" value="<?php echo $_POST[username]; ?>" name="username">
						</p>
						
						<p>
							<label>Парола:</label> <br>
							<input type="password" class="text" value="<?php echo $_POST[pass]; ?>" name="pass">
						</p>
						
						<p>
							<label>Повтори паролата:</label> <br>
							<input type="password" class="text" value="<?php echo $_POST[cpass]; ?>" name="cpass">
						</p>
						
						<p>
							<label>Имейл:</label> <br>
							<input type="text" class="text" value="<?php echo $_POST[emai1]; ?>" name="emai1">
						</p>
						
						<center>
						<input name="register" type="submit" class="buttonsub long" value="Регистрация">
						</form>
						<br /><br />
						<hr>
						<input type="submit" name="back" class="buttonsub" value="Назад"/>
						</form>
					
<?php
}
else
{
header('Location:./');
exit();
}
?>