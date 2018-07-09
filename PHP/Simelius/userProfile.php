<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';

$user = getUserInformations($db, $_SESSION['user']['user_id']);

$title = "Accueil";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'userProfile.phtml';