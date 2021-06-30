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

        <!-- <body onload="setTimeout( 'auto_send()', 1 )"> -->
        <body onload="auto_send()">
        <form name="auto" action="mail1.php" method="post">
          <!-- 予約者へ送信 -->
          <input type="hidden" class="mail-inputform" name="to1" value="kmorningjp@yahoo.co.jp">
          <input type="hidden" class="mail-inputform" name="title1" value="Project？のご予約">
          <div style="display:none">
          <textarea type="hidden" name="content1">

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-

          ISEKAI
          知らない場所には知らない人がいる

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-



          USERさん、

          Project？のご予約ありがとうございました。
          当日は以下のリンクにご参加ください。

          http://localhost/team_k/host_index.php

          ------------------------------------------------------------------------------------

          ISEKAI事務局 電話:011-333-1111 問合せメール:info@isekai.com
          ※このメールは送信専用のため、このメールへ直接返信はできません。

          ------------------------------------------------------------------------------------

          </textarea></div>

          <!-- HOSTへ送信 -->
          <input type="hidden" name="to2" value="kmorningjp@yahoo.co.jp">
          <input type="hidden" name="title2" value="Project ？予約されました">
          <div style="display:none">
          <textarea type="hidden" name="content2">

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-

          ISEKAI
          知らない場所には知らない人がいる

          -!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-!-



          HOSTさん、

          Project？は予約されました。
          以下のリンクでご確認ください。

          http://localhost/team_k/host_index.php

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
