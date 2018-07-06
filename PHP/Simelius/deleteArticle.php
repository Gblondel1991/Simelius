<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$article_id = $_POST['article_id'] ?? null ;

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteArticle($db, $article_id);
    header("Location: ".$_SERVER['HTTP_REFERER']);
}