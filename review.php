<?php
//必ずsession_startは最初に記述
session_start();

//DB接続します
require("funcs.php");
require("./dbset/dbset.php");

//ユーザー名を取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];
$project_id = $_GET["project_id"];

//２．データ抽出SQL作成
$sql = "SELECT * FROM reservation AS r INNER JOIN project AS p ON r.project_id = p.project_id  WHERE r.user_id=:user_id AND reserve_flag=1 ORDER BY date ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    // $project_id = $res["project_id"];
    //Selectデータの数だけ自動でループしてくれる
    while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // $view .= '<div class=reservation_box>';
        $view .= '<div class="user_reservation">';
        $view .= '<div class="user_reservation_list">';
        $view .= '<div class="reservation_img"><img src="project_img/' . $res["project_img"] . '" alt="" width="200"></div>';
        $view .= '<div class="reservation_contents">';
        $view .= '<div class="project_title"><i class="fas fa-globe"></i> ' . $res["title"] . '</div>';
        $view .= '<div class="project_contents"><i class="fas fa-table"></i> ' . $res["date"] . " " . $res["reservation_time"] . '</div>';
        // $view .= '<p>' . $res["category"] . '</p>';
        $view .= '<div class="project_contents"><i class="fas fa-search-location"></i> ' . $res["country"] . " " . $res["project_area"] . '</div>';
        // $view .= '<p>' . $res["project_area"] . '</p>';
        // $view .= '<p>' . $res["experience"] . '</p>';
        // $view .= '<p>' . $res["thoughts"] . '</p>';
        // $view .= '<p>' ."ツアー時間:". $res["tour_time"] . "時間".'</p>';
        // $view .= '<p>' ."料金". $res["price"] . "円".'</p>';
        $view .= '</div>';
        $view .= '</div>';
        $view .= '<div class="project_button">';
        $view .= '<a href="user_schedule_cancel.php?reservation_id=' . $res["reservation_id"] . '" class="cancel">× 予約キャンセル</a>';
        $view .= '<a href="user_schedule_detail.php?reservation_id=' . $res["reservation_id"] . '" class="btn detail">詳細</a>';
        $view .= '</div>';
        $view .= '</div>';
    }
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
  <link rel="stylesheet" href="./css/review.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/project.css">
  <title>ISEKAI</title>
</head>

<body>
  <div>
    <!-- componentフォルダからヘッダーを読み込み -->
    <?php include("component/header.php") ?>
      <h1>体験のレビューを書いてみましょう！</h1>
      <p>ご利用ありがとうございます！あなたのレビューがサービスを支えています。
        <br>
        <br>
        本日の体験の感想をぜひ教えてください！
      </p>
    <div class="box1">

      <form action="review_insert.php" method="post">
        <dl class="evaluation">
          <dt class="title">内容の満足度</dt>
          <dd>
            <select name="contents_review" class="star">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </dd>
          <dt class="title">ホスピタリティの満足度</dt>
          <dd>
            <select name="hospitality_review" class="star">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </dd>
          <dt class="title">コミュニケーションの満足度</dt>
          <dd>
            <select name="communication_review" class="star">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </dd>
          <dt class="title">旅の長さの満足度</dt>
          <dd>
            <select name="time_review" class="star">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </dd>
          <dt class="title">価格の満足度</dt>
          <dd>
            <select name="price_review" class="star">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected>3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </dd>
          <dt class="title">コメント</dt>
          <dd>
            <textarea type="text" name="comment_review" class="comment"></textarea>
          </dd>
          <dd>
            <input type="hidden" name="user_id"
              value="<?= $user_id ?>">
          </dd>
          <dd>
            <input type="hidden" name="project_id"
              value="<?= $project_id ?>">
          </dd>
        </dl>
        <div><input type="submit" class="btn make-project" value="登録する" style="height:50px;"></div>
      </form>
    </div>

  </div>
  <!-- フッターを呼び出し -->
</body>

  <?php include("component/footer.php") ?>

</html>
