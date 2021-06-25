<?php
// user_schedule.phpから飛んでくることを想定

require("db_set/db.php");
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
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../_shared/style.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    
</head>




<div class="container">
            <h1 class="heading"></h1>
            <p hidden class="note">
                (before join in a room):
                <a hidden href="#">mesh</a>  <a hidden href="#sfu">sfu</a>
            </p>
            <div class="room">
                <div class="gamen_all">
                    <p class="gamen_title">通話画面<br>（room名を共有してください）</p>
                        <video id="js-local-stream" class="gamen"></video>
                        <span hidden id="js-room-mode"></span>
                        <div class="gamen_pass">
                            <input type="text" placeholder="Room Name" id="js-room-id">
                            <button id="js-join-trigger">Join</button>
                            <button  id="js-leave-trigger">Leave</button>
                        </div>
                </div>

                <div class="remote-streams" id="js-remote-streams"></div>

                <div>
                    <pre class="messages" id="js-messages"></pre>
                    <input hidden type="text" id="js-local-text">
                    <button hidden id="js-send-trigger">Send</button>
                </div>
            </div>
            <p class="meta" id="js-meta" hidden></p>





<!-- とりあえずreview.phpに遷移させる -->
            <p> <a href="review.php">レビュー画面に進む</a></p>

    <!-- ここからスカイウェイのスクリプト -->
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-4.4.1.js"></script>
    <script src="./_shared/key.js"></script>
    <script src="./js/script.js"></script>
</div>



</body>
</html>

<body>