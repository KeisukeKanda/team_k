<?php
require("db_set/db.php");
require("./funcs.php");
session_start();

// POSTで取ることを想定
$reservation_id = $_POST["reservation_id"];
$user_id = $_SESSION["user_id"];


// reservationテーブルから呼び出す予約日時を呼び出して表示
$sql = "SELECT*FROM reservation WHERE reservation_id=:reservation_id";
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
    <link rel="stylesheet" href="./css/reservation.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>

<body>
    <header>
        <!-- componentフォルダからヘッダーを読み込み -->
        <?php include("component/header.php") ?>
    </header>
    <main>
        <div class="contents">
            <h1>予約確認</h1>
            <div class="user_reservation">
                <p class="confirm_contents"><?= $res["title"] ?></p>
                <p class="confirm_contents"><?= $res["date"] ?>　<?= $res["reservation_time"] ?></p>
                <p class="confirm_contents">予約してもよろしいですか？？</p>
                <form action="reserve_com.php" method="post">
                    <input type="hidden" name="reservation_id" value="<?= $res["reservation_id"] ?>">
                    <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                    <input type="hidden" name="reserve_flag" value="1">
                    <div class="confirm_contents"><input type="submit" value="はい" class="go"></div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php include("component/footer.php") ?>
    </footer>
</body>

</html>
