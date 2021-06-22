<?php

session_start();

require("../funcs.php");

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

session_destroy();

redirect("index.php");
exit();
