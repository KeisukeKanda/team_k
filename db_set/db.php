<?php

try {
    // ローカル環境
    $pdo = new PDO('mysql:dbname=teamk_db;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError:'.$e->getMessage());
}
