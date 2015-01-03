<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 15-1-1
 * Time: 下午5:02
 */

session_start();
//print_r($_SESSION);die();

if ( isset($_SESSION['token']) && $_SESSION['token'] ) {
	require_once('database.php');

	$sql = "SELECT * FROM user WHERE token = '{$_SESSION['token']}'";
	$query = $db->query($sql);
	$user = $query->fetch(PDO::FETCH_ASSOC);

	if ($user && $user['id']) {
		header("Location: manage.php", TRUE, 302);
		exit();
	}
	else {
		$msg = 'Invalid Session!';
		echo $msg;
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once('database.php');
	require_once('include.php');

//	$data = array(
//		'username' => Input::post('username'),
//		'password' => Input::post('password')
//	);

	$data = array(
		Input::post('username'),
		Input::post('password')
	);

	$sql = "SELECT * FROM user WHERE username = ? AND password = ?";
	$query = $db->prepare($sql);
	$query->execute($data);
	$user = $query->fetch(PDO::FETCH_ASSOC);

	if ( !empty($user) && isset($user['id']) && isset($user['username']) ) {
		$token = md5($user['id'] . time() . $user['username']);

		$sql = "UPDATE user SET token = '{$token}' WHERE id = '{$user['id']}'";
		$query = $db->query($sql);

		if ($query) {
			$_SESSION['token'] = $token;

			header("Location: manage.php", TRUE, 302);
			exit();
		}
		else {
			// error when update token
		}
	}
	else {
		$msg = 'Invalid Password!';
//		echo $msg;
//		print_r($_POST);
//		echo $sql;
	}
}

	require('login.html');
