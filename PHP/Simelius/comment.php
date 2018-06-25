<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$articles = getArticles($db, $_SESSION['user']['profession_id']);
$content = $_POST['content'] ?? null;
$articleId = $_POST['article_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST;
    $comment['user_id'] = $_SESSION['user']['user_id'];
    if (addComment($db, $comment)) {
        header('Location: homepage.php');
        exit;
    }
}

//header('Location: homepage.php');