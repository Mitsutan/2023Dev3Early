<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager;

$userArticleData = $db->getArticlesByUserId($_SESSION['user_id']);
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

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <title>タイトル</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <div class="mb-3">
            <h1>新規記事投稿</h1>
        </div>
        <form action="./php/write.php" enctype="multipart/form-data" method="post">
            <div class="mb-3">
                <label for="articleseries" class="form-label">シリーズ</label>
                <select class="form-select" id="articleselect" name="articleselect" aria-label="Default select example">

                    <option value="" selected>---新規---</option>
                    <!-- 以下に既存の記事名が入る -->
                    <!-- <option value="1">One</option> -->
                    <?php
                    foreach ($userArticleData as $key => $value) {
                        echo '<option value="' . $value['article_id'] . '">' . $value['title'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div id="new-field">
                <div class="mb-3">
                    <label for="articletitle" class="form-label">記事名</label>
                    <input type="text" class="form-control" id="articletitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="articleoverview" class="form-label">記事概要</label>
                    <input type="text" class="form-control" id="articleoverview" name="overview" required>
                </div>
                <div class="mb-3">
                    <label for="article_image" class="form-label">表紙画像</label><br>
                    <input type="file" name="topimg">
                </div>
                <div class="mb-3">
                    <label for="article_tags" class="form-label">タグ</label><br />
                    <!-- <input type="text" class="form-control" id="articletag" name="tag" required> -->
                    <?php
                    $tags = $db->getTags();
                    foreach ($tags as $key) {
                        echo '<label class="d-block"><input type="checkbox" name="tags[]" value="' . $key['tag_id'] . '">' . $key['tag_name'] . '</label>';
                    }
                    ?>
                </div>
            </div>

            <div class="mb-3">
                <label>日目</label><br />
                <input id="x" type="hidden" name="content">
                <trix-editor input="x"></trix-editor>
            </div>
            <button type="submit" class="btn-lg btn-warning">投稿</button>

            <div class="<?php if (!isset($_SESSION['errorMsg'])) echo "d-none" ?>">
                <div class="border border-danger border-2 rounded mb-2 p-1 err_area fw-bold text-danger">
                    <?php
                    echo $_SESSION['errorMsg'];
                    unset($_SESSION['errorMsg']);
                    ?>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
    <script>
        // 本文内画像の保存先
        var HOST = "./img/detail/<?= $_SESSION['user_id'] ?>/";

        const select = document.getElementById('articleselect');
        const newField = document.getElementById('new-field');
        const requireFields = document.getElementsByClassName('form-control');

        select.addEventListener('change', function() {
            console.log(select.selectedIndex);

            if (select.selectedIndex != 0) {
                newField.classList.add('d-none');
                for (let i = 0; i < requireFields.length; i++) {
                    requireFields[i].required = false;
                }
            } else {
                newField.classList.remove('d-none');
                for (let i = 0; i < requireFields.length; i++) {
                    requireFields[i].required = true;
                }
            }
        });
    </script>
    <script src="./script/trix_img_uploader.js"></script>
</body>

</html>
