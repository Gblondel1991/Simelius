<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);
$userArticlesCount = userArticlesCount($db, $_SESSION['user']['user_id']);
$userCommentsCount = userCommentsCount($db, $_SESSION['user']['user_id']);
$userRelevanceRate = getUserRelevanceRate($db, $_SESSION['user']['user_id']);
$usersCountByCommunity = getUsersCommunity($db, $_SESSION['user']['profession_id']);
$articlesCountByCommunity = getArticlesCountByCommunity($db,$_SESSION['user']['profession_id']);
$relevanceRateByCommunity = getRelevanceRateByCommunity($db,$_SESSION['user']['profession_id']);
$commentsCountByCommunity = getCommentsCountByCommunity($db, $_SESSION['user']['profession_id']);

$articles['research'] = $_GET['q'];
$articles['profession_id'] = $_SESSION['user']['profession_id'];

$articles = getArticlesByResearch($db, $articles);

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

$title = "Résultats";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'research.phtml';