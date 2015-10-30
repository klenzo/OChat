<?php
	$langs = array('fr', 'en');
	if(isset($_GET['lang']) AND in_array($_GET['lang'], $langs)){
		$lang = $_GET['lang'];
		setcookie("lang", $lang, time()+3600*24);
	}else{
		if(isset($_COOKIE['lang']) AND in_array($_COOKIE['lang'], $langs)){
			$lang = $_COOKIE['lang'];
		}else{
			$lang = 'fr';
		}
	}

switch ($lang) {
	case 'en':

		define('username', 'Username');
		define('message', 'Message');
		define('send', 'Send');
		define('online', 'Online');

		define('msgshort', 'Message too short, minimum 2 characters.');
		define('pseudoinvalid', 'This username is invalid, alphanumeric.');
		define('success', 'Message sent !');
		define('error', 'Message sent !');

		break;
	default:

		define('username', 'Pseudo');
		define('message', 'Message');
		define('send', 'Envoyer');
		define('online', 'En ligne');

		define('msgshort', 'Message trop court, minimum 2 caractères.');
		define('pseudoinvalid', 'Ce pseudo est invalide, alphanumérique.');
		define('success', 'Message envoyé !');
		define('error', 'Message envoyé !');

		break;
}

?>
