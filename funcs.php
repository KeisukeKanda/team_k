<?php

// csrf対策
function csrf()
{
    $TOKEN_LENGTH = 16;
    $tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    $csrfToken = bin2hex($tokenByte);
    return $csrfToken;
}

//エラー処理
function sql_error($stmt)
{
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header("Location: ".$file_name);
    exit();
}
