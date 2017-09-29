<?php session_start();
	include('langs.php');

	$p = true;
	require_once('dbconect.php');

	if(isset($_COOKIE['pseudo']) AND preg_match('/^[a-zA-Z0-9]{3,25}$/', $_COOKIE['pseudo'])){
		$_SESSION['pseudo'] = $_COOKIE['pseudo'];
	}

	require('mcs.php');
?><!DOCTYPE html>
<html>
<head>
	<title>MiniChat - OChat</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="app.js" type="text/javascript"></script>
	<meta charset="utf-8">
	<link rel="icon" href="img/logo.png">
</head>
<body>
	<div class="header">
		<div class="headercontent">
			<span id="logo" style="background-image: url('img/logo.png');"></span>
			<strong id="tlogo">OChat</strong>
			<div class="lang_box">
				<a href="?lang=fr" title="Français"><img src="img/french-flag.png" alt="Français"></a>
				<a href="?lang=en" title="English"><img src="img/english-flag.png" alt="English"></a>
			</div>
		</div>
	</div>
	<div class="warp">
		<div class="content">
			<?php if(isset($error)){echo $error;} ?>
			<div class="chat">
			<?php include('rochat.php') ?>
			<div class="clear"></div></div>
			<div class="smileys">
			<?php
				$dirname = 'smileys/';
				$dir = opendir($dirname);
				$icons = array();
				while($file = readdir($dir)) {
					if($file != '.' && $file != '..' && !is_dir($dirname.$file))	{
						$icons[] = $file;

						$file = explode('.', $file);
						$ext = $file[1];
						$file = $file[0];

						// $file = str_replace('.PNG', '.png', $file);
						// $file = str_replace('.png', '', $file);
						echo '<img src="'.$dirname.$file.'.'.$ext.'" alt="'.$file.'" title="'.$file.'" rel-name="'.$file.'" class="icon icon_smileys">';
					}
				}
				closedir($dir);

				$icon = $icons[array_rand($icons, 1)];
			 ?>
			</div>
			<form action="" method="POST" class="form">
				<strong class="load">Loading ...</strong>
				<p class="notif" id="success" style="display:none;"><?= success; ?></p>
				<p class="notif" id="errorp" style="display:none;"><?= pseudoinvalid; ?></p>
				<p class="notif" id="errorm" style="display:none;"><?= msgshort; ?></p>

				<textarea name="message" id="message" placeholder="<?= message; ?>"><?php if(isset($rmessage)){echo $rmessage;} ?></textarea>
				<?php if(isset($_SESSION['pseudo']) AND preg_match('/^[a-z|A-Z|0-9| |@|_|-]{3,25}$/', $_SESSION['pseudo'])){ $value = $_SESSION['pseudo']; $disable='disabled'; }elseif(isset($_COOKIE['pseudo']) AND preg_match('/^[a-z|A-Z|0-9| |@|_|-]{3,25}$/', $_COOKIE['pseudo'])){$value = $_COOKIE['pseudo']; $disable='disabled';}else{ $value = ''; $disable = '';} ?>
				<input type="<?= $type; ?>" name="pseudo" id="pseudo" <?= $disable; ?> placeholder="<?= username; ?>" value="<?= $value; ?>">

				<img src="<?= $dirname . $icon; ?>" class="icon btn_smileys">

				<input type="submit" id="submit" name="submit" value="<?= send; ?>">
			<div class="clear"></div></form>
		</div>
		<div class="online">
			<strong id="online_title"><?= online; ?></strong>
			<div id="online_list"><?php include('online.php'); ?></div>
		</div>

		<div class="clear"></div>
	</div>
</body>
</html>