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
  <div class="warp">
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>

    <div class="mail-form">
      <div class="box">

        <h1 class="mail-title">メール送信フォーム</h1>
        <form action="mail.php" method="post">
          <div class="form-title">送り先</div>
          <input type="text" class="mail-inputform" name="to">
          <div class="form-title">件名</div>
          <input type="text" class="mail-inputform" name="title">
          <div class="form-title">メッセージ</div>
          <textarea name="content" cols="60" rows="10"></textarea>
          <div><input type="submit" class="mail-submit-btn" name="send" value="送信"></div>
        </form>

      </div>
    </div>
  </div>

  <!-- フッターを呼び出し -->
  <?php include("component/footer.php") ?>
</body>

</html>