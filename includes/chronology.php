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
							
							<i><h4>Хронология на плащанията:</h4></i>
							<table cellspacing="3" width="100%" border="0">
<tbody>
<tr>
<td style="background-color: #b6e0fb; padding: 4px; text-align: center; font-size: 12px; color: white;"><b>Кредит/и</b></td>
<td style="background-color: #b6e0fb; padding: 4px; text-align: center; font-size: 12px; color: white;"><b>Дата и час</b></td>
</tr>
<?php
							$get_query = $mysqli->query("SELECT `time`, `type` FROM `logs` WHERE `username` = '$logged[username]' AND `type` = '1' OR `type` = '2' OR `type` = '3' OR `type` = '4' ORDER BY `id` DESC LIMIT 0,10");
							$get_query->num_rows;
							if($get_query->num_rows > 0) {
							while($row = $get_query->fetch_assoc()) {
							$date = date('d.m.y в H:i:s',$row['time']);
                            if ($row[type] == 1) { $credits = $credits1; }	
							else if ($row[type] == 2) { $credits = $credits2; }
							else if ($row[type] == 3) { $credits = $credits3; }	
							else if ($row[type] == 4) { $credits = $credits4; }								
							echo "<tr>
<td style=\"background-color: #e6f5fe; padding: 4px; text-align: center; font-size: 12px; color: #000;\">$credits</td>
<td style=\"background-color: #e6f5fe; padding: 4px; text-align: center; font-size: 12px; color: #000;\">$date</td>";
}
								echo "</tr></tbody></table>";
                            }
                            else {
                                echo "</tbody></table><center>Все още не сте извършвали плащане.</center>";
                            }
                            ?>
							
							<hr><b><i>Хронология на екстрите:</i></b>
							
							<table cellspacing="3" width="100%" border="0">
<tbody>
<tr>
<td style="background-color: #b6e0fb; padding: 4px; text-align: center; font-size: 12px; color: white;"><b>Сървър</b></td>
<td style="background-color: #b6e0fb; padding: 4px; text-align: center; font-size: 12px; color: white;"><b>Услуга</b></td>
<td style="background-color: #b6e0fb; padding: 4px; text-align: center; font-size: 12px; color: white;"><b>Дата на закупуване</b></td>
</tr>
<?php
                            $get_query = $mysqli->query("SELECT `server`, `time`, `type` FROM `logs` WHERE `username` = '$logged[username]' AND `type` != '1' AND `type` != '2' AND `type` != '3' AND `type` != '4' ORDER BY `id` DESC LIMIT 0,10");
							$get_query->num_rows;
							if($get_query->num_rows > 0) {
							while($row2 = $get_query->fetch_assoc()) {
								$date1 = date('d.m.y в H:i:s',$row2['time']); 
                                    echo "<tr>
<td style=\"background-color: #e6f5fe; padding: 4px; text-align: center; font-size: 12px; color: #000;\">$row2[server]</td>
<td style=\"background-color: #e6f5fe; padding: 4px; text-align: center; font-size: 12px; color: #000;\">$row2[type]</td>
<td style=\"background-color: #e6f5fe; padding: 4px; text-align: center; font-size: 12px; color: #000;\">$date1</td>";
                                }
								echo "</tr></tbody></table>";
                            }
                            else {
                                echo "</tbody></table>
<center>Не сте закупували никакви екстри.</center>";
                            }
 if (isset($_POST['back'])){
	header ("Location: ./");
	exit;
	} ?>
	<form method="post" action="">
	<hr>
	<center><input type="submit" name="back" class="buttonsub" value="Назад"/></center>
	</form>
							