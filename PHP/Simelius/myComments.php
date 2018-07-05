<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);
$articles = getUserComments($db, $_SESSION['user']['user_id']);
$category = getCategories($db);

$title = "Mes Réponses";
$styles = ['views/'.THEME.'/css/myComments.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'myComments.phtml';