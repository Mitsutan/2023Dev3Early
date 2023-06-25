<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager();

// 記事データ取得
$articleData = $db->getArticleById($_GET["id"]);
// 記事の詳細データ一覧取得
$articleDetails = $db->getDetailsByArticleId($_GET["id"]);
// この記事を書いたユーザーのほかの記事一覧を取得
$userArticleData = $db->getArticlesByUserId($articleData['user_id']);
// この記事を書いたユーザーのデータを取得
$userData = $db->getUser($articleData['user_id']);
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

    <title><?= $articleData['title'] ?></title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <h1 class="mb-3"><?= $articleData['title'] ?></h1>

        <div class="row">
            <div class="col-8">
                <!-- <a href="./update.php"><button type="submit" class="btn btn-warning mb-3 fs-5 px-4">編集</button></a> -->
                <form action="./update.php" method="post">
                    <input type="hidden" name="article_id" value="<?= $articleData['article_id'] ?>">
                    <input type="hidden" name="edit-type" value="0">
                    <button type="submit" class="btn btn-warning mb-3 fs-5 px-4">編集</button>
                </form>
                <img class="img-fluid img-thumbnail mb-3" src="<?php
                $topimg = glob("./img/article/" . $articleData['article_id'] . "/topimage*");
                if ($topimg) {
                    echo $topimg[0];
                } else {
                    echo "./img/article_default.png";
                }
                ?>" />
                <div class="h3 alert-secondary border border-1 border-dark rounded p-2">
                    <?php
                    // echo "#タグ #を #表示 #します";
                    foreach ($db->getTagsByArticleId($articleData['article_id']) as $key => $value) {
                        echo '<a href="./search?type=0&word=' . $value['tag_name'] . '" class="d-inline-block me-1">#' . $value['tag_name'] . '</a>';
                    }
                    ?>
                    
                </div>
                <hr aline="center" size="5" class="bg-primary mb-3">
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                    <p>
                        <?= $articleData['article_description'] ?>
                    </p>
                </div>
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                    <h3 class=""> <?php echo "同じ投稿者の次の投稿記事です" ?> </h3>
                </div>
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                    <h3 class=""> <?php
                    echo "同じ投稿者の次の投稿記事です";
                    echo '<script>console.log(`';
                    print_r($userArticleData);
                    echo '`)</script>';
                    ?> </h3>
                </div>
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-2">
                    <h3><?php echo "投稿者プロフィール" ?></h3>
                    <div class="row">
                        <!-- <img src="./kawaii.jpg" class="col-md-5" style="border-radius: 50%; width: 140px; height: 140px;"> -->
                        <div class="col-md-3">
                            <div class="rounded-circle ratio ratio-1x1">
                                <img src="<?php
                                $userpic = glob("./img/userpics/" . $userData['user_id'] . "/userpic*");
                                if ($userpic) {
                                    echo $userpic[0];
                                } else {
                                    echo "./img/user_default.png";
                                }
                                ?>" class="rounded-circle ratio ratio-1x1" width="250" height="250">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h4><?= $userData['user_name'] ?></h4><br>
                            <p><?= $userData['user_about_me'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <h2>同じシリーズの記事</h2>
                </div>
                <div class="card">
                    <ul class="list-group list-group-flush">
                <?php
                for ($i=0; $i < count($articleDetails); $i++) { 
                    // echo '<div class="h2 text-center alert-secondary border border-1 border-dark rounded p-5 mb-5" >';
                    // echo '<a href="./detail.php?id=' . $articleDetails[$i]['detail_id'] . '" class="mb-2 text-dark" style="font-size: 45px;">関連記事' . $i+1 . '日目</a>';
                    // echo '</div>';
                    echo '<a href="./detail.php?id=' . $articleDetails[$i]['detail_id'] . '"><li class="list-group-item">関連記事' . $i+1 . '日目</li></a>';
                }
                ?>
                    </ul>
                </div>
                <!-- <div class="h2 text-center alert-secondary border border-1 border-dark rounded p-5 mb-5" >
                    <a href="./detail.php?id=" class="mb-2 text-dark" style="font-size: 45px;"> <?php //echo "関連記事1日目" ?> </a> 
                </div> -->
                <!-- <a href="./signup.php">
                    <div class="h2 text-center alert-secondary border border-1 border-dark rounded p-2 mb-2">
                        <?php //echo "関連記事１日目" ?>
                    </div>
                </a> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
