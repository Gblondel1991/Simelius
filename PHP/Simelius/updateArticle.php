<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$article_id = $_POST['article_id'] ?? null ;
$content = $_POST['content'] ?? null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedArticle = $_POST;
    updateArticle($db, $updatedArticle);
    header("Location: ".$_SERVER['HTTP_REFERER']);
}