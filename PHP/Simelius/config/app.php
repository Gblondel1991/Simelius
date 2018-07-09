<?php
//DIRECTORIES
define('ROOT_PATH', dirname(__DIR__));
define('LIB_PATH', ROOT_PATH . DS . 'library');
define('VIEWS_PATH', ROOT_PATH . DS . 'views');
define('CONF_PATH', ROOT_PATH. DS . 'config');


//DATABASE
// DSN == Data Source Name
define('DB_DSN', 'mysql:host=localhost;dbname=Simelius;charset=utf8');
define('DB_USER', 'root');
define ('DB_PASS', '');

// APP
define('APP_NAME', 'Simelius');
define('THEME', 'default');
define('THEME_PATH', VIEWS_PATH . DS . THEME);
define('BASE_URL', '/Simelius');

define('IMAGES_PATH', THEME_PATH . DS . 'images');
define('AVATARS_PATH', IMAGES_PATH . DS . 'avatars');
define ('CSS_PATH', THEME_PATH . DS . 'css');