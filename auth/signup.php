<?php

session_start();

// DB接続とfancs.phpを読み込み
require("../db_set/db.php");
require("../funcs.php");

//CSRF対策
$csrfToken = csrf();
$_SESSION['csrfToken'] = $csrfToken;

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/signup.css">
    <title>Document</title>
</head>

<body>
    <!-- <div class="wrap">
        <div class="box">
            <div class="form-box">
                <form action="signup_act.php" method="post">
                    <div class="input-box">
                        <label for="fname">ユーザー名（ニックネーム）</label>
                        <input type="text" name="name" required><br>
                    </div>
                    <div>ユーザーID（emailアドレス）</div>
                    <input type="text" name="email" required><br>
                    <div>パスワード（6文字以上）</div>
                    <input type="password" name="password" required pattern="(?=.*\d).{6,}"
                        title="6文字以上のパスワードを入力してください。"><br>
                    <input type='hidden' name='csrfToken'
                        value='<?= $csrfToken ?>'>
    <input type="submit" value="登録する">
    </form>
    <div>
        すでにアカウントがある方は
        <a href="login.php">こちら</a>
    </div>
    <a href="../index.php">戻る</a>
    </div>
    </div>
    </div> -->

    <div class="wrap">
        <h1>Team Kプロダクトへようこそ</h1>
        <h3>新たな世界へ冒険しましょう！</h3>
        <form action="signup_act.php" method="post">
            <div class="input-box">
                <div>
                    <label for="fname">ユーザー名（ニックネーム）</label>
                    <input type="text" name="name" required>
                </div>

                <div class="input-box">
                    <label for="lname">ユーザーID（emailアドレス）</label>
                    <input type="text" name="email" required>
                </div>

                <div class="input-box">
                    <label for="email">パスワード（6文字以上）</label>
                    <input type="password" name="password" required pattern="(?=.*\d).{6,}">
                </div>
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'>
                <input class="submit-btn" type="submit" value="登録する">
            </div>
        </form>
        <div>
            すでにアカウントをお持ちの方は
            <a href="login.php">こちら</a>
        </div>
        <!-- <a href="../index.php">戻る</a> -->
    </div>

    <!-- jQueryの読み込み -->
    <script src=" https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $('input').on('focusin', function() {
            $(this).parent().find('label').addClass('active');
        });

        $('input').on('focusout', function() {
            if (!this.value) {
                $(this).parent().find('label').removeClass('active');
            }
        });
    </script>

</body>

</html>