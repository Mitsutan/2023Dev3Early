<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager;

$userId = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="./css/style.css">

    <title>筋肉Memorial -検索-</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">

    <div class = "from-group">
        <p class="control-label"><b>対象</b></p>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault1">
            <label class="form-check-label" for="Radio1">タグ</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">記事名</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">ユーザー名</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">フォローのみ</label>
        </div>
    </div>

    <div class="input-group">
        <input type="text" class="form-control" placeholder="キーワードを入力">
        <button class="btn2 btn-outline-success" type="button" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
    </div>

        <h1>検索結果</h1>

    <div class="row">
        <div class="col-6">
            <span>並び替え：</span>
            <select name=”item”>
                <option value=”item1”>人気順　　　　</option>
                <option value=”item2”>新着順　　　　</option>
                <option value=”item3”>過去１週間の人気順</option>
            </select>
        </div>
        <div class="col-6">
            <p>XXX件中～X件表示</p>
        </div>
    </div>
    
    <div class="row g-5 mx-0">

            <div class="col-md-6 col-12">
                <div class="row border-start border-end border-dark border-1 p-2">
                    <div class="col-7">
                        <h3>記事の見出し</h3>
                        <div class="d-flex justify-content-between">
                            <p>2023/xx/xx</p>
                            <p><i class="fa-solid fa-thumbs-up me-1"></i>1234</p>
                        </div>
                        <div>
                            <div style="display:inline-block;">#ダイエット</div>
                            <div style="display:inline-block;">#筋トレ</div>
                            <div style="display:inline-block;">#胸</div>
                        </div>
                        <div class="row align-items-end" style="min-height: 10vmax;">
                            <div class="col-4">
                                <img src="<?php
                                            // $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
                                            // if ($userpic) {
                                            //     echo $userpic[0];
                                            // } else {
                                                echo "./img/user_default.png";
                                            // }
                                            ?>" class="rounded-circle ratio ratio-1x1">
                            </div>
                            <div class="col-8">
                                <div>
                                    <div>ユーザー名</div>
                                    <div id="followButtonContainer">
                                        <?php
                                        // DBManagerクラスをインスタンス化
                                        $dbManager = new DBManager();
                                        $followingUserId = 1;
                                        // フォロー状態の判定と表示
                                        $isFollowing = $dbManager->isFollowingUser($userId, $followingUserId);
                                        if ($isFollowing) {
                                            echo '<button onclick="unfollowUser()">フォロー解除する</button>';
                                        } else {
                                            echo '<button onclick="followUser()">フォローする</button>';
                                        }
                                        ?>
                                    </div>

                                    <script>
                                        // フォローボタンをクリックした時の処理
                                        function followUser() {
                                            var followingUserId = "1";

                                            var xhr = new XMLHttpRequest();
                                            xhr.open("POST", "./php/follow.php");
                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
                                                    // ボタンの表示を切り替える
                                                    document.getElementById("followButtonContainer").innerHTML = '<button onclick="unfollowUser()">フォロー解除する</button>';
                                                } else {
                                                    alert("フォローに失敗しました");
                                                }
                                            };
                                            xhr.send("followingUserId=" + encodeURIComponent(followingUserId));
                                        }

                                        // アンフォローボタンをクリックした時の処理
                                        function unfollowUser() {
                                            var unfollowingUserId = "1";

                                            var xhr = new XMLHttpRequest();
                                            xhr.open("POST", "./php/unfollow.php");
                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                            xhr.onload = function() {
                                                if (xhr.status === 200) {
                                                    alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
                                                    // ボタンの表示を切り替える
                                                    document.getElementById("followButtonContainer").innerHTML = '<button onclick="followUser()">フォローする</button>';
                                                } else {
                                                    alert("フォロー解除に失敗しました");
                                                }
                                            };
                                            xhr.send("unfollowingUserId=" + encodeURIComponent(unfollowingUserId));
                                        }
                                    </script>

                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <img src="kawaii.jpg" class="w-100 h-100">
                    </div>
                </div>
            </div>

            <!-- 記事カード生成関数 -->
            <!-- 
                以下のphpで、DBから取得した記事データを元に、記事カードを生成しています。
                これまでプレースホルダー的においていた二つの記事カードはコメントアウトしました。
                記事カードのテストをしたい場合は、自身で適当な記事を投稿するか、
                コメントアウトを適宜解除してください。
                「記事を投稿してもここに反映されない」等不具合あればリーダーに連絡してください。
             -->
        </div>
    </div>
   <!-- </div> -->

<nav  aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">4</a></li>
        <li class="page-item"><a class="page-link" href="#">5</a></li>
        <li class="page-item"><a class="page-link" href="#">6</a></li>
        <li class="page-item"><a class="page-link" href="#">7</a></li>
        <li class="page-item"><a class="page-link" href="#">8</a></li>
        <li class="page-item"><a class="page-link" href="#">9</a></li>
        <li class="page-item"><a class="page-link" href="#">10</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</nav>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./script/script.js"></script>

</body>

</html>
