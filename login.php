<?php
include_once __DIR__ . '/User.php';

$username = $_POST['username'];
$password = $_POST['password'];

$user = new User($username, $password);
// var_dump($user);

if ($user->error) {
	echo $user->error;
} else { ?>
	<nav><?= $user->username ?></nav><?php
}
