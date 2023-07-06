<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

switch ($_POST['fieldId']) {
    case 'popularArticle':
        $datas = $db->getPopularArtcles($_POST['index'], $_POST['count']);
        break;
    
    case 'newArticle':
        $datas = $db->getAllArticlesOrderByUpdate($_POST['index'], $_POST['count']);
        break;

    case 'followingArticle':
        $datas = $db->getFollowArticles($_SESSION['user_id'], $_POST['index'], $_POST['count']);
        break;

    default:
        exit;
        break;
}

echo "<!-- article cnt is ".count($datas)." -->\n";
foreach ($datas as $key) {
    $tags = $db->getTagsByArticleId($key["article_id"]);
    $user = $db->getUser($key["user_id"]);
    $goods = $db->countGoods($key["article_id"]);
    $isFollowing = (isset($_SESSION['user_id'])? $db->isFollowingUser($_SESSION['user_id'], $key['user_id']) : false);
    $isGoodsIcon = (isset($_SESSION['user_id'])? $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]) : false);
    $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
}
?>
