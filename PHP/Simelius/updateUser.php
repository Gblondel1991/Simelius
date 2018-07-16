<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';
require LIB_PATH . DS .'validator.php';

$user_id = $_SESSION['user']['user_id'] ;
$lastname = $_POST['lastname'] ?? null;
$firstname = $_POST['firstname'] ?? null;
$email = $_POST['email'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$password = $_POST['password'] ?? null;
$password2 = $_POST['password2'] ?? null;
$experience = $_POST['birthday'] ?? null;
$society = $_POST['society'] ?? null;

if (!empty($_FILES)) {
    $profile_picture = $_FILES['profile_picture'];
    $errors = [];
    $exts = ['jpeg', 'jpg', 'png', 'gif'];
    $tmpPath = $profile_picture['tmp_name'];

    define('MAX', round((1024 * 1024) * 2)); // 1Mo
    if ($profile_picture['size'] > MAX) {
        $errors[] = 'Poids maximum autorisé: ' . (MAX / 1024 / 1024) . 'Mo';
    }

    $ext = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), $exts)) {
        $errors[] = 'Extension non valide';
    }

    switch ($profile_picture['error']) {
        case UPLOAD_ERR_INI_SIZE:
            $errors[] = "La taille du fichier téléchargé excède la valeur attendu";
            break;
        case UPLOAD_ERR_NO_FILE:
            $errors[] = "Aucun fichier n'a été téléchargé";
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $errors[] = "Échec de l'écriture du fichier sur le disque";
            break;
    }

    if (empty($errors)) {
        $b = random_bytes(8);
        $name = bin2hex($b);

        $destination = AVATARS_PATH . DS . $name . '.' . $ext;
        move_uploaded_file($tmpPath, $destination);
        $namepath = 'views/default/images/avatars/' . $name . '.' . $ext;
    }}

$profile_picture = $namepath;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $updateUser = $_POST;
    updateUserInformations($db, $updateUser);
    print_r($updateUser);
  //  header("Location: ".$_SERVER['HTTP_REFERER']);
}}