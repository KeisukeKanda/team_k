<?php

session_start();

require("./db_set/db.php");
require("funcs.php");

// ログインしてるユーザー名とIDを取得
$username = $_SESSION["name"];
$user_id = $_SESSION["user_id"];
echo $user_id;

//******************************************* */
//               お気に入り表示
//******************************************* */

	$sql="SELECT*FROM favorites AS f INNER JOIN project AS p ON f.project_id = p.project_id
	WHERE f.user_id=$user_id";

	$stmt=$pdo->prepare($sql);
	$status=$stmt->execute();
	$view="";
	if($status==false){
		sql_error($stmt);
	}else{
			while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$view.='<a href="./selected_project.php?user_id='.$user_id.'&project_id='.$result['project_id'].'">'.
            '<img src="project_img/'.$result["project_img"].'" alt="" />'.
			'<div> Project:'.$result["project_id"].' Title: '.$result["title"].' Category: '.$result["category"].'  '.
			'Country:'.$result["country"].' Area: '.$result["project_area"].'  '.
			'</div><br>';}
	}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <title>Document</title>
</head>

<body>
    <div class="wrap">

        <!-- お気に入り一覧を表示 -->
    <div>
        <h4>お気に入り一覧</h4>
        <p><?php echo $view;?></p>
    </div>
        <!-- プラン一覧を表示終わり -->

    </div>

    <style>
        .content-img {
            width: 30%;
        }

        .content-img img {
            width: 100%;
        }
    </style>

</body>

</html>
