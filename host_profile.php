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
            $view .= '<div class="p_card">';
	        $view .= '<div class="img_card">';
	        $view .= '<img src="project_img/'.$result["project_img"].'" alt="" width="200" /></div>';
			$view .= '<div class="txt_card">';
			$view .= '<div class="txt_title_card1">';
			$view .= 'Project:'.$result["project_id"].'  '.$result["title"].' Category: '.$result["category"].'</div>';
			$view .= '<div class="txt_country_card1">'.$result["country"].'  '.$result["project_area"].'</div>';
			$view .= '<div class="txt_expe_card1">'.$result["experience"].'</div>';
			$view .= '<div class="txt_thoughts_card1">'.$result["thoughts"].'</div>';
			$view .= '<div class="txt_time_price_card1">Tour time: '.$result["tour_time"].'　　　Price:'.$result["price"].'</div>';
			$view .= '</div></div><br>';}
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
    <link rel="stylesheet" href="./css/project.css">
    <link rel="stylesheet" href="./css/host.css">
    <title>ISEKAI</title>
</head>

<body>
        <!-- ヘッダー -->
        <?php include("component/header.php") ?>

    <div class="host_profile_wrap">
        <!-- ヘッダー終わり -->
            <h2><?= $val["nickname"] ?>の自己紹介</h2>

            <!-- プロフィール表示 -->
            <div class="p_card no_border">
                <div class="img_card">
                    <img src="user_img/<?= $val["user_img"] ?>" width="400"
                        alt="HOSTプロフィール画像">
                </div>
                <div class="txt_card">
                    <div class="txt_title_card">
                        <?= $val["nickname"] ?>
                    </div>
                    <div class="txt_title_card">
                        <?= $val["country"] ?><?= $val["user_area"] ?>
                    </div>
                    <div class="txt_title_card">
                        <?= $val["introduction"] ?>
                    </div>
                </div>
            </div>
            <!-- Project表示 -->
            <h2><?= $val["nickname"] ?>が用意したProject</h2><br>
            <p><?php echo $view;?></p>
    </div>

    <?php include("component/footer.php") ?>

</body>

</html>
