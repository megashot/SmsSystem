<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
   ?>
						<p>
							<label>Потребител:</label> <br>
							<input type="text" class="text" disabled=yes value="<?php echo $logged[username]; ?>">
						</p>
						
						<p>
							<label>Имейл:</label> <br>
							<input type="text" class="text" disabled="yes" value="<?php echo $logged[email]; ?>">
						</p>
<br /><hr></hr>
<?php
if ($md5_password) {
$password = md5($_POST['password']);
}
else
{
$password = $_POST['password'];
}
$newpassword = $_POST['newpassword'];
$confirmpassword = $_POST['confirmpassword'];
if (isset($_POST['changepassword'])) {
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
if($logged[password] == $password){
    if($newpassword==$confirmpassword){
	if($newpassword != NULL || $confirmpassword != NULL){
	if ($md5_password) {
	$newpassword = md5($newpassword);
	}
	$changepassword_query = $mysqli->prepare("UPDATE `users` SET `password`= ? where `username`='$logged[username]'")or die(mysqli_error());
	$changepassword_query->bind_param('s', $newpassword);
	$changepassword_query->execute();
	$changepassword_query->close();  
	echo "<div class=\"message success\"><p>Паролата бе успешно променена.</p></div>";	
	}
	else
	{
	echo "<div class=\"message errormsg\"><p>Полетата <i>Нова парола</i> или <i>Повторете новата парола</i> са празни.</p></div>";
	}
    } else {
        echo "<div class=\"message errormsg\"><p><i>Нова парола</i> и <i>Повторете новата парола</i> са различни.</p></div>";
    }
	} else {
		echo "<div class=\"message errormsg\"><p>Въведената <i>текущата парола</i> е различна от вашата.</p></div>"; 	
	}
}
if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	}
?>
<form action="" method="post">
						<p>
							<label>Текуща парола:</label> <br>
							<input type="text" class="text" value="<?php echo $_POST[password]; ?>" name="password">
						</p>
						
						<p>
							<label>Нова парола:</label> <br>
							<input type="text" class="text" value="<?php echo $_POST[newpassword]; ?>" name="newpassword">
						</p>
							<p>
							<label>Повторете новата парола:</label> <br>
							<input type="text" class="text" value="<?php echo $_POST[confirmpassword]; ?>" name="confirmpassword">
						</p>
						
						<center>
						<input type="submit" class="buttonsub" name="changepassword" value="Промени">
						</form>
						<br /><br /><hr>
						<input type="submit" name="back" class="buttonsub" value="Назад"/></center>