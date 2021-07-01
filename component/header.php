<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

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
                <li class="menu-list"><a href="profile.php"><i class="bi bi-person"></i>マイプロフィール</a></li>
                <li class="menu-list"><a href="user_schedule.php"><i class="bi bi-calendar-check"></i>予約一覧</a></li>
                <li class="menu-list"><a href="favorites.php"><i class="bi bi-heart"></i>お気に入り一覧</a></li>


                <li class="menu-list"><a href="host_index.php"><i class="bi bi-list-ul"></i>ホスト管理画面</a></li>

                <li class="menu-list"><a href="auth/logout.php">ログアウト</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- ヘッダー終わり -->
</div>