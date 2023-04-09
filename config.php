<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/test5/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/test5/');

// DIR
define('DIR_APPLICATION', 'D:/Softwares/laragon/www/test5/catalog/');
define('DIR_SYSTEM', 'D:/Softwares/laragon/www/test5/system/');
define('DIR_IMAGE', 'D:/Softwares/laragon/www/test5/image/');
define('DIR_STORAGE', 'D:/Softwares/laragon/test5storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'test5');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');