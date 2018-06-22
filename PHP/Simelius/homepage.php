<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$profession = getUserProfession($db, $_SESSION['user']['user_id']);
$articles = getArticles($db, $_SESSION['user']['profession_id']);

$title = "Accueil";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'homepage.phtml';
