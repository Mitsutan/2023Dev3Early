<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager();

$userData = $db->getUser($_SESSION["user_id"]);
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

    <title>マイページ</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container-fluid">
        <div class="row">
        <h1><?= $_SESSION["user_name"]; ?>のページ</h1>
            <div class="col-md-5">
                <div class="container">
                    <h1><?= $_SESSION["user_name"]; ?>のページ</h1>
                    <div class="d-grid gap-2 text-center"><a href="./write.php" class="btn-lg btn-warning mb-3">新規記事投稿</a></div>
                    <form action="./php/updateuser.php" enctype="multipart/form-data" method="post">
                        <div class="mb-3">
                            <label for="UpdateEmail1" class="form-label">メールアドレス</label>
                            <input type="email" class="form-control" id="UpdateEmail1" name="mail" value="<?= $userData['user_mail'] ?>" aria-describedby="emailHelp" required>
                            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        </div>
                        <div class="mb-3">
                            <label for="UpdateEmail1" class="form-label">ユーザー名</label>
                            <input type="text" class="form-control" id="UpdateName" name="name" value="<?= $userData['user_name'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="UpdateIntroduce" class="form-label">自己紹介</label>
                            <textarea name="Introduce" class="form-control" id="updateIntroduce"><?= $userData['user_about_me'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="rounded-circle ratio ratio-1x1 w-25 h-25">
                                <img src="<?php
                                            $userpic = glob("./img/userpics/" . $_SESSION['user_id'] . "/userpic*");
                                            if ($userpic) {
                                                echo $userpic[0];
                                            } else {
                                                echo "./img/user_default.png";
                                            }
                                            ?>" class="rounded-circle ratio ratio-1x1" width="250" height="250">
                            </div>
                            <label for="UpdateIntroduce" class="form-label">プロフィール画像</label><br>
                            <input type="file" accept = "image/*" name="avatar">
                        </div>
                        <div class="container mt-3 mb-3 text-center">
                            <button type="submit" class="btn-lg btn-warning">　　更新　　</button>
                        </div>
                        <!-- <button type="submit" class="btn-lg btn-warning">更新</button> -->
                        <!-- error message area -->
                        <div class="<?php if (!isset($_SESSION['errorMsg'])) echo "d-none" ?>">
                            <div class="border border-danger border-2 rounded mb-2 p-1 err_area fw-bold text-danger">
                                <?php
                                echo $_SESSION['errorMsg'];
                                unset($_SESSION['errorMsg']);
                                ?>
                            </div>
                </div>
            </div>

        </div>
    </div>

    <?php require_once "./php/footer.php" ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
