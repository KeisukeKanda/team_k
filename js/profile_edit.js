// 画像アップロードをプレビューする機能
$(".image-input").on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(".preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});