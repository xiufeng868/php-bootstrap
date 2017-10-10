<?php
session_start();
$userid = $_SESSION['userid'];
if(!isset($userid) || empty($userid)) {
	header('Location: /login.php');
}
?>