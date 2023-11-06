<?php
require_once('./util/security.php');
session_start();
Security::checkHTTPS();

$_SESSION['working_dir'] = getcwd();

header('Location: view/login.php');