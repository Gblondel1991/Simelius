<?php
function hasSession() {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

function authenticate(PDO $pdo, $email, $password) {
    $sql = 'SELECT * FROM user WHERE email=?';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(array($email))) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
    }
    return false;
}

function register (PDO $pdo, $profession, $lastname, $firstname, $email, $password) {
    $sql = 'INSERT INTO user VALUES (:user_id, :profession_id, :lastname, :firstname, :email, :password, :birthday, :created_at)';

    $stmt = $pdo->prepare($sql);
    $data = [
        'user_id' => null,
        'profession_id' => $profession,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'birthday' => date('Y-m-d'),
        'created_at' => date('Y-m-d H:i:s'),
    ];

    if ($stmt->execute($data)) {
        return 1;
    }
return 0;
}

function getProfession (PDO $pdo) {
    $sql = 'SELECT profession_id, name FROM profession';
    $stmt =$pdo->prepare($sql);

    $profession= [];
    if ($stmt->execute()) {
        $profession = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $profession;
}

function isUserExists(PDO $pdo, $email) {
    $stmt = $pdo->prepare('SELECT email FROM user WHERE email=?');
    if ($stmt->execute(array($email))) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user !== false) {
            return true;
        }
    }
    return false;
}