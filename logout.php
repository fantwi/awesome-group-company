<?php
declare(strict_types=1);
require_once 'includes/config.php';
$_SESSION = [];
session_destroy();
session_start();
flash('success', 'You have been logged out safely.');
header('Location: login.php');
exit;

