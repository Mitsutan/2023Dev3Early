<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

$datas = $db->getPopularArtcles($_POST['index'], $_POST['lastIndex']);

foreach ($datas as $key) {
    $tags = $db->getTagsByArticleId($key["article_id"]);
    $user = $db->getUser($key["user_id"]);
    $goods = $db->countGoods($key["article_id"]);
    $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $key['user_id']);
    $isGoodsIcon = $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]);
    $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
}
?>
