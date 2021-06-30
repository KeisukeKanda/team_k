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
    <div>
      <!-- componentフォルダからヘッダーを読み込み -->
      <?php include("component/header.php") ?>

      <div class="message">

      <h2 class="thx_comment">支払は成功しました</h2>
      <h2 class="thx_comment">ご予約ありがとうございました</h2>
      <h2 class="thx_comment">予約の詳細は登録したメールにご確認ください</h2>
      <h1></h1>

        <?php
      mb_language("Japanese");
      mb_internal_encoding("UTF-8");

      $to1 = $_POST['to1'];
      $title1 = $_POST['title1'];
      $message1 = $_POST['content1'];
      $to2 = $_POST['to2'];
      $title2 = $_POST['title2'];
      $message2 = $_POST['content2'];
      $headers = "From: info@isekai.com";

      if (mb_send_mail($to1, $title1, $message1, headers) AND mb_send_mail($to2, $title2, $message2, headers)) {
          echo "メール送信成功です";
      } else {
          echo "メール送信失敗です";
      }
      ?>
      </div>

      <!-- <div class="backhome">
        <a href="host_index.php">ホスト管理画面へ戻る</a>
      </div> -->

    </div>

    <!-- フッターを呼び出し -->
    <?php include("component/footer.php") ?>
  </body>

  </html>
