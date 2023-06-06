<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager;

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
        <h1><?php echo $userData['user_name'] ?></h1>
        <div class="row">
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
            <div class="col-3" style="text-align:center; padding-left:3%">
                <div class="follower-box">
                    <div class="follow-count" style="float: left;">フォロー:</div>
                    <div class="follower-count">フォロワー:</div>
                </div>
            </div>



            <h1 style="margin-top:70px;">投稿記事</h1>

            <div class="row gx-5">
                <div class="col-6">
                    <div class="row border border-primary">
                        <div class="col-7">
                            <h3>記事の見出し</h3>
                            <p>2023/xx/xx</p>
                            <div>
                                <div style="display:inline-block;">#ダイエット</div>
                                <div style="display:inline-block;">#筋トレ</div>
                                <div style="display:inline-block;">#胸</div>
                            </div>
                            <div class="row align-items-end" style="min-height: 10vmax;">
                                <div class="col-3">
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
                                <div class="col-9">
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




                <div class="col-6">
                    <div class="row border border-primary">
                        <div class="col-7">
                            <h3>記事の見出し</h3>
                            <p>2023/xx/xx</p>
                            <div>
                                <div style="display:inline-block;">#ダイエット</div>
                                <div style="display:inline-block;">#筋トレ</div>
                                <div style="display:inline-block;">#胸</div>
                            </div>
                            <div class="row align-items-end" style="min-height: 10vmax;">
                                <div class="col-3">
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
                                <div class="col-9">
                                    <div>
                                        <div>ユーザー名</div>
                                        <div>フォローする</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <img src="kawa.jpg" class="w-100 h-100">
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./script/script.js"></script>
</body>

</html>
