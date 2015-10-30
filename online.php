<?php
	if(!isset($p)){session_start(); try{ $bdd = new PDO('mysql:host=localhost;dbname=ochat;charset=utf8', 'root', ''); }catch (Exception $e){ die('Erreur : ' . $e->getMessage()); }}
	$time = time()-10;
	$reqs = $bdd->query('SELECT * FROM users WHERE time >= '.$time.' ORDER BY time DESC LIMIT 0,20');
	while($datas = $reqs->fetch()) {
		echo '<strong>'.$datas['name'].'</strong>';
	}
