<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

// $userData = $db->getUser($_GET["id"]);
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
        <h1>いいね記事</h1>

        <div class="row g-5 mx-0">
        <?php
            foreach ($db->getArticlesByGoods($_SESSION['user_id']) as $key => $value) {
                $article = $db->getArticleById($value['article_id']);
                $tags = $db->getTagsByArticleId($value["article_id"]);
                $user = $db->getUser($article["user_id"]);
                $goods = $db->countGoods($article["article_id"]);
                $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $article['user_id']);
                $isGoodsIcon = $db->isGoodsIconArticle($_SESSION['user_id'],$article["article_id"]);

                $card->createCard($article["article_id"], $article["user_id"], $user['user_name'], $article["title"], $article["update_datetime"], $tags, $goods, $isFollowing , $isGoodsIcon);
            }
            ?>
            </div>

        </div>

        <p>いいね機能を使用する場合はログインが必要です</p>
        <p>ログインはこちら</p>

        <!-- </div> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./script/script.js"></script>
        <script src = "./script/script_goods.js"></script>
</body>

</html>
