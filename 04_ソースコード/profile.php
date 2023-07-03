<?php
session_start();
require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

$userData = $db->getUser($_GET["id"]);
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

    <title>プロフィール</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>
    <div class="container">
        <h1><?= $userData['user_name'] ?></h1>
        <div class="row mx-0">
            <div class="col-3 text-center">
                <div class="rounded-circle ratio ratio-1x1">
                    <img src="<?php
                                $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
                                if ($userpic) {
                                    echo $userpic[0];
                                } else {
                                    echo "./img/user_default.png";
                                }
                                ?>" class="rounded-circle ratio ratio-1x1 p-3" width="100" height="100">
                </div>
            </div>
            <div class="col-9">
                <?php
                $showIntroduction = true; // 紹介文を表示するかどうかの条件
                if ($showIntroduction) {
                    echo $userData['user_about_me'];
                } else {
                    // 紹介文を表示しない場合の処理
                }
                ?>
            </div>
            <div class="col-3 text-center">
                <div class="row follower-box">
                    <div class="col-md-6 col-12 follow-count">フォロー:<?= $db->getFollowingCount($_GET['id']) ?></div>
                    <div class="col-md-6 col-12 follower-count">フォロワー:<?= $db->getFollowersCount($_GET['id']) ?></div>
                </div>
            </div>
        </div>


        <h1 style="margin-top:70px;">投稿記事</h1>

        <div class="row g-5 mx-0">

            <!-- <div class="col-md-6 col-12">
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
                                            //     echo "./img/user_default.png";
                                            // }
                                            ?>" class="rounded-circle ratio ratio-1x1">
                            </div>
                            <div class="col-8">
                                <div>
                                    <div>ユーザー名</div>
                                    <div id="followButtonContainer">
                                        <?php
                                        // // DBManagerクラスをインスタンス化
                                        // $dbManager = new DBManager();
                                        // $followingUserId = 1;
                                        // // フォロー状態の判定と表示
                                        // $isFollowing = $dbManager->isFollowingUser($userId, $followingUserId);
                                        // if ($isFollowing) {
                                        //     echo '<button onclick="unfollowUser()">フォロー解除する</button>';
                                        // } else {
                                        //     echo '<button onclick="followUser()">フォローする</button>';
                                        // }
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
            </div> -->

            <!-- 記事カード生成関数 -->
            <!-- 
                以下のphpで、DBから取得した記事データを元に、記事カードを生成しています。
                これまでプレースホルダー的においていた二つの記事カードはコメントアウトしました。
                記事カードのテストをしたい場合は、自身で適当な記事を投稿するか、
                コメントアウトを適宜解除してください。
                「記事を投稿してもここに反映されない」等不具合あればリーダーに連絡してください。
             -->
            <?php
           
            $sort = function ($a, $b) {
                return strtotime($b["update_datetime"]) - strtotime($a["update_datetime"]);
            };
            
            $articles = $db->getArticlesByUserId($_GET["id"]);
            usort($articles, $sort);
                
            //foreach ($db->getArticlesByUserId($_GET["id"]) as $key => $value) {
                foreach ($articles as $key => $value){
                $tags = $db->getTagsByArticleId($value["article_id"]);
                $user = $db->getUser($value["user_id"]);
                $goods = $db->countGoods($value["article_id"]);
                $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $_GET['id']);
                $isGoodsIcon = $db->isGoodsIconArticle($_SESSION['user_id'], $value["article_id"]);
                $card->createCard($value["article_id"], $value["user_id"], $user['user_name'], $value["title"], $value["update_datetime"], $tags, $goods, $isFollowing, $isGoodsIcon);
            }
             
            ?>

        </div>

    </div>


    <?php require_once("./php/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
    <!-- <script src="./script/script_goods.js"></script> -->
</body>

</html>
