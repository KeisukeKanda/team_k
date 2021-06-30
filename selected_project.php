<?php
require("./dbset/dbset.php");
require("./funcs.php");
session_start();


//受け取り(GETで受けるかPOSTで受けるか未定だがとりあえず作成)
$user_id = $_SESSION["user_id"]; //これはホストではなく申込者のID
$project_id = $_GET["project_id"]; //index.phpから選択したプロジェクトをIDベースで引き継ぎ（セッションで記載しているがpostでもgetでもでもOK）



//飛ばす（セッションで飛ばすとこんな感じ。飛ばす内容は後ですり合わせ）
// $_SESSION["uuid"]=$uuid;



//index.phpで選択されたproject_idを元にprojectテーブルからデータを引っ張ってくる。
// usersテーブルと結合してユーザーネーム、を取得するのがよいかも（ややこしくなりそうなのであとで変更）


$sql = "SELECT*FROM project AS p INNER JOIN users as u ON p.user_id=u.user_id WHERE project_id=:project_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue('project_id', $project_id, PDO::PARAM_INT);
$status = $stmt->execute();


//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if ($status == false) {
    sql_error($stmt);
} else {
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
}

if($user_id==0){
$zyoken='./auth/please_login.php';
}elseif($user_id==$res["user_id"]){
$zyoken='cannot_reserve.php';
}else{
$zyoken='reserve_confirmation.php';  
}



// 予約可能日時が一覧で表示された方が良いかも（従来別ページを想定していた。以下phpを記載。reserve_flagは　0=「空き」、1=「予約が入った」、2=「サービス提供完了」）
$sql2 = "SELECT*FROM reservation WHERE project_id=:project_id AND reserve_flag=0";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$status2 = $stmt2->execute();





// ここで予約可能日時一覧表示のためにデータを$viewに入れる。<a>タグを使ってreservation_idをGET送信する。
$view = "";
if ($status2 == false) {
    sql_error($stmt2);
} else {
    while ($res2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<form action="'.$zyoken.'" method="post">';
        $view .= '<div class="reservation_time">';
        $view .= '<div class="reservation_date">' . $res2["date"] . '  ' . $res2["reservation_time"] . "時" . '</div>';
        $view .= '<div class="reservation_button"><input type="hidden" name="reservation_id" value="' . $res2["reservation_id"] . '">';
        $view .= '<input type="submit" value="申込み" id="check" class="go"></div>';
        $view .= '</div>';
        $view .= '</form><br>';
    }
}


// お気に入りチェック
$sql3 = "SELECT*FROM favorites WHERE project_id=:project_id AND user_id=:user_id";
$stmt3 = $pdo->prepare($sql3);
$stmt3->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt3->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status3 = $stmt3->execute();

if ($status3 == false) {
    sql_error($stmt3);
} else {
    $res3 = $stmt3->fetch(PDO::FETCH_ASSOC);
}






//プロジェクトナンバー1のコンテンツレビューの平均値を取得→表示
$stmt5 = $pdo->prepare("SELECT AVG (contents_review) FROM review WHERE project_id=:project_id");
$stmt5->bindValue(":project_id", $project_id, PDO::PARAM_INT);
$status5 = $stmt5->execute();
if ($status5 == false) {
    sql_error($stmt5);
} else {
    while ($result5 = $stmt5->fetch(PDO::FETCH_BOTH)) {
        $contents_review=$result5[0];
    }
}


//プロジェクトナンバー1のホスピタリティレビューの平均値を取得→表示
$stmt5 = $pdo->prepare("SELECT AVG (hospitality_review) FROM review WHERE project_id=:project_id");
$stmt5->bindValue(":project_id", $project_id, PDO::PARAM_INT);
$status5 = $stmt5->execute();

if ($status5 == false) {
    sql_error($stmt5);
} else {
    while ($result5 = $stmt5->fetch(PDO::FETCH_BOTH)) {
        $hospitality_review=$result5[0];
    }
}


//プロジェクトナンバー1のコミュニケーションレビューの平均値を取得→表示
$stmt5 = $pdo->prepare("SELECT AVG (communication_review) FROM review WHERE project_id=:project_id");
$stmt5->bindValue(":project_id", $project_id, PDO::PARAM_INT);
$status5 = $stmt5->execute();

