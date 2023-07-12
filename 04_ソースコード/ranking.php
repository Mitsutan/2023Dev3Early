<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

$articleids = $db->getArticleIdsOrderByGoods(0, 4);
$datas = [];
foreach ($articleids as $key) {
    $data = $db->getArticleById($key["article_id"]);
    array_push($datas, $data);
}
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

    <title>ランキング</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <h1>記事ランキング</h1>
        <div class="row g-5 mx-0" id="rank-1">
            <?php
            $tags = $db->getTagsByArticleId($datas[0]["article_id"]);
            $user = $db->getUser($datas[0]["user_id"]);
            $goods = $db->countGoods($datas[0]["article_id"]);
            $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $datas[0]["user_id"]) : false);
            $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $datas[0]["article_id"]) : false);
            $card->createCard($datas[0]['article_id'], $datas[0]['user_id'], $user['user_name'], $datas[0]['title'], $datas[0]['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
            ?>
        </div>
        <div class="row g-5 mx-0" id="rank-23">
            <?php
            $tags = $db->getTagsByArticleId($datas[1]["article_id"]);
            $user = $db->getUser($datas[1]["user_id"]);
            $goods = $db->countGoods($datas[1]["article_id"]);
            $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $datas[1]["user_id"]) : false);
            $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $datas[1]["article_id"]) : false);
            $card->createCard($datas[1]['article_id'], $datas[1]['user_id'], $user['user_name'], $datas[1]['title'], $datas[1]['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
            ?>
            <?php
            $tags = $db->getTagsByArticleId($datas[2]["article_id"]);
            $user = $db->getUser($datas[2]["user_id"]);
            $goods = $db->countGoods($datas[2]["article_id"]);
            $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $datas[2]["user_id"]) : false);
            $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $datas[2]["article_id"]) : false);
            $card->createCard($datas[2]['article_id'], $datas[2]['user_id'], $user['user_name'], $datas[2]['title'], $datas[2]['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
            ?>
        </div>
    </div>

    <?php require_once "./php/footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
