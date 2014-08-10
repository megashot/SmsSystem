<?php 
if(!defined('SMS')) {
header ("Location: ../");
die();
}
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
$sms_texts = array_keys($sms_info);
$sms_numbers = array_values($sms_info);
if(isset($_POST['charge'])) {
if (!isset($_SESSION['logged'])) {
   header("Location:./");
   exit;
   }
$code = $_POST[code];   
function mobio_checkcode($servID, $code, $debug=0) {

        $res_lines = file("http://www.mobio.bg/code/checkcode.php?servID=$servID&code=$code");

        $ret = 0;
        if($res_lines) {

                if(strstr($res_lines[0], "PAYBG=OK")) {
                        $ret = 1;
                }else{
                        if($debug)
                                echo $res_lines[0]."\n";
                }
        }else{
                if($debug)
                        echo "Unable to connect to mobio.bg server.\n";
                $ret = 0;
        }

        return $ret;
}	

                if(isset($_POST['choices']) && !empty($_POST['choices'])){
        if($_POST['choices'] == '1'){
		if(mobio_checkcode($servid1, $code) == 1) {
		$insert_credits1 = $mysqli->query("UPDATE `users` SET `credits` = `credits` + $credits1 WHERE `username` = '$logged[username]'");
		$insert_log1 = $mysqli->query("INSERT INTO `logs` (username, time, type) VALUES ('$logged[username]', $timehook, '1')");
                echo "<div class=\"message success\"><p>Беше ви добавен $credits1 кредит.</p></div>";
        }else{
                echo "<div class=\"message errormsg\"><p>Грешен SMS код за достъп.</p></div>";
        }
        }
		else if ($_POST['choices'] == '2'){
		if(mobio_checkcode($servid2, $code) == 1) {
		$insert_credits2 = $mysqli->query("UPDATE `users` SET `credits` = `credits` + $credits2 WHERE `username` = '$logged[username]'");
		$insert_log2 = $mysqli->query("INSERT INTO `logs` (username, time, type) VALUES ('$logged[username]', $timehook, '2')");
                echo "<div class=\"message success\"><p>Бяха ви добавени $credits2 кредити.</p></div>";
        }else{
                echo "<div class=\"message errormsg\"><p>Грешен SMS код за достъп.</p></div>";
        }
        }
		else if ($_POST['choices'] == '3'){
if(mobio_checkcode($servid3, $code) == 1) {
		$insert_credits3 = $mysqli->query("UPDATE `users` SET `credits` = `credits` + $credits3 WHERE `username` = '$logged[username]'");
		$insert_log3 = $mysqli->query("INSERT INTO `logs` (username, time, type) VALUES ('$logged[username]', $timehook, '3')");
                echo "<div class=\"message success\"><p>Бяха ви добавени $credits3 кредити.</p></div>";
        }else{
                echo "<div class=\"message errormsg\"><p>Грешен SMS код за достъп.</p></div>";
        }
        }
		else if ($_POST['choices'] == '4'){
		if(mobio_checkcode($servid4, $code) == 1) {
		$insert_credits4 = $mysqli->query("UPDATE `users` SET `credits` = `credits` + $credits4 WHERE `username` = '$logged[username]'");
		$insert_log4 = $mysqli->query("INSERT INTO `logs` (username, time, type) VALUES ('$logged[username]', $timehook, '4')");
                echo "<div class=\"message success\"><p>Бяха ви добавени $credits4 кредити.</p></div>";
        }else{
                echo "<div class=\"message errormsg\"><p>Грешен SMS код за достъп.</p></div>";
        }
		} 	
	}	else	{
     echo "<div class=\"message errormsg\"><p>Трябва да изберете колко кредита искате да заредите.</p></div>";
		}
}
if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	}

?>
<div id="sms1">
Изпратете SMS с текст <span style='color:red'><?php echo $sms_texts[0]; ?></span> на номер <span style='color:red'><?php echo $sms_numbers[0]; ?></span> (за всички мобилни оператори). Цената на SMS е <span style='color:red'>1,20 лв.</span> с включено ДДС.
<br /><br />
</div>
<div id="sms2">Изпратете SMS с текст <span style='color:red'><?php echo $sms_texts[1]; ?></span> на номер <span style='color:red'><?php echo $sms_numbers[1]; ?></span> (за всички мобилни оператори). Цената на SMS е <span style='color:red'>2,40 лв.</span> с включено ДДС.
<br /><br />
</div>
<div id="sms3">Изпратете SMS с текст <span style='color:red'><?php echo $sms_texts[2]; ?></span> на номер <span style='color:red'><?php echo $sms_numbers[2]; ?></span> (за всички мобилни оператори). Цената на SMS е <span style='color:red'>4,80 лв.</span> с включено ДДС.
<br /><br />
</div>
<div id="sms4">Изпратете SMS с текст <span style='color:red'><?php echo $sms_texts[3]; ?></span> на номер <span style='color:red'><?php echo $sms_numbers[3]; ?></span> (за всички мобилни оператори). Цената на SMS е <span style='color:red'>6,00 лв.</span> с включено ДДС.
<br /><br />
</div>
<form method="post" action="">
<center>

<input type="radio" id="r1" name="choices" onchange="change();" value="1" /> <?php echo $credits1; ?> кредит - 1.20лв с ДДС
<br /><input type="radio" id="r2" name="choices" onchange="change();" value="2" /> <?php echo $credits2; ?> кредитa - 2.40лв с ДДС
<br /><input type="radio" id="r3" name="choices" onchange="change();" value="3" /> <?php echo $credits3; ?> кредитa - 4.80лв с ДДС
<br /><input type="radio" id="r4" name="choices" onchange="change();"  value="4" /> <?php echo $credits4; ?> кредитa - 6.00лв с ДДС
<p>
							<label>SMS Код:</label> <br>
							<input type="text" class="text" name="code">
						</p>
<input type="submit" class="buttonsub" name="charge" value="Добави"/>
<br />
<div id="sms5"><br />След изпращане на SMS-а ще получите код, който трябва да въведете по-горе в полето <i>SMS код</i>.<br />

</div>
<br /><hr>
						<input type="submit" name="back" class="buttonsub" value="Назад"/>
</form>
</center>