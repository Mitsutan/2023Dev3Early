<header>
    <div class="container-fluid bg-dark p-1 text-warning fs-2">
        <img src="./img/icon.png" alt="筋肉Memorial" width="50">
        <span class="fw-bold">筋肉</span><span class="logo">Memorial</span>
    </div>
    <nav>
        <div class="container-fluid bg-warning">
            <ul class="py-2" id="nav_ul">
                <li><a href="./index.php"><i class="fa-solid fa-house"></i><span class="d-none d-md-inline">HOME</span></a></li>
                <li><a href="./ranking.php"><i class="fa-solid fa-ranking-star"></i><span class="d-none d-md-inline">ランキング</span></a></li>
                <li><a href="./hashtags.php"><i class="fa-solid fa-hashtag"></i><span class="d-none d-md-inline">ハッシュタグ</span></a></li>
                <?php
                // if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="./goods.php"><i class="fa-solid fa-thumbs-up"></i><span class="d-none d-md-inline">いいね</span></a></li>';
                // }
                ?>
                <li><a href="./search.php"><i class="fa-solid fa-magnifying-glass"></i><span class="d-none d-md-inline">検索</span></a></li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li><a href="./mypage.php"><i class="fa-solid fa-user"></i><span class="d-none d-md-inline">マイページ</span></a></li>';
                } else {
                    echo '<li><a href="./login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i><span class="d-none d-md-inline">ログイン</span></a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</header>