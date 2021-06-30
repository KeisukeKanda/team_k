<?php
// user_schedule.phpから飛んでくることを想定

require("./dbset/dbset.php");
require("./funcs.php");
session_start();

$user_id=$_SESSION["user_id"];
$project_id=$_GET["project_id"];



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/service_main.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<?php include("component/header.php") ?>


<div class="container">
    <h1 class="heading"></h1>
    <p hidden class="note">
        (before join in a room):
        <a hidden href="#">mesh</a> <a hidden href="#sfu">sfu</a>
    </p>
    <div class="room">
        <div class="gamen_all">
            <p class="gamen_title">通話画面（room名を共有してください）<input type="text" class="search1" placeholder="Room Name"
                    id="js-room-id"></p>
            <div class="gamen_pass">
                <div class="join_btn">
                    <button id="js-join-trigger" class="btn">Join</button>
                    <button id="leave_button" class="btn">Leave</button>
                </div>
                <div id="layer">

                </div>
                <div class="yoko">
                    <video id="js-local-stream" class="gamen zibun"></video>
                    <span hidden id="js-room-mode"></span>
                    <div class="remote-streams aite" id="js-remote-streams"></div>
                </div>

                <!-- ポップアップ -->
                <div id="popup">
                    <div>
                        <p class="btn1">通話を終了してもよろしいですか？</p>
                    </div>
                    <p class="btn1"><input type="button" id="js-leave-trigger" class="btn" value="はい"><br></p>
                    <p class="btn1"><input type="button" id="back_coll" class="btn" value="いいえ"></p>
                </div>
            </div>
        </div>



        <div>
            <pre class="messages" id="js-messages"></pre>
            <input hidden type="text" id="js-local-text">
            <button hidden id="js-send-trigger">Send</button>
        </div>
    </div>
    <p class="meta" id="js-meta" hidden></p>





    <!-- とりあえずreview.phpに遷移させる -->
    <p id="go_review">ご利用ありがとうございました。よろしければレビュー記入にご協力ください。<br>
        <button type="button" id="go_to_review" class="btn"
            value="<?= $project_id ?>">レビューにすすむ</button>
    </p>

    <!-- ここからスカイウェイのスクリプト -->
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-4.4.1.js"></script>
    <script src="./_shared/key.js"></script>
    <script src="./js/script.js"></script>


    <!-- ここからモーダルテスト -->
    <script>
        $(function() {
            $('#js-join-trigger').click(function(e) {
                $('#leave_button').show();
                $('#js-local-stream').removeClass('zibun');
                $('#js-local-stream').addClass('zibun2');
            });



            // show popupボタンクリック時の処理
            $('#leave_button').click(function(e) {
                $('#popup, #layer').show();
            });

            // レイヤー/ポップアップのcloseボタンクリック時の処理
            $('#js-leave-trigger, #layer').click(function(e) {
                $('#popup, #layer').hide();
                $('#js-local-stream').hide();
                $('.gamen_all').hide();
                $('.messages').hide();
                $('#go_review').show();
            });
            $('#back_coll').click(function(e) {
                $('#popup, #layer').hide();
            });

            $('#go_to_review').click(function(e) {
                const project_selected = $('#go_to_review').val();
                window.location.href = `review.php?project_id=${project_selected}`;
            });



        });
    </script>
</div>



</body>

</html>

<body>
