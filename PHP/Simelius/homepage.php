<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);
$articles = getArticles($db, $_SESSION['user']['profession_id']);

$title = 'Nouvel article';
$category = getCategories($db);
$inputTitle = $_POST['title'] ?? null;
$content = $_POST['content'] ?? null;
$status = $_POST['status'] ?? false;
$inputCats = $_POST['category'] ?? [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newArticle = $_POST;
    $newArticle['user_id'] = $_SESSION['user']['user_id'];
    if (addArticle($db, $newArticle)) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }
}

$title = "Accueil";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'homepage.phtml';