<?php

require_once(__DIR__ . "/Session/DbSession.php");
require_once(__DIR__ . "/Database/PdoDatabaseWrapper.php");

// optional
//session_name("laravel_session");
//session_set_cookie_params(0, "/", ".example.com");

$database = new PdoDatabaseWrapper("localhost", "dbname", "username", "password");
$session = new DbSession($database);


if (empty($_SESSION['test'])) {
    $_SESSION['test'] = "was empty";
} else {
    $_SESSION['test'] = "was set";
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";