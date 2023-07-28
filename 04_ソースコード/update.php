<?php
session_start();

$_SESSION['edit-type'] = $_POST['edit-type'];

require_once "./php/DBManager.php";
$db = new DBManager;

if ($_POST['edit-type'] == 0) {
    $oldArticle = $db->getArticleById($_POST['article_id']);
    $usedTags = $db->getTagsByArticleId($_POST["article_id"]);
    $userArticleData = $db->getArticlesByUserId($_SESSION['user_id']);
} else {
    $oldDetail = $db->getDetailById($_POST['detail_id']);
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

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <title>タイトル</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <div class="mb-3">
            <h1>記事編集</h1>
        </div>
        <form action="./php/update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= ($_POST['edit-type'] == 0) ? $_POST['article_id'] : $_POST['detail_id'] ?>">
            <div id="new-field">
                <div class="mb-3 <?= ($_POST['edit-type'] == 1) ? 'd-none' : "" ?>">
                    <label for="articletitle" class="form-label">記事名</label>
                    <input type="text" class="form-control" id="articletitle" name="title" value="<?= $oldArticle['title'] ?>" required <?= ($_POST['edit-type'] == 1) ? 'disabled' : "" ?>>
                </div>
                <div class="mb-3 <?= ($_POST['edit-type'] == 1) ? 'd-none' : "" ?>">
                    <label for="articleoverview" class="form-label">記事概要</label>
                    <!-- <input type="text" class="form-control" id="articleoverview" name="overview" value="<?= $oldArticle['article_description'] ?>" required <?= ($_POST['edit-type'] == 1) ? 'disabled' : "" ?>> -->
                    <textarea class="form-control" id="articleoverview" name="overview" rows="3" required <?= ($_POST['edit-type'] == 1) ? 'disabled' : "" ?>><?= $oldArticle['article_description'] ?></textarea>
                </div>
                <div class="mb-3 <?= ($_POST['edit-type'] == 1) ? 'd-none' : "" ?>">
                    <label for="article_image" class="form-label">現在の表紙画像</label><br>
                    <img class="img-fluid img-thumbnail mb-3 w-50" src="<?php
                                                                        $topimg = glob("./img/article/" . $oldArticle['article_id'] . "/topimage*");
                                                                        if ($topimg) {
                                                                            echo $topimg[0];
                                                                        } else {
                                                                            echo "./img/article_default.png";
                                                                        }
                                                                        ?>" /><br />
                    <input type="file" name="topimg">
                </div>
                <div class="mb-3 <?= ($_POST['edit-type'] == 1) ? 'd-none' : "" ?>">
                    <label for="article_tags" class="form-label">タグ</label><br />
                    <!-- <input type="text" class="form-control" id="articletag" name="tag" required> -->
                    <?php
                    $tags = $db->getTags();
                    try {
                        foreach ($tags as $key) {
                            echo '<label class="d-block"><input type="checkbox" name="tags[]" value="' . $key['tag_id'] . '" ' . ((array_search($key['tag_name'],  array_column($usedTags, 0)) !== false) ? "checked" : "") . '>' . $key['tag_name'] . '</label>';
                        }
                    } catch (Error $e) {
                    }
                    ?>
                </div>
            </div>

            <div class="mb-3 <?= ($_POST['edit-type'] == 0) ? 'd-none' : "" ?>">
                <label><span id="detail-date">1</span>日目</label><br />
                <input id="x" type="hidden" name="content" value="<?= htmlspecialchars($oldDetail['detail_text'], ENT_QUOTES) ?>">
                <trix-editor input="x"></trix-editor>
            </div>
            <!-- <button type="button" onclick="multipleaction('./php/update.php')" class="btn-lg btn-warning">更新</button> -->
            <button type="submit" class="btn-lg btn-warning">更新</button>

            <div class="<?php if (!isset($_SESSION['errorMsg'])) echo "d-none" ?>">
                <div class="border border-danger border-2 rounded mb-2 p-1 err_area fw-bold text-danger">
                    <?php
                    echo $_SESSION['errorMsg'];
                    unset($_SESSION['errorMsg']);
                    ?>
                </div>
            </div>
        </form>
        <!-- Button trigger modal -->
        <!--<button type="button" onclick="multipleaction('./php/delete.php')" class="btn-lg btn-danger" name="delete">-->
        <form action="./php/delete.php" method="post">
            <button type="submit" class="btn-lg btn-danger" name="delete">
                削除
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">最終確認</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            記事を削除します。元には戻せません。よろしいですか？
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                            <button type="submit" class="btn btn-primary">削除</button>

                        </div>
                    </div>
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
                getNextDetailNum(select.value);
            } else {
                newField.classList.remove('d-none');
                for (let i = 0; i < requireFields.length; i++) {
                    requireFields[i].required = true;
                }
                getNextDetailNum(select.value);
            }
        });
    </script>
    <script src="./script/trix_img_uploader.js"></script>
</body>

</html>
