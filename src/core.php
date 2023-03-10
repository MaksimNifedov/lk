<?php
include 'includeTemplate.php';
include 'auxiliaryFunctions.php';
session_start();
if (isset($_COOKIE['email'])) {
    setcookie('email', $_COOKIE['email'], time() + 60 * 60 * 24 * 30, '/');
}
