<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';

$errors = [];
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = authenticate($db, $email, $password);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: homepage.php');
    } else {
        $errors[] = 'Identifiant ou mot de passe incorrect';
    }
}

$title = "Connexion";
$styles = ['views/'.THEME.'/css/login.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'login.phtml';