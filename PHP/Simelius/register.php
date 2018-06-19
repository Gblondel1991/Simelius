<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'validator.php';

$errors = [];
$lastname = $_POST['lastname'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$professionfromdb = getProfession($db);
$profession = $_POST['profession_id'] ?? null
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
//$password2 = $_POST['password2'] ?? null;
$birthday = $_POST['birthday'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validEmail($email, 10, 20)) {
        $errors[] = 'Email incorrect';
    }
    if (!validPassword($password, $password2, 4, 4)) {
        $errors[] =  'Mot invalide ou ne correpond pas';
    }
    if (empty($errors)) {
        // nettoyage des données.
        $email = strip_tags($email);
        $password = strip_tags($password);

        if (register($db, $profession, $email, $password) === 1) {
            //echo $db->lastInsertId();
            $user = authenticate($db, $email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: homepage.php');
            }
        }
    }
}

$title = "Inscription";
$styles = ['views/'.THEME.'/css/register.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'register.phtml';