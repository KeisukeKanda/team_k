<?php

session_start();

// 検索機能作成中
require("./db_set/db.php");
require("funcs.php");
$view = "";

// ログインしてるユーザー名とIDを取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];

// projectテーブルと接続
$sql = "SELECT * FROM project AS p INNER JOIN users AS u ON p.user_id=u.user_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//usersテーブルと接続
// $sql = "SELECT * FROM users WHERE user_id=:user_id";
// $res = $pdo->prepare($sql);
// $res->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $state = $res->execute();
// $val = $res->fetch();

// if ($state==false) {
//     $error = $res->errorInfo();
//     exit("SQLError:".$error[2]);
// }


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">

    <!-- ここからカレンダーのテスト -->
    <script src="https://kit.fontawesome.com/41d0c3f425.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/test.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>

        <!-- メインビュー -->
        <div class="firstview">
            <div class="firstview-text">
                <p>知らない場所には</p>
                <p>知らない人がいる</p>
                <!-- 検索機能作成中 -->
                <input type="text" id="search1" placeholder="国名、地域">
                <input type="text" id="search3" placeholder="キーワード">

                <input type="text" style="display:none" size="10" class="calendar_pop" id="input1" />
                <i id="calendar" class="fas fa-calendar-alt calendar"></i>

                <button id="send">検索</button>
            </div>
            <div class="back-color"></div>
        </div>
        <!-- メインビュー終わり -->

        <!-- 検索結果の割り込み表示 -->
        <div class="container jumbotron" id="view"><?php echo $view; ?>
        </div>

        <!-- プラン一覧を表示 -->
        <div class="main">
            <div class="main-container">
                <h1 class="title">新着の体験</h1>
                <div class="box">
                    <?php foreach ($stmt as $content): ?>
                    <div class="content">
                        <!-- projectの画像と文字に詳細画面へのリンクを付与
                        URLでuser_idとproject_idを遷移先ページへと引き渡す-->
                        <a
                            href="./selected_project.php?project_id=<?= $content['project_id'] ?>">
                            <div class="content-img">
                                <img src='project_img/<?= $content["project_img"] ?>'
                                    alt="体験できるプロジェクトの画像">
                                <!-- ＜テスト中＞hoverしたら出てくる要素 -->
                                <!-- <div class="comment">
                                    <?= $content["title"] ?>
                            </div> -->
                    </div>
                    <div class="content-title">
                        <?= $content["title"] ?>
                    </div>
                    <!-- <div class="content-text">
                            <?= $content["experience"] ?>
                </div> -->
                </a>
                <a
                    href="host_profile.php?user_id=<?= $content["user_id"] ?>">
                    <div class="host-info">
                        <img src="./user_img/<?= $content["user_img"] ?>"
                            alt="プロジェクトホストの写真" class="host-img">
                        <div class="nickname">
                            made by <?= $content["nickname"] ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    </div>
    <!-- プラン一覧を表示終わり -->

    </div>

    <!-- 検索結果 -->
    <div class="container jumbotron" id="view"><?php echo $view; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- カレンダーアイコンのクリックイベント作成 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script>
        $(function() {
            $.datepicker.setDefaults($.datepicker.regional["ja"]);
            $("#input1").datepicker();
        });
    </script>

    <script>
        var calendar = document.getElementById('calendar');
        var input1 = document.getElementById('input1');

        calendar.addEventListener('click', function() {
            input1.style.display = 'block';
        });



        $("#send").on("click", function() {
            //Ajax（非同期通信）
            //1．パラメータの変更
            //2. 送信先
            //3. DOM操作
            const params = new URLSearchParams();
            params.append('search1', $("#search1").val());
            params.append('search3', $("#search3").val());
            params.append('search4', $("#search4").val());

            //axiosでAjax送信
            axios.post('index_search2.php', params).then(function(response) {
                console.log(response.data); //通信OK
                $("#view").html(response.data);
            }).catch(function(error) {
                console.log(error); //通信Error
            }).then(function() {
                console.log("Last"); //通信OK/Error後に処理を必ずさせたい場合
            });
        });
    </script>

    <script>
        // プロジェクトをhoverした際、右側にポップアップを表示させる
        $(function() {
            $('.comment').hide();
            $('.content-img').hover(
                function() {
                    $(this).children('.comment').fadeIn('fast');
                },
                function() {
                    $(this).children('.comment').fadeOut('fast');
                });
        });
    </script>

    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>
</body>

</html>