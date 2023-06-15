<?php
session_start();

require_once "./php/DBManager.php";
require_once "./php/ACGenerator.php";
$db = new DBManager;
$card = new ACGenerator;

$userData = $db->getUser($_GET["id"]);

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
            <div class="col-md-6 col-12">
                <div class="row border-start border-end border-dark border-1 p-2">
                    <div class="col-7">
                        <h3>記事の見出し</h3>
                        <div class="d-flex justify-content-between">
                            <p>2023/xx/xx</p>
                            <?php
                                <form action = "./goods.php" method = "post">
                                    <input type="hidden" name="article_id" value="<?= $articleData['article_id'] ?>">
                                    <p><i class="fa-solid fa-thumbs-up me-1">
                                    
                            </i>1234</p>
                        </div>
                        <div>
                            <div style="display:inline-block;">#ダイエット</div>
                            <div style="display:inline-block;">#筋トレ</div>
                            <div style="display:inline-block;">#胸</div>
                        </div>
                        <div class="row align-items-end" style="min-height: 10vmax;">
                            <div class="col-4">
                                <!-- <div class="rounded-circle ratio ratio-1x1 w-25"> -->
                                <img src="<?php
                                            $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
                                            if ($userpic) {
                                                echo $userpic[0];
                                            } else {
                                                echo "./img/user_default.png";
                                            }
                                            ?>" class="rounded-circle ratio ratio-1x1">
                                <!-- </div> -->
                            </div>
                            <div class="col-8">
                                <div>
                                    <div>ユーザー名</div>
                                    <div>フォローする</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <img src="kawaii.jpg" class="w-100 h-100">
                    </div>
                </div>
            </div>

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
                                <!-- <div class="rounded-circle ratio ratio-1x1 w-25"> -->
                                <img src="<?php
                                            $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
                                            if ($userpic) {
                                                echo $userpic[0];
                                            } else {
                                                echo "./img/user_default.png";
                                            }
                                            ?>" class="img-fluid mw-100 h-auto rounded-circle ratio ratio-1x1 ">
                                <!-- </div> -->
                            </div>
                            <div class="col-8">
                                <div>
                                    <div>ユーザー名</div>
                                    <div>フォローする</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <img src="kawaii.jpg" class="w-100 h-100">
                    </div>
                </div>
            </div>

            <?php
            foreach ($db->getArticlesByUserId($_GET["id"]) as $key => $value) {
                $tags = $db->getTagsByArticleId($value["article_id"]);
                $card->createCard($value["article_id"], $value["user_id"], $value["title"], $value["update_datetime"], $tags, 0);
            }
            ?>

        </div>

        <p>いいね機能を使用する場合はログインが必要です</p>
        <p>ログインはこちら</p>

        <!-- </div> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./script/script.js"></script>
</body>

</html>
