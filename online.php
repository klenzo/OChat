<?php
	if(!isset($p)){session_start(); include('langs.php'); require_once('dbconect.php');}
	$time = time()-10;
	$reqs = $bdd->query('SELECT * FROM users WHERE time >= '.$time.' ORDER BY time DESC LIMIT 0,20');
	while($datas = $reqs->fetch()) {
        if( isset($_SESSION['pseudo']) && $datas['name'] == $_SESSION['pseudo'] ){
		  echo '<strong style="color:#E23237;">'.$datas['name'].'</strong>';  
        }else{
          echo '<strong>'.$datas['name'].'</strong>';  
        }
	}
