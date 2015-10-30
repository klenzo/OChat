<?php
	if(isset($_POST['submit'])){
		if(!isset($p)){session_start(); include('langs.php'); try{ $bdd = new PDO('mysql:host=localhost;dbname=ochat;charset=utf8', 'root', ''); }catch (Exception $e){ die('Erreur : ' . $e->getMessage()); }}

		if(isset($_POST['message']) AND strlen($_POST['message']) >= 2){
			$message = htmlentities($_POST['message']);
			if(isset($_POST['pseudo']) AND preg_match('/^[a-zA-Z0-9]{3,25}$/', $_POST['pseudo'])){
				$mpseudo  = $_POST['pseudo'];

				$mreq = $bdd->prepare('SELECT * FROM users WHERE name=?');
				$mreq->execute(array($mpseudo));
				if($mdonnees = $mreq->fetch()){
					$mreqi = $bdd->prepare('UPDATE users SET time=? WHERE name=?');
					$mreqi->execute(array(time(), $mdonnees['name']));
				}else{
					$mreqi = $bdd->prepare('INSERT INTO users(name, time) VALUES(:name, :time)');
					$mreqi->execute(array(
						'name' => $mpseudo,
						'time' => time()
						));
				}

				$_SESSION['pseudo'] = $mpseudo;
				setcookie("pseudo", $mpseudo, time()+3600*24);

				$mmreq = $bdd->prepare('INSERT INTO message(name, msg, time) VALUES(:name, :msg, :time)');
				$mmreq->execute(array(
					'name' => $mpseudo,
					'msg' => $message,
					'time' => time()
				));

			}else{
				$error = pseudoinvalid;
				$rmessage = $message;
			}
		}else{
			$error = msgshort;
		}
	}
