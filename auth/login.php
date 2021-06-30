<?php
session_start();

// DB接続とfancs.phpを読み込
require("../dbset/dbset.php");
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
    <link rel="stylesheet" href="../css/login.css">
    <title>Document</title>
</head>

<body>

    <div class="wrap">
        <h1>おかえりなさい</h1>
        <h3>新たな価値観を交換する旅に出かけましょう！</h3>

        <!-- ログインフォーム -->
        <form action="login_act.php" method="post">
            <div class="input-box">

                <!-- ユーザーIDフォーム -->
                <div class="input-box">
                    <label for="lname">ユーザーID（emailアドレス）</label>
                    <input type="text" name="login_id" required>
                </div>

                <!-- パスワードフォーム -->
                <div class="input-box">
                    <label for="email">パスワード（6文字以上）</label>
                    <input type="password" name="password" required pattern="(?=.*\d).{6,}">
                </div>

                <!-- ログインボタン（Tokenつき） -->
                <input type='hidden' name='csrfToken'
                    value='<?= $csrfToken ?>'>
                <input class="submit-btn" type="submit" value="ログイン">
            </div>
        </form>
        <!-- ログインフォームここまで -->


        <div>アカウントをお持ちでない方はこちら</div>
        <div class="new-register"><a href="signup.php">新規会員登録</a></div>
    </div>

    <!-- jQueryの読み込み -->
    <script src=" https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Sweet Alertライブラリの読み込み -->
    <script src="../js/sweetalert2.all.min.js"></script>

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
