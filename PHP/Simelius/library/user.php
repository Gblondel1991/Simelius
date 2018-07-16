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

function register (PDO $pdo, $profession, $lastname, $firstname, $email, $password, $society, $experience, $profile_picture) {
    $sql = 'INSERT INTO user VALUES (:user_id, :profession_id, :lastname, :firstname, :email, :password, :society, :experience, :created_at, :profile_picture)';

    $stmt = $pdo->prepare($sql);
    $data = [
        'user_id' => null,
        'profession_id' => $profession,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'society' => $society,
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
          u.society,
          u.experience,
          u.profile_picture,
          u.email,
          u.created_at,
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

function updateUserInformations($pdo, $updateUser) {
    $sql = 'UPDATE user SET
                lastname = ?,
                firstname = ?,
                email = ?,
                password = ?,
                society = ?,
                experience = ?,
                profile_picture = ?
                WHERE user_id = ?;';

    $stmt =$pdo->prepare($sql);

    $dataComment = array(
        $updateUser['lastname'],
        $updateUser['firstname'],
        $updateUser['email'],
        $updateUser['password'],
        $updateUser['society'],
        $updateUser['experience'],
        $updateUser['profile_picture'],
        $updateUser['user_id']
    );

    if ($stmt->execute($dataComment)) {
        return true;
    }
    return false;
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

function userArticlesCount($pdo, $user_id) {
    $sql = 'SELECT count(*) FROM article WHERE user_id = ?';

    $stmt =$pdo->prepare($sql);
    $userArticlesCount = [];
    if ($stmt->execute(array($user_id))) {
        $userArticlesCount = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $userArticlesCount;
}

function userCommentsCount($pdo, $user_id) {
    $sql = 'SELECT count(*) FROM comment WHERE user_id = ?';

    $stmt =$pdo->prepare($sql);
    $userCommentsCount = [];
    if ($stmt->execute(array($user_id))) {
        $userCommentsCount = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $userCommentsCount;
}

function getUserRelevanceRate($pdo, $user_id) {
    $sql = 'SELECT COUNT(comment_id) from revelant_answer WHERE user_id = ?;';

    $stmt =$pdo->prepare($sql);
    $userRelevanceRate = [];
    if ($stmt->execute(array($user_id))) {
        $userRelevanceRate = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $userRelevanceRate;
}

function getUsersCommunity($pdo, $profession_id) {
    $sql = 'SELECT count(*) FROM user WHERE profession_id = ?';

    $stmt =$pdo->prepare($sql);
    $usersCountByCommunity = [];
    if ($stmt->execute(array($profession_id))) {
        $usersCountByCommunity = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $usersCountByCommunity;
}

function getArticlesCountByCommunity($pdo, $profession_id) {
    $sql = 'SELECT count(*) FROM article as a JOIN `user` as u  WHERE u.profession_id = ?';

    $stmt =$pdo->prepare($sql);
    $articlesCountByCommunity = [];
    if ($stmt->execute(array($profession_id))) {
        $articlesCountByCommunity = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $articlesCountByCommunity;
}

function getCommentsCountByCommunity($pdo, $profession_id) {
    $sql = 'SELECT count(*) FROM comment as a JOIN `user` as u  WHERE u.profession_id = ?';

    $stmt =$pdo->prepare($sql);
    $commentsCountByCommunity = [];
    if ($stmt->execute(array($profession_id))) {
        $commentsCountByCommunity = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $commentsCountByCommunity;
}

function getRelevanceRateByCommunity($pdo, $profession_id) {
    $sql = 'SELECT COUNT(comment_id) from revelant_answer as ra JOIN `user` as u  WHERE u.profession_id = ?';

    $stmt =$pdo->prepare($sql);
    $relevanceRateByCommunity = [];
    if ($stmt->execute(array($profession_id))) {
        $relevanceRateByCommunity = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return $relevanceRateByCommunity;
}