if ($status5 == false) {
    sql_error($stmt5);
} else {
    while ($result5 = $stmt5->fetch(PDO::FETCH_BOTH)) {
        $communication_review=$result5[0];
    }
}


//プロジェクトナンバー1のプライスレビューの平均値を取得→表示
$stmt5 = $pdo->prepare("SELECT AVG (price_review) FROM review WHERE project_id=:project_id");
$stmt5->bindValue(":project_id", $project_id, PDO::PARAM_INT);
$status5 = $stmt5->execute();

if ($status5 == false) {
    sql_error($stmt5);
} else {
    while ($result5 = $stmt5->fetch(PDO::FETCH_BOTH)) {
        $price_review=$result5[0];
    }
}


$total_review=($price_review + $communication_review + $hospitality_review +$contents_review)/4;








?>




<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ISEKAI</title>
  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="./css/all.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/reservation.css">
  <link rel="stylesheet" href="./css/footer.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="./raty-3.0.0/lib/jquery.raty.js"></script>

</head>

<body>
  <header>
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>
  </header>
  <main>
    <div class="contents">
      <!-- プロジェクト詳細表示画面 -->
      <h1><?= $res["title"] ?>
      </h1>
      <div class="user_reservation">
        <div class="reservation_image"><img
            src='./project_img/<?= $res["project_img"]; ?>'
            class="reservation_img"></div>
        <div class="project_contents">○ カテゴリー: <?= $res["category"] ?>
        </div>
        <div class="project_contents">○ 案内の場所: <?= $res["country"] ?> <?= $res["project_area"] ?>
        </div>
        <!-- <p>Area:<?= $res["project_area"] ?>
        </p> -->
        <div class="project_contents">○ 内容: </div>
        <div class="project_contents"><?= $res["experience"] ?>
        </div>
        <div class="project_contents">○ ホストの思い: </div>
        <div class="project_contents"><?= $res["thoughts"] ?>
        </div>
        <div class="project_contents">○ ツアー時間: <?= $res["tour_time"] ?>時間</div>
        <div class="project_contents">○ 価格: <?= $res["price"] ?>円</div>
        <div class="project_contents">○ ホスト: <a
            href="./host_profile.php?user_id=<?= $res['user_id'] ?>"><?= $res["nickname"] ?></a></div>
        <div class="project_contents">○ レビュー<div id="review_show"></div>
        </div>
        <!-- <p><?= $res3 ?>
        </p> -->



        <script type="text/javascript">
          $('#review_show').raty({
            readOnly: true,
            score: <?=$total_review?>
          });
        </script>



        <!-- お気に入り登録 -->
        <form class="favorite_count" action="favo_add.php" method="post">
          <input type="hidden" name="project_id"
            value="<?= $res["project_id"] ?>">
          <input type="hidden" name="user_id"
            value="<?= $user_id ?>">
          <?php if ($res3 != null) : ?>
          <div class="favo_register">
            <div class="register_done">【お気に入り登録済み】</div>
            <div class="favo-btn">
              <input type="submit" name="favo" class="btn favo-btn01" value="登録解除">
            </div>
            <?php else : ?>
            <div class="favo-register-btn">
              <input type="submit" name="favo" class="btn favo-btn02" value="お気に入り登録">
            </div>
            <?php endif; ?>
          </div>
        </form>

        <!-- <a href="index.php">メインへ戻る</a> -->

        <!-- 予約可能日時が一覧で表示された方が良いかも（従来別ページを想定していた） -->
        <div class="reservation-possible">
          <h1>予約可能日時一覧</h1>
          <div>
            <?php if ($view ==""): ?>
            <div class="reservation-empty-text">今予約できる日程はありません・・・</div>
            <?php else: ?>
            <?= $view; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php include("component/footer.php") ?>
    </div>
  </main>
<script>
  $("#check").on('click',function(){
      <?php if($res["user_id"]==$user_id):?>
      link(){href='cannot_reserve.php';}
  )}
  <?php endif; ?>
</script>

</body>

</html>