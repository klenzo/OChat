<?php
	function bbcode($msg){
		$msg = preg_replace('#-([a-zA-Z0-9_-]+)-#', "<img src=\"smileys/$1.png\" alt=\"$1\" class=\"icon_interchat\">", $msg);
		$msg = str_replace(array(':)', ':-)'), "<img src=\"smileys/happy.png\" alt=\"happy\" class=\"icon_interchat\">", $msg);
		return $msg;
	}

if($lang === 'fr'){
	function showdate($time){
	  $date = time()-$time;
	  if($date < 60){$date = "Il y a moins d'une minute";}
	  else if($date < 3600){$date = 'Il y a '.round(($date/60),0,PHP_ROUND_HALF_DOWN).' min';}
	  else if($date < 86400){$date = 'Il y a '.round(($date/3600),0,PHP_ROUND_HALF_DOWN).'h';}
	  else if($date < 432000){$date = 'Il y a '.round(($date/86400),0,PHP_ROUND_HALF_DOWN).' jours';}
	  else{$date = date('d/m/Y', $time).' '.date('H:i', $time);}
	  return $date;
	}
}else{
	function showdate($time){
	  $date = time()-$time;
	  if($date < 60){$date = "Less than a minute ago";}
	  else if($date < 3600){$date = 'There is '.round(($date/60),0,PHP_ROUND_HALF_DOWN).' min';}
	  else if($date < 86400){$date = 'There is '.round(($date/3600),0,PHP_ROUND_HALF_DOWN).'h';}
	  else if($date < 432000){$date = 'There is '.round(($date/86400),0,PHP_ROUND_HALF_DOWN).' days';}
	  else{$date = date('d/m/Y', $time).' '.date('H:i', $time);}
	  return $date;
	}
}

?>
