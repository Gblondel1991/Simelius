<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$comment_id = $_POST['comment_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $relevance = $_POST;
    $relevance['user_id'] = $_SESSION['user']['user_id'];
    if (addRelevance($db, $relevance)) {
        header('Location: homepage.php');
    }
}