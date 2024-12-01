<?php
$slash = "/";
if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
    $slash = "\\";
}
define('DIRECTORY_SEPERATOR', $slash);


spl_autoload_register(function ($class_name) {
    $path = explode("\\", $class_name);
    $fileName = array_pop($path);
    include implode(DIRECTORY_SEPERATOR , $path) . DIRECTORY_SEPERATOR . $fileName . '.php';
});
