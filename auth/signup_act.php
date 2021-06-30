<?php

session_start();

// DB接続とfancs.phpを読み込み
require("../dbset/dbset.php");
require("../funcs.php");

// signin.phpのフォーム値を受け取り
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

// パスワードのハッシュ化
$hash = password_hash($password, PASSWORD_DEFAULT);


//
// ここから下で各種バリデーションを設定
//
//空白不可
if (!empty($_POST["name"] && $_POST["email"] && $_POST["password"]) && mb_strlen($_POST["password"]) >= 6) {

    // トークンで不正ログインを判定
    if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {

        //メールアドレス以外が入力された場合はエラーにする
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

            //emailが重複した場合にエラーにする
            $sql = "SELECT COUNT(*) AS cnt FROM users WHERE email=?";
            $stmt = $pdo->prepare($sql);
            $res = $stmt->execute(array($_POST["email"]));
            $val = $stmt->fetch();
            if ($val["cnt"] > 0) {
                echo "重複してます";
            } else {

                // 上記のバリデーション全てに該当しなかった場合
                // データベースへ保存を行う
                $sql = "INSERT INTO users(name, email, password, indate)VALUES(:name, :email, :password, sysdate())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':password', $hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $status = $stmt->execute();

                if ($status==false) {
                    $error = $stmt->errorInfo();
                    exit("SQLError:".$error[2]);
                } else {
                    $_SESSION["name"] = $u_name;
                    $_SESSION["chk_ssid"] = session_id();
                    redirect("../index.php");
                    exit();
                }
            }
        } else {
            echo "メールアドレスをご入力ください";
        }
    } else {
        redirect("login.php");
    }
} else {
    redirect("login.php");
}
