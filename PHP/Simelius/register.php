<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'validator.php';

$errors = [];
$lastname = $_POST['lastname'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$professionfromdb = getProfession($db);
$profession = $_POST['profession_id'] ?? [];
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$password2 = $_POST['password2'] ?? null;
$birthday = $_POST['birthday'] ?? null;

var_dump($profession);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validEmail($email, 10, 90)) {
        $errors[] = 'Email incorrect';
    }
    if (!validPassword($password, $password2, 8, 30)) {
        $errors[] =  'Mot invalide ou ne correpond pas';
    }
    if (empty($errors)) {
        // nettoyage des données.
        $email = strip_tags($email);
        $password = strip_tags($password);

        if (register($db, $profession, $lastname, $firstname, $email, $password) === 1) {
            //echo $db->lastInsertId();
            $user = authenticate($db, $email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header('Location: homepage.php');
            }
            //else si problème dans la base de données
        }
    }
}

$title = "Inscription";
$styles = ['views/'.THEME.'/css/register.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'register.phtml';