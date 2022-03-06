<?php

define('HOST', '127.0.0.1'); // Database host name ex. localhost
define('USER', 'academy'); // Database user. ex. root ( if your on local server)
define('PASSWORD', 'Dc4HjjtBWp'); // Database user password  (if password is not set for user then keep it empty )
define('DATABASE', 'clockin'); // Database name
define('CHARSET', 'utf8');

function DB()
{
    static $instance;
    if ($instance === null) {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => FALSE,
        );
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;
        $instance = new PDO($dsn, USER, PASSWORD, $opt);
    }
    return $instance;
}

?>