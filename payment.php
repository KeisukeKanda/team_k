<?php
require("./dbset/dbset.php");
require("./funcs.php");
session_start();

// POSTで取ることを想定
$reservation_id = $_GET["reservation_id"];
$user_id = $_SESSION["user_id"];


// reservationテーブルから呼び出す予約日時を呼び出して表示
$sql = "SELECT*FROM reservation AS r INNER JOIN project AS p ON r.project_id=p.project_id WHERE reservation_id=:reservation_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':reservation_id', $reservation_id, PDO::PARAM_INT);
$status = $stmt->execute();

//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if ($status == false) {
    sql_error($stmt);
} else {
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/payment.css">
    <link rel="stylesheet" href="./css/footer.css">
    <!-- 購入ボタンのCSS -->
    <style type="text/css">
        .stripe-button-el {
            width: 200px;
            max-width: 100%;
        }

        .stripe-button-el span {
            font-size: 18px;
            padding-top: 15px;
        }

        .pay {
            display: flex;
            margin: auto;
            justify-content: center;
        }
    </style>

</head>

<body>
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>

    <div class="contents">
        <h1>支払</h1>
        <div class="user_reservation">
            <p class="confirm_contents"><?= $res["title"] ?>
            </p>
            <p class="confirm_contents"><?= $res["date"] ?>　<?= $res["reservation_time"] ?>
            </p>
            <p class="confirm_contents">ご予約ありがとうございます！支払に進んでください。</p>
            <h1></h1>
            <form action="mail_input1.php" method="post">
                <div class="pay">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="pk_test_51J7aRMADniaDh1o9fjnOTyeDYeYNVmqC1rjbP5e0PqVx4kbBepEMbQG8I0QivqgAYGC2TYjnLmJT8BsqIK9XZUNK00U3rO2Wlc"
                        data-amount="<?= $res["price"] ?>"
                        data-name="この商品の料金は<?= $res["price"] ?>円です"
                        data-locale="auto" data-allow-remember-me="false" data-label="支払に進む" data-currency="jpy">
                    </script>
                </div>
                <input type="hidden" name="reservation_id"
                    value="<?= $res["reservation_id"] ?>">
                <h1></h1>
            </form>
        </div>
    </div>
    <?php include("component/footer.php") ?>
</body>

</html>