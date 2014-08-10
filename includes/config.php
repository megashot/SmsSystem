<?php
if(!defined('SMS')) {
header ("Location: ../");
die();
}
//ERROR_REPORTING(E_ALL ^ E_NOTICE);
$server = "localhost";
$username = ""; // Потребител
$password = ""; // Парола
$db_name = ""; // Име на базата данни
ERROR_REPORTING(E_ALL ^ E_NOTICE);
$mysqli = new mysqli($server, $username, $password, $db_name);
$mysqli->set_charset("utf8");
if (isset($_SESSION['logged'])) {
$fetch_information = $mysqli->prepare('SELECT `username`,`password`,`email`,`credits` FROM `users` WHERE `username`= ?')or die(mysqli_error($mysqli));
$fetch_information->bind_param('s', $_SESSION['logged']);
$fetch_information->execute();
$fetch_information->store_result();   
$fetch_information->bind_result($logged[username], $logged[password], $logged[email], $logged[credits]);    
$fetch_information->fetch();  
         if($fetch_information->num_rows != 1){
		 $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);}
		session_destroy();
		 }
$fetch_information->close();
}
$ip = $_SERVER['REMOTE_ADDR']; // IP
$timehook = time(); // Засичаме часа и датата
$regex = '^((?:(?:(?:\w[\.\-\+]?)*)\w)+)\@((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$^';
// По-горе не пипитайте, ако не знате какво правите

// SMS Система настройки начало - >
$bans_to_remove = 100; // колко бана да премахне
$unbancost = 4; // Цената на unbana в кредити
$servid1 = 29; // ServID // 1.20
$servid2 = 29; // ServID // 2.40
$servid3 = 29; // ServID // 4.80
$servid4 = 29; // ServID // 6.00
$credits1 = 1; // 1.20 колко кредита да дава
$credits2 = 2; // 2.40 колко кредита да дава
$credits3 = 4; // 4.80 колко кредита да дава
$credits4 = 6; // 6.00 колко кредита да дава
$slider = true; // true - Плъзгане //  false - Бутон //
$md5_password = false; // true - да хешира паролите  // false - да НЕ хешира паролите
$amxadmins = "amx_amxadmins"; // таблицата amxadmins. Default - amx_amxadmins
$admins_servers = "amx_admins_servers"; // таблицата admins_servers. Default - amx_admins_servers
$serverinfo = "amx_serverinfo"; // таблицата serverinfo. Default - amx_serverinfo
$bans = "amx_bans"; // таблицата bans. Default - amx_bans
$title="SMS Услуги: Името на вашият уебсайт"; // Името
$sms_info = array(
    "smssystem1" => "1001", // 1.20
    "smssystem2" => "1002", // 2.40
    "smssystem3" => "1003", // 4.80
    "smssystem4" => "1004" //  6.00
	// Текст за изпращане - на номер
);
$custom1 = '';
$static1 = 'no';
// ВИП начало >
$vipcost = "2"; // цена на вип правата
$accessvip ="abcdeijut"; // вип флагове за достъп
$flagsvip="a"; // вип акаунт флагове
$ashowvip=0; // Дали да се в amxbans страницата като администратор
$daysvip = 30; // колко дни вип права
// < ВИП край 
// АДМИН начало >
$admincost = "4"; // цена на админ правата
$accessadmin ="abcdeijut"; // админ флагове за достъп
$flagsadmin="a"; // админ акаунт флагове
$ashowadmin=0; // Дали да се в amxbans страницата като администратор
$daysadmin = 30; // колко дни админ права
// < АДМИН край
// @ http://cs-bg.info/article_server-admin.php ИНФОРМАЦИЯ ОТНОСНО ФЛАГОВЕ ЗА ДОСТЪП И АКАУНТ ФЛАГОВЕ
// < - SMS Система настройки край 

// ZP Аммо пакове модул начало - >
$zp_module = false; // true - включен, false - изключен
$zpserv = "Zombie Plague23"; // Името на Zombie Plague сървъра
$zp1 = 600; // Колко аммо да дава при избрано 1 кредит
$zp2 = 700; // Колко аммо да дава при избрано 2 кредитa
$zp3 = 800; // Колко аммо да дава при избрано 3 кредитa
$zp4 = 900; // Колко аммо да дава при избрано 4 кредитa
// < - ZP Аммо пакове модул край

// BB кредити модул начало - >
$bb_module = false; // true - включен, false - изключен
$bbserv = "Base Builder23"; // Името на Base Builder сървъра
$bb1 = 400; // Колко кредита да дава при избранo 1 кредит
$bb2 = 500; // Колко кредита да дава при избранo 2 кредитa
$bb3 = 600; // Колко кредита да дава при избрано 3 кредитa
$bb4 = 700; // Колко кредита да дава при избрано 4 кредитa
// < - BB кредити модул край

// War3 XP модул начало - >
$war3_module = false; // true - включен, false - изключен
$war3serv = "Warcraft23"; // Името на War3XP сървъра
$xp1 = 400; // Колко експириънс да дава при избранo 1 кредит
$xp2 = 500; // Колко експириънс да дава при избранo 2 кредитa
$xp3 = 600; // Колко експириънс да дава при избрано 3 кредитa
$xp4 = 700; // Колко експириънс да дава при избрано 4 кредитa
// < - War3 XP модул край

// Закупуване на права '2.0' модул начало - >
$become_new = false; // true - включен, false - изключен
$accountflags = "a"; // Акаунт флагове - http://cs-bg.info/article_server-admin.php
$days = 30; // дни
$ashow=0; // Дали да се в amxbans страницата като администратор
$listflags = '
<input type="checkbox" class="calc" name="access[a]" value="2" /> A флаг - 2 кредита - Имунитет от бан/кик/слап<br/>

'; 
// <input type="checkbox" class="calc" name="access[ФЛАГ ЗА ДОСТЪП]" value="ЦЕНА" /> Информация <br/>
/* ПРИ ВКЛЮЧВАНЕ НА МОДУЛА ПРОМЕНЛИВИТЕ: 
$vipcost, $accessvip, $ashowvip, $daysvip,
$admincost, $accessadmin, $flagsadmin, $ashowadmin, $daysadmin 
СПИРАТ ДА ОКАЗВАТ ВЛИЯНИЕ
*/
// < - Закупуване на права '2.0' модул край


// По-надолу не пипайте, ако не знаете какво правите
$deleteoldadmins = $mysqli->query("DELETE `$amxadmins`, `$admins_servers` FROM `$amxadmins` INNER JOIN `$admins_servers` ON `$admins_servers`.`admin_id` = `$amxadmins`.`id` WHERE `$amxadmins`.`expired` < '$timehook' AND `$amxadmins`.`expired` != '0'"); // Заявката която изтрива старите администратори
?>