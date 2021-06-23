<?php

session_start();

// DB接続とfancs.phpを読み込み
require("../db_set/db.php");
require("../funcs.php");

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// セッションを破棄してログアウトする
session_destroy();

redirect("../index.php");
exit();
