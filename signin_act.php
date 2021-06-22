<?php

session_start();

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


$u_name = $_POST["u_name"];
$u_id = $_POST["u_id"];
$u_pw = $_POST["u_pw"];
$hash = password_hash($u_pw, PASSWORD_DEFAULT);

//空白不可
if (!empty($_POST["u_name"] && $_POST["u_id"] && $_POST["u_pw"]) && mb_strlen($_POST["u_pw"]) >= 6) {
    // トークン判定
    if ($_POST['csrfToken'] === $_SESSION['csrfToken']) {
        //メアドかどうか判定
        if (filter_var($_POST["u_id"], FILTER_VALIDATE_EMAIL)) {
            //u_idの重複判定
            $sql = "SELECT COUNT(*) AS cnt FROM users WHERE u_id=?";
            $stmt = $pdo->prepare($sql);
            $res = $stmt->execute(array($_POST["u_id"]));
            $val = $stmt->fetch();
            if ($val["cnt"] > 0) {
                echo "重複してます";
            } else {
                $sql = "INSERT INTO users(u_name, u_id, u_pw, created_date)VALUES(:u_name, :u_id, :u_pw, sysdate())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':u_id', $u_id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $stmt->bindValue(':u_pw', $hash, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
                $status = $stmt->execute();

                if ($status==false) {
                    $error = $stmt->errorInfo();
                    exit("SQLError:".$error[2]);
                } else {
                    $_SESSION["u_name"] = $u_name;
                    $_SESSION["chk_ssid"] = session_id();
                    redirect("index_login.php");
                    exit();
                }
            }
        } else {
            echo "メアドを入れてください";
        }
    } else {
        redirect("index.php");
    }
} else {
    redirect("signin.php");
}
