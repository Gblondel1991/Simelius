<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$comment_id = $_POST['comment_id'] ?? null ;
$content = $_POST['content'] ?? null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateComment = $_POST;
    updateComment($db, $updateComment);
    header("Location: ".$_SERVER['HTTP_REFERER']);
}