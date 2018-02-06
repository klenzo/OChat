<?php

require_once 'plugins/class.phpmailer.php';

session_start();

define('EmplacementPrimaire', 'C');
define('EmplacementSecondaire', 'T');
define('Pharmacie', 'P');

date_default_timezone_set('UTC');

$caracteres = array('Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a', '@' => 'a',
		'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', '€' => 'e',
		'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
		'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'µ' => 'u',
		'Œ' => 'oe', 'œ' => 'oe',
		'$' => 's','\'' => ' ');

$tabJourSemaine = array('DI', 'LU', 'MA', 'ME', 'JE', 'VE', 'SA', 'DI');

/* * ************************** */
/* * * Utilisateur Connecté  ** */
/* * ************************** */
if (strstr($_SERVER['PHP_SELF'], 'index.php') == '' && strstr($_SERVER['PHP_SELF'], 'login.php') == '') {
    if (!isset($_SESSION['nom'])) {
        header('location:index.php?e=notlogged');
        exit;
    }


function formatNomPropre($nom) {
    $nom = " " . strtolower($nom);
    //$nom = preg_replace("/(\s+|-)(\w)/e", "'\\1' . strtoupper('\\2')", $nom);
    $nom = preg_replace_callback("/(\s+|-)(\w)/", function($m){return $m[1] . strtoupper($m[2]);}, $nom);   
    $nom = trim($nom);
    return $nom;
}


 function vd($data){
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
        }

function dateEnISO($date) {
    return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
}

class DateTimeFrench extends DateTime {

    public function format($format) {
        $english_short_days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
        $french_short_days = array('Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');

        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

        return str_replace($english_months, $french_months, str_replace($english_short_days, $french_short_days, (str_replace($english_days, $french_days, parent::format($format)))));
    }

}

function Password() {
    $ddate = new DateTimeFrench();
    $password = substr($ddate->format('D'), 0, 1);
    if ($ddate->format('L') === 1) {
        $password .= 366 - ($ddate->format('z') + 1);
    } else {
        $password .= 365 - ($ddate->format('z') + 1);
    }

    return $password;


/*** Récupératon des 2 dernières dates de campagne ***/
function getListeCampagnes() {
    $annee = date("Y");
    $mois = date("m");
    $ListeCampagnes = array();
    if($mois >= 7) {
        $ListeCampagnes[0] = ($annee-1) . "-" . ($annee);
        $ListeCampagnes[1] = ($annee-2) . "-" . ($annee-1);
    }
    else {
        $ListeCampagnes[0] = ($annee-2) . "-" . ($annee-1);
        $ListeCampagnes[1] = ($annee-3) . "-" . ($annee-2);
    }
    return $ListeCampagnes;
}

function getParametres() {
    $param = ['smtp' => array()];
    
    $filename = "params.xml";
    $xml = simplexml_load_file($filename);
    if ($xml === false) {
        throw new Exception("Fichier xml incorrect.");
    }
    
    // paramètres de connexion au SGBD.
    $param['smtp']['host'] = (string)$xml->smtp->host;
    $param['smtp']['port'] = (int)$xml->smtp->port;
    $param['smtp']['user'] = (string)$xml->smtp->user;
    $param['smtp']['password'] = (string)$xml->smtp->password;
    $param['smtp']['from'] = (string)$xml->smtp->from;

    return $param;
}

function envoiMail($to, $subject, $body) {
    $params = getParametres();
    
    new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP();
    //$mail->SMTPDebug = 2;
    $mail->SMTPAuth = false;
    $mail->Host = $params['smtp']['host'];
    $mail->Port = $params['smtp']['port'];
    $mail->SMTPSecure = '';

    $mail->setFrom($params['smtp']['from'], 'Web PMC');

    for($i = 0; $i < count($to); $i++) {
        $mail->addAddress($to[$i]);
    }

    $mail->Subject = "=?utf-8?b?".base64_encode($subject)."?=";
    $mail->IsHTML();
    $body = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>' . $body . '</body></html>';
    $mail->MsgHTML($body);

    if (!$mail->send()) {
        echo "Erreur lors de l'envoi du mail : " . $mail->ErrorInfo;
    }
}
?>
