<?php
require 'init.php';
require LIB_PATH . DS . 'blog.php';

$title = 'Nouvel article';
$category = getCategories($db);
$inputTitle = $_POST['title'] ?? null;
$teaser = $_POST['teaser'] ?? null;
$content = $_POST['content'] ?? null;
$status = $_POST['status'] ?? false;
$inputCats = $_POST['category'] ?? [];

print_r($category);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newArticle = $_POST;
    $newArticle['user_id'] = $_SESSION['user']['user_id'];
    if (addArticle($db, $newArticle)) {
        header('Location: homepage.php');
        exit;
    }
}






include THEME_PATH . DS . 'homepage.phtml';