<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 15-1-3
 * Time: 下午6:25
 */

session_start();
//print_r($_SESSION);die();

if ( isset($_SESSION['token']) && $_SESSION['token'] ) {
	require_once('database.php');

	$sql = "SELECT * FROM user WHERE token = '{$_SESSION['token']}'";
	$query = $db->query($sql);
	$user = $query->fetch(PDO::FETCH_ASSOC);

	if ($user && $user['id']) {
		// nothing wrong
	}
	else {
		header("Location: login.php", TRUE, 302);
		exit();
	}
}
else {
	// no session
	header("Location: login.php", TRUE, 302);
	exit();
}