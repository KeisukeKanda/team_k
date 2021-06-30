<?php
require("./dbset/dbset.php");
require("./funcs.php");
session_start();

// POSTで取ることを想定
$reservation_id = $_POST["reservation_id"];
$user_id = $_SESSION["user_id"];
// $reservation_id = 3;
// $user_id = 2;

// reservationテーブルから呼び出す予約日時を呼び出して表示
$sql = "SELECT*FROM reservation AS r INNER JOIN project AS p
ON r.project_id=p.project_id WHERE reservation_id=$reservation_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if ($status == false) {
    sql_error($stmt);
} else {
    $res1 = $stmt->fetch(PDO::FETCH_ASSOC);
}

$host_id=$res1["user_id"];

// userテーブルからuser情報を呼び出す
$sql = "SELECT*FROM users WHERE user_id=$user_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if ($status == false) {
    sql_error($stmt);
} else {
    $res2 = $stmt->fetch(PDO::FETCH_ASSOC);
}

// userテーブルからhost情報を呼び出す
$sql = "SELECT*FROM users WHERE user_id=$host_id";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if ($status == false) {
    sql_error($stmt);
} else {
    $res3 = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/all.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/mail_input.css">
  <title>ISEKAI</title>
</head>

<body>
  <div>
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>

    <div class="mail-form">
      <div class="box">

        <!-- <body onload="setTimeout( 'auto_send()', 1 )"> -->
        <body onload="auto_send()">
        <form name="auto" action="mail1.php" method="post">
          <!-- 予約者へ送信 -->
          <input type="hidden" class="mail-inputform" name="to1" value="kmorningjp@yahoo.co.jp">
          <input type="hidden" class="mail-inputform" name="title1" value="Project <?=$res1["title"]?>のご予約">
          <div style="display:none">
          <textarea type="hidden" name="content1">

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-

          ISEKAI
          知らない場所には知らない人がいる

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-


          <?=$res2["name"]  ?>さん、

          Project<?=$res1["title"]?> on <?=$res1["date"]?> at <?=$res1["reservation_time"]?>のご予約ありがとうございました。
          当日は以下のリンクにご参加ください。

          http://localhost/team_k/host_index.php

          質問あれば、HOSTのemailにご連絡ください。
          <?=$res3["email"]  ?>

          では、当日のツアーをお楽しんでくだい。

          ------------------------------------------------------------------------------------

          ISEKAI事務局 電話:011-333-1111 問合せメール:info@isekai.com
          ※このメールは送信専用のため、このメールへ直接返信はできません。

          ------------------------------------------------------------------------------------

          </textarea></div>

          <!-- HOSTへ送信 -->
          <input type="hidden" name="to2" value="kmorningjp@yahoo.co.jp">
          <input type="hidden" name="title2" value="Project <?=$res1["title"]?>は予約されました">
          <div style="display:none">
          <textarea type="hidden" name="content2">

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-

          ISEKAI
          知らない場所には知らない人がいる

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-



          <?=$res3["name"]  ?>さん、

          Project<?=$res1["title"]?> on <?=$res1["date"]?> at <?=$res1["reservation_time"]?>は予約されました。
          以下のリンクでご確認ください。

          http://localhost/team_k/host_index.php

          ツアーの参加し方は、事前に<?=$res2["name"]  ?>さんにご連絡ください。
          <?=$res2["email"]  ?>

          では、当日のツアーをお楽しんでくだい。

          ------------------------------------------------------------------------------------

          ISEKAI事務局 電話:011-333-1111 問合せメール:info@isekai.com
          ※このメールは送信専用のため、このメールへ直接返信はできません。

          ------------------------------------------------------------------------------------

          </textarea></div>

          <div style="display:none;"><input type="submit" name="send"></div>
        </form>

      </div>
    </div>
  </div>

  <!-- フッターを呼び出し -->
  <?php include("component/footer.php") ?>

  <script language="JavaScript">
    function auto_send(){
    document.auto.submit();
    }

  </script>

</body>

</html>
