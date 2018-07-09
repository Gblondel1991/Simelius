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

function register (PDO $pdo, $profession, $lastname, $firstname, $email, $password, $experience, $profile_picture) {
    $sql = 'INSERT INTO user VALUES (:user_id, :profession_id, :lastname, :firstname, :email, :password, :experience, :created_at, :profile_picture)';

    $stmt = $pdo->prepare($sql);
    $data = [
        'user_id' => null,
        'profession_id' => $profession,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'experience' => $experience,
        'created_at' => date('Y-m-d H:i:s'),
        'profile_picture' => $profile_picture
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

function getUserInformations (PDO $pdo, $user_id) {
    $sql = 'SELECT 
          u.user_id,
          u.firstname,
          u.lastname,
          u.profession_id,
          u.experience,
          u.profile_picture,
          p.name
          FROM profession as p
          JOIN user as u
          ON p.profession_id = u.profession_id
          WHERE user_id = ?;';

    $stmt =$pdo->prepare($sql);
    $userInformations = [];
    if ($stmt->execute(array($user_id))) {
        $userInformations = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $userInformations;
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

function experience($experienceStart) {
    $experience = (strtotime(date('Y-m-d')) - strtotime($experienceStart))/3600/24;
    $years = intval($experience/365);
    $days = $experience%365;

    return array($years, $days);
}