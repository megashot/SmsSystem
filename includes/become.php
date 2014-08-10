<?php
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
if(isset($_POST['buy'])) {
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
$serverid=$_POST["serverid"];
$fetch_servers = $mysqli->prepare("SELECT `id`,`hostname` FROM `$serverinfo` WHERE `id`= ?")or die(mysqli_error());
$fetch_servers->bind_param('s', $serverid);
$fetch_servers->execute();
$fetch_servers->store_result();   
$fetch_servers->bind_result($serverf[id], $serverf[hostname]);    
$fetch_servers->fetch();
	if(isset($_POST['choices']) && !empty($_POST['choices'])){
        if($_POST['choices'] == 'vip'){
			if($logged[credits] >=$vipcost){
			
			$check_duplicate = $mysqli->query("SELECT `id` FROM `$amxadmins` WHERE `steamid` = '$logged[username]' AND `access` = '$accessvip'")or die(mysqli_error($mysqli));
			$dub = $check_duplicate->fetch_assoc();
							$check_duplicate_two = $mysqli->query("SELECT `admin_id` FROM `$admins_servers` WHERE `admin_id` = '$dub[id]' AND `server_id` = '$serverf[id]'")or die(mysqli_error($mysqli));				
							if($check_duplicate_two->num_rows > 0)
							{
							$message = "<div class=\"message errormsg\"><p>Имате активни права в този сървър.</p></div>";
							}
							else
							{
							$remove_creditsvip = $mysqli->query("UPDATE `users` SET `credits` = `credits` - $vipcost WHERE `username` = '$logged[username]'")or die(mysqli_error());
$log_vip = $mysqli->query("INSERT INTO `logs` (username, time, server, type) VALUES ('$logged[username]', $timehook, '$serverf[hostname]', 'Вип права')")or die(mysqli_error());
$expiredvip = $timehook + ($daysvip * 24 * 60 * 60);
$add_vipflags = $mysqli->query("INSERT INTO `$amxadmins` (`password`, `access` , `flags` ,`steamid` , `nickname`, `ashow` , `created` , `expired` , `days`) VALUES ('$logged[password]', '$accessvip', '$flagsvip' , '$logged[username]' , '$logged[username]' , '$ashowvip' , '$timehook' , '$expiredvip' , '$daysvip')") or die (mysqli_erorr($mysqli));
$idvip = $mysqli->insert_id;
$add_vipflags_second = $mysqli->query("INSERT INTO `$admins_servers` (`admin_id`, `server_id`, `custom_flags`, `use_static_bantime`) VALUES ('$idvip', '$serverf[id]', '$custom1', '$static1')") or die(mysqli_error($mysqli));
$message = "<div class=\"message success\"><p>След смяната на картата права ще бъдат активирани.</p></div>";
							}
							}
							else 
							{ $message = "<div class=\"message errormsg\"><p>Нямате достатачно кредити.</p></div>"; }



        }elseif($_POST['choices'] == 'admin'){
		if($logged[credits] >=$vipcost){
			
			$check_duplicate = $mysqli->query("SELECT `id` FROM `$amxadmins` WHERE `steamid` = '$logged[username]' AND `access` = '$accessadmin'")or die(mysqli_error($mysqli));
			$dub = $check_duplicate->fetch_assoc();
							$check_duplicate_two = $mysqli->query("SELECT `admin_id` FROM `$admins_servers` WHERE `admin_id` = '$dub[id]' AND `server_id` = '$serverf[id]'")or die(mysqli_error($mysqli));
							if($check_duplicate->num_rows > 0 && $check_duplicate_two->num_rows > 0)
							{
							$message = "<div class=\"message errormsg\"><p>Имате активни права в този сървър.</p></div>";
							}
							else
							{
$remove_admin = $mysqli->query("UPDATE `users` SET `credits` = `credits` - $admincost WHERE `username` = '$logged[username]'")or die(mysqli_error());
$log_admin = $mysqli->query("INSERT INTO `logs` (username, time, server, type) VALUES ('$logged[username]', $timehook, '$serverf[hostname]', 'Админ права')")or die(mysqli_error());
$expiredadmin = $timehook + ($daysadmin * 24 * 60 * 60);
$add_adminflags = $mysqli->query("INSERT INTO `$amxadmins` (`password`, `access` , `flags` ,`steamid` , `nickname`, `ashow` , `created` , `expired` , `days`) VALUES ('$logged[password]', '$accessadmin', '$flagsadmin' , '$logged[username]' , '$logged[username]' , '$ashowadmin' , '$timehook' , '$expiredadmin' , '$daysadmin')") or die (mysqli_erorr($mysqli));
$idadmin = $mysqli->insert_id;
$add_adminflags_second = $mysqli->query("INSERT INTO `$admins_servers` (`admin_id`, `server_id`, `custom_flags`, `use_static_bantime`) VALUES ('$idadmin', '$serverf[id]', '$custom1', '$static1')") or die(mysqli_error($mysqli));
$message = "<div class=\"message success\"><p>След смяната на картата права ще бъдат активирани.</p></div>";
							}
							
} else { $message = "<div class=\"message errormsg\"><p>Нямате достатачно кредити.</p></div>"; }

        }
}else{
     $message =  "<div class=\"message errormsg\"><p>Трябва да изберете.</p></div>";
}

}else{ $message = "<div class=\"message info\"><p>Правата ще бъдат добавени на ник: $logged[username]</p></div>"; }
if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	}
?>
<form method="post" action="">
<?php echo $message; ?>
<center>
<select name="serverid">
<?php 
$show_servers = $mysqli->query("SELECT `id`, `hostname` FROM `$serverinfo`");
							while($rowserver = $show_servers->fetch_assoc()) {
							 echo "<option value='$rowserver[id]'>$rowserver[hostname]</option>";
							}?></select><br /><br />
<input type="radio" name="choices" value="vip" /> Вип - <?php echo "$vipcost"; ?> кредита - Флагове <?php echo "$accessvip"; ?>
<br /><input type="radio" name="choices" value="admin" /> Админ - <?php echo "$admincost"; ?> кредита - Флагове <?php echo "$accessadmin"; ?>
<br /><br /><input type="submit" class="buttonsub" name="buy" value="Добави"/>
<br /><br /><hr>
						<input type="submit" name="back" class="buttonsub" value="Назад"/></center></form>