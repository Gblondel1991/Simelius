<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$articleId = $_POST['article_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteArticle($db, $articleId);
    header("Location: ".$_SERVER['HTTP_REFERER']);
}