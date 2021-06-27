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
    <link rel="stylesheet" href="./css/mail.css">
    <title>ISEKAI</title>
  </head>

  <body>
    <div class="warp">
      <!-- componentフォルダからヘッダーを読み込み -->
      <?php include("component/header.php") ?>

      <div class="message">
        <?php
      mb_language("Japanese");
      mb_internal_encoding("UTF-8");

      $to = $_POST['to'];
      $title = $_POST['title'];
      $message = $_POST['content'];
      $headers = "From: team_k@team_k.com";

      if (mb_send_mail($to, $title, $message, headers)) {
          echo "メール送信成功です";
      } else {
          echo "メール送信失敗です";
      }
      ?>
      </div>

      <div class="backhome">
        <a href="host_index.php">ホスト管理画面へ戻る</a>
      </div>

    </div>

    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>
  </body>

  </html>