<?php
include_once('../utils/session.php');

session_destroy();
session_start();

$_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged out!');

die(header('Location: ../pages/login.php'));