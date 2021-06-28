<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
        <meta name="description" content="">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="index.css">
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </head>
    <body>
            <div class="contents">
                <div class="calendar">
                    <input type="text" id="search5" name="datepicker" style="display:none" class="datepicker" value="">
                    <div class="calendar__modal"></div>
                    <button id="send">検索</button>
                </div>
            </div>
        <div class="container jumbotron" id="view"><?php echo $view; ?></div>


        <script type="text/javascript" src="./js/index.js"></script>
        <script>
            $(function() {
            $('.datepicker').datepicker({
                buttonImage: "./user_img/calendar.jpeg",  // カレンダーアイコン画像
                buttonText: "",  // アイコンホバー時の表示文言
                buttonImageOnly: true, // ボタンとして表示
                showOn: "both",  // アイコン、テキストボックスどちらをクリックでもカレンダー表示
                beforeShow: function(input, inst){
                inst.dpDiv.css({top: 50 + '%', left: 50 + '%'});
                }
            });
            });
        </script>

<script>
$("#send").on("click", function() {
            //Ajax（非同期通信）
            //1．パラメータの変更
            //2. 送信先
            //3. DOM操作
            const params = new URLSearchParams();
            params.append('search5', $("#search5").val());

            //axiosでAjax送信
            axios.post('calendar_test2.php', params).then(function(response) {
                console.log(response.data); //通信OK
                $("#view").html(response.data);
            }).catch(function(error) {
                console.log(error); //通信Error
            }).then(function() {
                console.log("Last"); //通信OK/Error後に処理を必ずさせたい場合
            });
        });


</script>



    </body>
</html>