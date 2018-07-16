<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';

$professionfromdb = getProfession($db);
$user = getUserInformations($db, $_SESSION['user']['user_id']);
$experience= experience($user['experience']);
$userArticlesCount = userArticlesCount($db, $_SESSION['user']['user_id']);
$userCommentsCount = userCommentsCount($db, $_SESSION['user']['user_id']);
$userRelevanceRate = getUserRelevanceRate($db, $_SESSION['user']['user_id']);

$title = "Accueil";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'userProfile.phtml';