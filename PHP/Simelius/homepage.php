<?php
require 'init.php';


$title = "Accueil";
$styles = ['views/'.THEME.'/css/homepage.css'];
include THEME_PATH . DS .'header.phtml' ;
include THEME_PATH . DS . 'homepage.phtml';
