<?php

session_start();

// DB接続とfancs.phpを読み込み
require("../db_set/db.php");
require("../funcs.php");


// ログインフォームで入力した値の受け取り
$email = $_POST['login_id'];
$password = $_POST['password'];


    //空白を許可しない
    if (!empty($_POST['login_id'])) {

        // csrf対策
        if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $res = $stmt->execute();
            if ($res==false) {
                sql_error($stmt);
            }

            // ログインユーザー情報のみをfetchで取得
            $val = $stmt->fetch();

            // 入力されたパスワードとハッシュ化されたパスワードを照合
            if (password_verify($password, $val["password"]) === true) {

                // セッションIDとログインユーザー名をセッションに保存
                if ($val["user_id"] !="") {
                    $_SESSION["chk_ssid"] = session_id();
                    $_SESSION["user_id"] = $val["user_id"];
                    $_SESSION["name"] = $val["name"];

                    redirect("../index.php");
                } else {
                    redirect("login.php");
                    exit();
                }
            } else {
                redirect("login.php");
            }
        } else {
            redirect("login.php");
        }
    } else {
        echo("ログイン情報が空白です");
    }
