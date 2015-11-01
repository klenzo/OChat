<?php
	if(!isset($p)){session_start(); include('langs.php'); require_once('dbconect.php');}
	require('bbcode.php');
	$req = $bdd->query('SELECT * FROM message ORDER BY time DESC LIMIT 0,30');
	while($data = $req->fetch()) {
		if(isset($_SESSION['pseudo']) AND $data['name'] == $_SESSION['pseudo']){
			$rpseudo = $_SESSION['pseudo'];

			$rrequ = $bdd->prepare('SELECT * FROM users WHERE name=?');
			$rrequ->execute(array($rpseudo));
			if($rres = $rrequ->fetch()){
				$rsrequ = $bdd->prepare('UPDATE users SET time=? WHERE name=?');
				$rsrequ->execute(array(time(), $rres['name']));
			}else{
				$rsrequ = $bdd->prepare('INSERT INTO users(name, time) VALUES(:name, :time)');
				$rsrequ->execute(array(
					'name' => $rpseudo,
					'time' => time()
					));
			}

			$float = 'right';
		}else{
			$float = 'left';
		}
	?>
		<div class="message <?= $float; ?>">
			<strong class="name"><?= $data['name']; ?></strong>
			<p class="mp"><?= bbcode($data['msg']); ?></p>
			<em class="time"><?= showdate($data['time']); ?></em>
		</div>
	<?php

	}
