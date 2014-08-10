<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (!isset($_SESSION['logged']))
{
if (isset($_POST[login])) { 
$username = $_POST['username'];
if ($md5_password) {
$password = md5($_POST['password']);
}
else
{
$password = $_POST['password'];
}
$login_query = $mysqli->prepare('SELECT `username` FROM `users` WHERE `username`= ? AND `password` = ?' )or die(mysqli_error());
$login_query->bind_param('ss', $username, $password);
$login_query->execute();
$login_query->bind_result($safe_username);
$login_query->store_result();                
$login_query->fetch();                
if($login_query->num_rows > 0){
$_SESSION['logged'] = $safe_username;
echo ("<meta http-equiv=\"Refresh\" content=\"2; URL=./\"/><div class=\"message success\"><p>Влязохте успешно в акаунта Ви.</p></div>"); 
// променливата $form е празна(empty) за да спрем потребителя от натискане на логин бутон, когато бива пренасочван.
}
else
{
echo "<div class=\"message errormsg\"><p>Грешен потребител или парола !</p></div>";
$form = "<form method=\"post\" action=\"\">"; 
}
}
else
{
$form = "<form method=\"post\" action=\"\">";
}
echo("$form 			
<p>
							<label>Потребител:</label> <br>
							<input type=\"text\" class=\"text\" name=\"username\">
						</p>
						
						<p>
							<label>Парола:</label> <br>
							<input type=\"password\" class=\"text\" name=\"password\">
						</p>");
						if ($slider) {
						echo "
						<p>
						<div class=\"slider_unlock ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all\" title=\"Плъзни да влезнеш\">
	<div class=\"ui-slider-range ui-widget-header ui-slider-range-min\" style=\"width: 0%; \"></div><div class=\"unlock_message\"></div></div>
										<input type=\"submit\" style=\"display:none\" name=\"login\" class=\"icon_only text_only\"></button>
						</p>";
						}
						else
						{
						echo "<center><input type=\"submit\" class=\"buttonsub\" name=\"login\" value=\"Логин\"/></center><br />";
						}
						
						
					echo ("
</form>
<p>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href=\"./?p=register\"><button class=\"buttonsub long\">Регистрация</button></a> &nbsp; 
							<a href=\"./?p=lostpassword\"><button class=\"buttonsub long\">Забравена парола</button></a></p>"); 

} 
else 
{
echo ("<center>");
$ban_status_query = $mysqli->query("SELECT `player_ip` ,`expired` FROM `$bans` WHERE `player_ip`='$ip' AND `expired`='0'");
if ($ban_status_query->num_rows != 0)
{
echo "<div class=\"message errormsg1\"><p>$ip</p></div>";
if($logged['credits'] >= $unbancost){
?>
<form action="" method="post">
<input type="submit" name="unban" class="unban" value="Премахни бана
( <?php echo $unbancost; ?> Кредита )"/><br /><br />
</form>
<?php
if(isset($_POST['unban']))
{
if ($logged[credits] >= $unbancost)
{
$remove_credits = $mysqli->query("UPDATE `users` SET `credits` = `credits` - $unbancost WHERE `username` = '$logged[username]'")or die(mysqli_error());
$remove_bans = $mysqli->query("DELETE FROM `$bans` WHERE `player_ip`='$ip' LIMIT $bans_to_remove")or die(mysqli_error());
$add_log = $mysqli->query("INSERT INTO `logs` (username, time, server,type) VALUES ('$logged[username]', $timehook, 'Всички', 'Унбан')")or die(mysqli_error());
echo "<meta http-equiv=\"Refresh\" content=\"0; URL=./\"/> ";
}
else 
{
echo "<meta http-equiv=\"Refresh\" content=\"0; URL=./\"/> ";
}
}
}else{
echo "<div class=\"unban\">Нямате достатачно кредити</div><br />";
}

        }
        else {
            echo "<div class=\"message success1\"><p>$ip</p></div>";
        }
echo "<a href=\"./?p=profile\"><button class=\"buttonsub\">Профил</button></a>
<a href=\"./?p=charge\"><button class=\"buttonsub long\">Зареди кредити</button></a>
<a href=\"./?p=chronology\"><button class=\"buttonsub mid\">Хронология</button></a>
<br /><br />
<div class='fullbar'><a href='./?p=become'>Закупи права</a></div>";
if ($bb_module) { echo "<div class='fullbar'><a href='./?p=bb'>Закупи кредити за $bbserv</a></div>"; }
if ($zp_module) { echo "<div class='fullbar'><a href='./?p=zp'>Закупи аммо пакове за $zpserv</a></div>"; }
if ($war3_module) { echo "<div class='fullbar'><a href='./?p=war3xp'>Закупи експириънс за $war3serv</a></div>"; }
				echo "<form action=\"\" method=\"post\">
					<input type=\"submit\" name=\"logout\" class=\"buttonsub\" value=\"Излез\"/>
					</form>
"; 
 if (isset($_POST['logout'])){
 $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]);
	}
	session_destroy();
	header ("Location: ./");
  }
}
?>