<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

//IndexのProject一覧からhost idを取得
$user_id = filter_input( INPUT_GET, "user_id" );
// $user_id = 1;

//usersテーブルと国と地域のテーブルを接続
// 国コードと地域コードから国名・地域名をプロフィールに表示させるため
$sql = "SELECT * FROM users AS u
INNER JOIN country AS c ON u.country=c.country_id
INNER JOIN japan AS j ON u.user_area=j.japan_id
WHERE user_id=:user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

// usersテーブルのみを取得

// ※※
// 上記usersと国・地域コードをINNER JOINしたデータ記述だと、
// 国コード・地域コード入力前の状態では正しく表示されないためこちらのデータ取得を行う
// ※※
$sql = "SELECT * FROM users WHERE user_id=:user_id";
$res = $pdo->prepare($sql);
$res->bindValue(':user_id', $user_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$state = $res->execute();
$val = $res->fetch();

//******************************************* */
//               Project一覧表示
//******************************************* */

	$sql2="SELECT*FROM project WHERE user_id=$user_id";
	$stmt2=$pdo->prepare($sql2);
	$status2=$stmt2->execute();
	$view="";
    // $result = $stmt->fetch(PDO::FETCH_ASSOC)
    // echo "result:".$result;

	if($status2==false){
		sql_error($stmt2);
	}else{
			while( $result = $stmt2->fetch(PDO::FETCH_ASSOC)){
			$view.='<img src="project_img/'.$result["project_img"].'" alt="" />'.
			'<div> Project:'.$result["project_id"].' Title: '.$result["title"].' Category: '.$result["category"].'  '.
			'Country:'.$result["country"].' Area: '.$result["project_area"].'  '.
			'Experience:'.$result["experience"].' Thought: '.$result["thoughts"].' Tour time: '.$result["tour_time"].'  '.
			'Price:'.$result["price"].'  '.
			'</div><br>';}
	}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/reset.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">
        <!-- ヘッダー -->
        <div class="header">
            <div class="header-box">
                <div class="logo">Team K</div>
                <div class="nav-box">
                    <ul>
                        <li><a href="index.php">メインへ戻る</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- ヘッダー終わり -->

        <div class="main">
            <div class="box">

                <!-- プロフィール表示 -->
                <div>プロフィール画像</div>
                <div class="user_img">
                    <img src="<?= $val["user_img"] ?>"
                        alt="HOSTプロフィール画像">
                </div>
                <div>ニックネーム</div>
                <div class="nickname">
                    <?= $val["nickname"] ?>
                </div>
                <?php foreach ($stmt as $profile): ?>
                <div>住んでいる国</div>
                <div class="country">
                    <?= $profile["country"] ?>
                </div>
                <div>住んでいるエリア</div>
                <div class="user_area">
                    <?= $profile["japan_area"] ?>
                </div>
                <?php endforeach; ?>
                <div>自己紹介</div>
                <div class="introduction">
                    <?= $val["introduction"] ?>
                </div>
                <!-- プロフィール表示終わり -->

            </div>

            <div>
                <br>
                <h4>【<?= $val["nickname"] ?>が用意したProject一覧】</h4><br>
                <p><?php echo $view;?></p>
            </div>
        </div>
    </div>



    <style>
        .user_img {
            width: 30%;
        }

        .user_img img {
            width: 100%;
        }
    </style>

</body>

</html>
