<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/search.php";
require_once "./php/Tbl_mmemorial.php";
$search = new Search;
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

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

        <h1>検索</h1>
        <form class="mb-2" action="" method="get">
            <div class="from-group">
                <p class="control-label fw-bold">対象</p>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="type" value="0" id="flexRadioDefault1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">タグ</label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="type" value="1" id="flexRadioDefault2" <?= (isset($_GET['type']) && $_GET['type'] == 1) ? "checked" : "" ?>>
                    <label class="form-check-label" for="flexRadioDefault2">記事名</label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="type" value="2" id="flexRadioDefault3" <?= (isset($_GET['type']) && $_GET['type'] == 2) ? "checked" : "" ?>>
                    <label class="form-check-label" for="flexRadioDefault3">ユーザー名</label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="checkbox" name="followOnly" value="y" id="defaultCheck1" <?= isset($_GET['followOnly']) ? "checked" : "" ?>>
                    <label class="form-check-label" for="defaultCheck1">フォローのみ</label>
                </div>

                <div class="form-check-inline">
                    <span>並び替え：</span>
                    <select name="sort">
                        <option value="1">新着順</option>
                        <option value="2" <?= (isset($_GET['sort']) && $_GET['sort'] == 2) ? "selected" : "" ?>>いいね数順</option>
                        <!-- <option value=”item3”>過去１週間の人気順</option> -->
                    </select>
                </div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control" name="word" placeholder="キーワードを入力" value="<?= isset($_GET['word']) ? $_GET['word'] : '' ?>">
                <button class="btn btn-outline-success" type="submit" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
            </div>
        </form>


        <h1>検索結果</h1>

        <div class="<?= (isset($_GET['type'])) ? '' : 'd-none' ?>">
            <div class="row">
                <!-- <div class="col-6">
                    <span>並び替え：</span>
                    <select name=”item”>
                        <option value=”item1”>新着順</option>
                        <option value=”item2”>いいね数順</option>
                        <option value=”item3”>過去１週間の人気順</option>
                    </select>
                </div> -->
                <div class="col-6">
                    <p><span id="dataCnt">0</span>件中～<span>0</span>件表示</p>
                </div>
            </div>

            <div class="row g-5 mx-0">

                <?php
                // 検索結果数
                $dataCnt = 0;

                // 新着順ソートコールバック関数
                $sort = function ($a, $b) {
                    return strtotime($b["update_datetime"]) - strtotime($a["update_datetime"]);
                };

                // いいね数順ソートコールバック関数
                $sort2 = function ($a, $b) {
                    return $b["good"] - $a["good"];
                };


                if (isset($_GET['type'])) {
                    switch ($_GET['type']) {
                        case '0': // タグ
                            $restags = $db->getTagsByName($_GET['word']);
                            $res = [];
                            foreach ($restags as $key) {
                                $res = array_merge($res, $db->getArticlesByTagId($key["tag_id"]));
                            }

                            // 多次元配列の重複を削除
                            $res = array_map("unserialize", array_unique(array_map("serialize", $res)));


                            $sorttype = isset($_GET['sort']) ? $_GET['sort'] : 1;
                            switch ($sorttype) {
                                case '1':
                                    usort($res, $sort);
                                    break;

                                case '2':
                                    usort($res, $sort2);
                                    break;

                                default:

                                    break;
                            }

                            foreach ($res as $key) {
                                $tags = $db->getTagsByArticleId($key["article_id"]);
                                $user = $db->getUser($key["user_id"]);
                                // $goods = $db->countGoods($key["article_id"]);
                                $goods = $key["good"];
                                $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $key["user_id"]) : false);
                                if (isset($_GET['followOnly']) && !$isFollowing) {
                                    continue;
                                }
                                $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]) : false);
                                $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
                                $dataCnt++;
                            }
                            break;

                        case '1': // 記事名
                            $res = $db->getArticlesByTitle($_GET['word']);
                            switch ($_GET['sort']) {
                                case '1':
                                    usort($res, $sort);
                                    break;

                                case '2':
                                    usort($res, $sort2);
                                    break;

                                default:

                                    break;
                            }
                            foreach ($res as $key) {
                                $tags = $db->getTagsByArticleId($key["article_id"]);
                                $user = $db->getUser($key["user_id"]);
                                $goods = $db->countGoods($key["article_id"]);
                                $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $key["user_id"]) : false);
                                if (isset($_GET['followOnly']) && !$isFollowing) {
                                    continue;
                                }
                                $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]) : false);
                                $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
                                $dataCnt++;
                            }
                            break;

                        case '2': // ユーザー名
                            $resusers = $db->getUserIds($_GET['word']);
                            $res = [];
                            foreach ($resusers as $key) {
                                $res = array_merge($res, $db->getArticlesByUserId($key["user_id"]));
                            }
                            switch ($_GET['sort']) {
                                case '1':
                                    usort($res, $sort);
                                    break;

                                case '2':
                                    usort($res, $sort2);
                                    break;

                                default:

                                    break;
                            }
                            foreach ($res as $key) {
                                $tags = $db->getTagsByArticleId($key["article_id"]);
                                $user = $db->getUser($key["user_id"]);
                                $goods = $db->countGoods($key["article_id"]);
                                $isFollowing = (isset($_SESSION['user_id']) ? $db->isFollowingUser($_SESSION['user_id'], $key["user_id"]) : false);
                                if (isset($_GET['followOnly']) && !$isFollowing) {
                                    continue;
                                }
                                $isGoodsIcon = (isset($_SESSION['user_id']) ? $db->isGoodsIconArticle($_SESSION['user_id'], $key["article_id"]) : false);
                                $card->createCard($key['article_id'], $key['user_id'], $user['user_name'], $key['title'], $key['update_datetime'], $tags, $goods, $isFollowing, $isGoodsIcon);
                                $dataCnt++;
                            }
                            break;

                        default: // 存在しないtype
                            // exception
                            break;
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <nav aria-label="Page navigation example">
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

    <?php require_once "./php/footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
    <script>
        document.getElementById("dataCnt").innerText = <?= $dataCnt ?>;
    </script>

</body>

</html>
