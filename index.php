<?php 
session_start();
ob_start();
DEFINE("SMS", true);
include "./includes/config.php";
$p = addslashes(htmlspecialchars($_GET['p']));
$key = addslashes(htmlspecialchars($_GET['key']));
?>
<!doctype html>
<head>
	<title><?php echo "$title"; ?></title>
	<link href="./css/style.css" media="screen, projection" rel="stylesheet" type="text/css">
	<script src="./js/jquery.min.js" type="text/javascript"></script>
	<?php if ($slider && $p == NULL && (!isset($_SESSION['logged']))) { ?>
	<script type="text/javascript" src="./js/autoglow.js"></script>
	<script src="./js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="./js/slide.js"></script>
	<script type="text/javascript" src="./js/slidemain.js"></script>
	<?php } 
	if ($p == "charge") {?>
	<script>
	function change() {
document.getElementById('sms5').style.display = "block";	
    if(document.getElementById('r1').checked == true)
    {
    document.getElementById('sms1').style.display = "block";
	document.getElementById('sms2').style.display = "none";
	document.getElementById('sms3').style.display = "none";
	document.getElementById('sms4').style.display = "none";
    }
    else if(document.getElementById('r2').checked == true)
    {
    document.getElementById('sms1').style.display = "none";
	document.getElementById('sms2').style.display = "block";
	document.getElementById('sms3').style.display = "none";
	document.getElementById('sms4').style.display = "none";
    }
	else if(document.getElementById('r3').checked == true)
    {
    document.getElementById('sms1').style.display = "none";
	document.getElementById('sms2').style.display = "none";
	document.getElementById('sms3').style.display = "block";
	document.getElementById('sms4').style.display = "none";
    }
	else if(document.getElementById('r4').checked == true)
    {
     document.getElementById('sms1').style.display = "none";
	document.getElementById('sms2').style.display = "none";
	document.getElementById('sms3').style.display = "none";
	document.getElementById('sms4').style.display = "block";
    }
	}
</script>
	<?php
	}
	if ($p == "become" && $become_new)
	{ ?>
	<script>
	$(document).ready(function(event){
      $('.calc').click(function(){

         var total = 0;

         $('.calc:checked').each(function(){
            total += parseInt($(this).val());
         });

         $('#calcResult').html(total);
      });
   });
	</script>
	<?php } ?>
	<meta charset="utf-8">
</head>
<body>	
	<div id="hld">
		<div class="wrapper">
			<div class="block small center login">
			
				<div class="block_head">
					<div class="bheadl"></div>
					<div class="bheadr"></div>
				<?php	
				if ($p == "profile")
				{
				$page = "./includes/profile.php";
				$pagename = "Профил";
				}
				else if ($p == "zp")
				{
				if ($zp_module) {
				$page = "./includes/zp.php";
				$pagename = "Аммо пакове";
				}
				else
				{ header ("Location: ./"); die(); }
				}
				else if ($p == "bb")
				{
				if ($bb_module) {
				$page = "./includes/bb.php";
				$pagename = "Кредити (BB)";
				}
				else
				{ header ("Location: ./"); die(); }
				}
				else if ($p == "war3xp")
				{
				if ($war3_module) {
				$page = "./includes/war3xp.php";
				$pagename = "Експириънс";
				}
				else
				{ header ("Location: ./"); die(); }
				}
				else if ($p == "charge")
				{
				$page = "./includes/charge.php";
				$pagename = "Зареждане на кредити";
				}
				else if ($p == "chronology")
				{
				$page = "./includes/chronology.php";
				$pagename = "Хронология";
				}
				else if ($p == "register")
				{
				$page = "./includes/register.php";
				$pagename = "Регистрация";
				}
				else if ($p == "become")
				{
				if ($become_new) {
				$page = "./includes/become_new.php";
				}
				else
				{
				$page = "./includes/become.php";
				}
				$pagename = "Закупуване на права";
				}
				else if ($p == "lostpassword")
				{
				$page = "./includes/lostpassword.php";
				$pagename = "Забравена парола";
				}
				else if ($key)
				{
				$page = "./includes/changepassword.php";
				$pagename = "Забравена парола";
				}
				else
				{
				$page = "./includes/login.php";
				if ($logged[username]) 
				{
				$pagename = "Здравей, $logged[username]";
				}
				else
				{
				$pagename = "Добре Дошли";
				}
				}
				?>
					<h2><?php echo "$pagename";	?></h2>
				<ul>
						<li class="nobg">
				<?php 
				if ($logged[username]) 
				{ echo "<a href=\"./?p=charge\">Кредити: $logged[credits]</a></a>"; }		
				?></li>
				</ul>
				</div>
				<div class="block_content">
				<?php include $page; ?>
				</div>
				<div class="bendl"></div>
				<div class="bendr"></div>			
			</div>
		</div>
	</div>
</html>