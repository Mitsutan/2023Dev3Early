<?php
session_start();
require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;
 
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

    <title>筋肉Memorial</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <h1>注目記事</h1>
        <div class="row g-5 mx-0" id="popularArticle">
            <?php
            $datas = $db->getPopularArtcles(0, 4);
            foreach ($datas as $key) {
                $tags = $db->getTagsByArticleId($key["article_id"]);
                $user = $db->getUser($key["user_id"]);
                $goods = $db->countGoods($key["article_id"]);
                $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $key["user_id"]);
                $isGoodsIcon = $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]);
                $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
            }
            ?>
        </div>
        <button id="popularArticle-btn" onclick="getMore(4,8,'popularArticle')">もっとみる ></button>
        <h1>新着記事</h1>
        <div class="row g-5 mx-0">
        <?php
        $sort = function ($a, $b) {
            return strtotime($b["update_datetime"]) - strtotime($a["update_datetime"]);
        };
        
        $articles = $db->getAllArticles(); 
        
        usort($articles, $sort);
        
        foreach ($articles as $key => $value) {
            $tags = $db->getTagsByArticleId($value["article_id"]);
            $user = $db->getUser($value["user_id"]);
            $goods = $db->countGoods($value["article_id"]);
            $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $value["user_id"]);
            $isGoodsIcon = $db->isGoodsIconArticle($_SESSION['user_id'], $value["article_id"]);
            $card->createCard($value["article_id"], $value["user_id"], $user['user_name'], $value["title"], $value["update_datetime"], $tags, $goods, $isFollowing, $isGoodsIcon);
        }
        ?>
        </div>

        
   
        <?= (isset($_SESSION['user_id'])? '<h1>フォローユーザーの記事</h1>' : "") ?>
    </div>

    <?php require_once "./php/footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
