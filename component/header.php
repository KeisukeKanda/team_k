<div class="header">
    <!-- ヘッダー -->
    <div class="header-box">
        <div class="logo">
            <a href="index.php">
                <img src="./background_img/isekai_logo.png" alt="サービスロゴイメージ">
            </a>
        </div>
        <div class="nav-box">
            <ul class="menu">
                <?php if ($user_id == 0): ?>
                <li class="menu-list"><a href="auth/signup.php">サインアップ</a></li>
                <li class="menu-list"><a href="auth/login.php">ログイン</a></li>
                <?php else: ?>
                <!-- <li class="menu-list">
                            こんにちは、<?= $username ?>
                </li> -->
                <li class="menu-list"><a href="profile.php">マイプロフィール</a></li>
                <li class="menu-list"><a href="user_schedule.php">予約一覧</a></li>
                <li class="menu-list"><a href="favorites.php">お気に入り一覧</a></li>

                <!-- ログインユーザーがすでにhost登録済みの場合のみ表示 -->
                <?php if ($val["host"] == 1): ?>
                <li class="menu-list"><a href="host_index.php">ホスト管理画面</a></li>
                <?php endif; ?>

                <li class="menu-list"><a href="auth/logout.php">ログアウト</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- ヘッダー終わり -->
</div>