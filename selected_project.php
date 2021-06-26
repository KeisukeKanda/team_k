<?php
require("db_set/db.php");
require("./funcs.php");
session_start();


//受け取り(GETで受けるかPOSTで受けるか未定だがとりあえず作成)
$user_id=$_SESSION["user_id"];//これはホストではなく申込者のID
$project_id=$_GET["project_id"];//index.phpから選択したプロジェクトをIDベースで引き継ぎ（セッションで記載しているがpostでもgetでもでもOK）



//飛ばす（セッションで飛ばすとこんな感じ。飛ばす内容は後ですり合わせ）
// $_SESSION["uuid"]=$uuid;



//index.phpで選択されたproject_idを元にprojectテーブルからデータを引っ張ってくる。
// usersテーブルと結合してユーザーネーム、を取得するのがよいかも（ややこしくなりそうなのであとで変更）


$sql="SELECT*FROM project WHERE project_id=:project_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue('project_id',$project_id,PDO::PARAM_INT);
$status = $stmt->execute();


//データの取得をエラーチェック。エラーが出ない場合は1行取得。
if($status==false){
sql_error($stmt);
}else{
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
}




// 予約可能日時が一覧で表示された方が良いかも（従来別ページを想定していた。以下phpを記載。reserve_flagは　0=「空き」、1=「予約が入った」、2=「サービス提供完了」）
$sql2="SELECT*FROM reservation WHERE project_id=:project_id AND reserve_flag=0";
$stmt2=$pdo->prepare($sql2);
$stmt2->bindValue(':project_id',$project_id,PDO::PARAM_INT);
$status2=$stmt2->execute();





// ここで予約可能日時一覧表示のためにデータを$viewに入れる。<a>タグを使ってreservation_idをGET送信する。
$view="";
if($status2==false){
  sql_error($stmt2);
}else{
    while( $res2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
    $view.='<form action="reserve_confirmation.php" method="post">
    <p>'.$res2["date"].'  '.$res2["reservation_time"].'時'.'</p><input type="hidden" name="reservation_id" value="'.$res2["reservation_id"].'">'
    .'<input type="submit" value="申込み">
    </form><br>';}
}


// お気に入りチェック
$sql3="SELECT*FROM favorites WHERE project_id=:project_id AND user_id=:user_id";
$stmt3=$pdo->prepare($sql3);
$stmt3->bindValue(':project_id',$project_id,PDO::PARAM_INT);
$stmt3->bindValue(':user_id',$user_id,PDO::PARAM_INT);
$status3=$stmt3->execute();

if($status3==false){
  sql_error($stmt3);
}else{
  $res3 = $stmt3->fetch(PDO::FETCH_ASSOC);
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<!-- プロジェクト詳細表示画面 -->
<h1><?=$res["title"]?></h1>
<img src='./project_img/<?=$res["project_img"];?>'>;
<p><?=$res["category"]?></p>
<p><?=$res["country"]?></p>
<p><?=$res["project_area"]?></p>
<p><?=$res["experience"]?></p>
<p><?=$res["thoughts"]?></p>
<p><?=$res["tour_time"]?></p>
<p><?=$res["price"]?></p>
<p><?=$res3 ?></p>

<!-- お気に入り登録 -->
        <form class="favorite_count" action="favo_add.php" method="post">
            <input type="hidden" name="project_id"
                value="<?= $res["project_id"] ?>">
            <input type="hidden" name="user_id"
                value="<?= $user_id ?>">
            <?php if ($res3 != NULL): ?>
            <p>【お気に入り登録済み】</p>
            <input type="submit" name="favo" class="favo-btn01" value="登録解除">
            <?php else: ?>
            <input type="submit" name="favo" class="favo-btn02" value="お気に入り登録">
            <?php endif; ?>
        </form>

          <a href="index.php">メインへ戻る</a>

<!-- 予約可能日時が一覧で表示された方が良いかも（従来別ページを想定していた） -->
<h1 class="">予約可能日時一覧</h1>
<p><?=$view;?></p>





<!-- 予約の確定フォーム reserve.phpに飛ばす -->
<!-- <form action="reserve.php" method="post">
<input type="hidden" name="project_id" value="<?=$res["project_id"]?>">
<input type="hidden" name="reservation_id" value="<?=$res2["reservation_id"]?>">
<input type="submit" value="予約する"> -->

</form>

<p></p>

</body>
</html>
