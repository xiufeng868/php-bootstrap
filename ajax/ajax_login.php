<?php 
require_once('ajax_common.php');

$SAEDB = new SaeMysql();

@$username = strip_tags($_REQUEST['username']);
@$password = strip_tags($_REQUEST['password']);
$sql = "select * from user where username='" . $username . "' and password='" . $password . "'";

$result = $SAEDB->getLine($sql);

if ($SAEDB->errno() != 0) {
	die('Error: ' . $SAEDB->errmsg());
}
if ($result === false || $result === NULL) {
	die('0');
}
if ($result['isactive'] === '0') {
	die('2');
}

session_start();
$_SESSION['userid'] = $result['id']; 
$_SESSION['username'] = $result['username'];
$_SESSION['email'] = $result['email'];
$_SESSION['isadmin'] = $result['isadmin'];
echo '1';

$SAEDB->closeDb(); 
?>
