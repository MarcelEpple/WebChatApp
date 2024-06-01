<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    include str_replace('\\', '/', $class) . '.php';
});

//check if session is started else start session
//wir haben teils komische Fehlermeldungen bekommen, dass die Session schon gestartet wurde daher die Lösung
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('CHAT_SERVER_URL')) {
    define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat/');
}

if (!defined('CHAT_SERVER_ID')) {
    define('CHAT_SERVER_ID', 'c546cc42-1c6a-4fcb-8800-b9bb74e72452');
}

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
?>