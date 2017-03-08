<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'test');
define('DB_PASS', 'test');

if(defined('TEST')) {
    define('DB_NAME', 'repository-test');
}
else {
    define('DB_NAME', 'repository');
}
