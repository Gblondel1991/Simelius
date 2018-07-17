<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);
$articles = getUserArticles($db, $_SESSION['user']['user_id']);
$usersCountByCommunity = getUsersCommunity($db, $_SESSION['user']['profession_id']);
$articlesCountByCommunity = getArticlesCountByCommunity($db,$_SESSION['user']['profession_id']);
$relevanceRateByCommunity = getRelevanceRateByCommunity($db,$_SESSION['user']['profession_id']);
$commentsCountByCommunity = getCommentsCountByCommunity($db, $_SESSION['user']['profession_id']);
$category = getCategories($db);

$title = "Mes Contributions";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'myContributions.phtml';