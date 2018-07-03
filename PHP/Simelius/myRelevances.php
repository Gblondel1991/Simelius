<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'blog.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);
$articles = getUserRelevances($db, $_SESSION['user']['user_id']);
$category = getCategories($db);

$title = "Mes réponses pertinentes";
$styles = ['views/'.THEME.'/css/myrelevances.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'myRelevances.phtml';