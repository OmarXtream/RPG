<?php
if(count(get_included_files()) == 1){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.name','STAFFSESSID');
    ini_set('session.cookie_httponly', true);
    ini_set('session.cookie_secure', true);
    ini_set('session.cookie_domain', '.rpggta.com');

   session_start();
}

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

if(!isset($_SESSION['staffId:rpg'])){
	exit(header('Location: ./login'));
}

if(!isset($_SESSION['last_ip'])){
	$_SESSION['last_ip']=$_SERVER['REMOTE_ADDR'];
}


if(!isset($_SESSION['userAgent'])){
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
}



if($_SESSION['last_ip'] !== $_SERVER['REMOTE_ADDR'] or $_SESSION['userAgent'] !== $_SERVER['HTTP_USER_AGENT']){
	session_unset();
	session_destroy();
	exit(header("Location: ./login"));
}

if(rand(1, 100) <= 5){
	// If this session is obsolete it means there already is a new id
	if(isset($_SESSION['OBSOLETE']))
		return;

	// Set current session to expire in 10 seconds
	$_SESSION['OBSOLETE'] = true;
	$_SESSION['EXPIRES'] = time() + 10;

	// Create new session without destroying the old one
	session_regenerate_id(false);

	// Grab current session ID and close both sessions to allow other scripts to use them
	$newSession = session_id();
	session_write_close();

	// Set session ID to the new one, and start it back up again
	session_id($newSession);
	session_start();

	// Now we unset the obsolete and expiration values for the session we want to keep
	unset($_SESSION['OBSOLETE']);
	unset($_SESSION['EXPIRES']);
		}

$inactive = 1800;
if( !isset($_SESSION['timeout']) ) {
$_SESSION['timeout'] = time() + $inactive;
}

$session_life = time() - $_SESSION['timeout'];

if($session_life > $inactive)
{ 
	session_unset();
	session_destroy();
	header("Location: ./login?timeout=1");
	exit;
}

if(!rankPermission($_SESSION['staffId:rpg'],1))
{ 
	session_unset();
	session_destroy();
	header("Location: ./login?aaa");
	exit;
}

$_SESSION['timeout']=time();

?>