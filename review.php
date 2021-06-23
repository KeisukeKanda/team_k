<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>レビュー画面</title>
</head>

<body>
  <h1>体験のレビューを書く</h1>
  <form action="review_insert.php" method="post">
    <dl class="evaluation">
      <dt>内容の満足度</dt>
      <dd>
        <select name="contents_review" class="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </dd>
      <dt>ホスピタリティの満足度</dt>
      <dd>
        <select name="hospitality_review" class="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </dd>
      <dt>コミュニケーションの満足度</dt>
      <dd>
        <select name="communication" class="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </dd>
      <dt>旅の長さの満足度</dt>
      <dd>
        <select name="time_review" class="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </dd>
      <dt>価格の満足度</dt>
      <dd>
        <select name="price_review" class="star">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </dd>
      <dt>コメント</dt>
      <dd>
        <input type="text" name="comment_review">
      </dd>
    </dl>
    <div><input type="submit" value="登録する"></div>
  </form>
</body>

</html>
