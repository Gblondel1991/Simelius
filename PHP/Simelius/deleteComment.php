<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$comment_id = $_POST['comment_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST;
    $comment['user_id'] = $_SESSION['user']['user_id'];
    deleteComment($db, $comment_id);
    header("Location: ".$_SERVER['HTTP_REFERER']);
}