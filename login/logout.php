<?php
include $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';
session_destroy();
unset($_SESSION);
setcookie('PHPSESSID', '', 1);
header("Location: /");
