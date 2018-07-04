<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$articleId = $_POST['article_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST;
    $comment['user_id'] = $_SESSION['user']['user_id'];
    deleteArticle($db, $articleId);
    header('Location: homepage.php');
}