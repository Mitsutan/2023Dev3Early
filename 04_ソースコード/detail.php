<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager;

$detailData = $db->getDetailById($_GET['id']);
$articleData = $db->getArticleById($detailData['article_id']);
$articleDetails = $db->getDetailsByArticleId($detailData['article_id']);


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

    <title>記事詳細</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container">
        <h1 class="mb-3"><?= $articleData['title'] ?>-<?= array_search($_GET['id'], array_column($articleDetails, 'detail_id')) + 1 ?>日目-</h1>

        <div class="row">
            <div class="col-8">
                <form action="./update.php" method="post">
                    <input type="hidden" name="detail_id" value="<?= $detailData['detail_id'] ?>">
                    <input type="hidden" name="edit-type" value="1">
                    <button type="submit" class="btn btn-warning mb-3 fs-5 px-4">編集</button>
                </form>
                <p>説明</p>
                <div class="rounded p-2 mb-3">
                    <div class="trix-content"><?php echo $detailData['detail_text'] ?></div>
                </div>
                <hr aline="center" size="5" class="bg-primary mb-3">
                <div class="border border-1 border-dark rounded p-2 mb-3">
                    <div class="row h3">
                        <div class="col-6">
                            <?php echo "コメント" ?>
                        </div>
                        <div class="col-6 text-center">
                            <?php
                            $comments = $db->getCommentsByDetailId($_GET['id']);
                            echo count($comments) . "件";
                            ?>
                        </div>
                    </div>
                    <div>
                        <!-- comment field -->
                        <?php
                        foreach ($comments as $c) {
                            echo $c['comment'] . "<br />";
                        }
                        ?>
                    </div>
                </div>
                <!-- <script language=javascript>
                    function show(inputData) {
                        var objID = document.getElementById("layer_" + inputData);
                        var buttonID = document.getElementById("category_" + inputData);
                        if (objID.className == 'close') {
                            objID.style.display = 'block';
                            objID.className = 'open';
                        } else {
                            objID.style.display = 'none';
                            objID.className = 'close';
                        }
                    }
                </script> -->
                <!-- <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                    <p>　コメント一件目</p>
                    <div class="text-center">
                        <a href="javascript:void(0)" id="category_折りたたみ" onclick="show('折りたたみ');">続きを表示</a>
                    </div>
                    <div id="layer_折りたたみ" style="display: none;position:relative;margin-left:15pt" class="close">
                        二件目<br>
                        三件目<br>
                        四件目
                    </div>

                </div> -->
                <div class="text-center">
                    <form action="./php/comment.php" method="post">
                        <div class="input-group mb-3">
                            <!-- <span class="input-group-text">With textarea</span> -->
                            <textarea class="form-control" aria-label="With textarea" name="comment"></textarea>
                        </div>
                        <input type="hidden" name="detailId" value="<?= $_GET['id'] ?>">
                        <button type="submit" class="btn btn-warning mb-3">投稿</button>
                    </form>
                </div>
            </div>
            <!-- <div class="col-2">
            </div> -->
            <div class="col-4">
                <div class="mb-3">
                    <h2>同じシリーズの記事</h2>
                </div>
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <?php
                        for ($i = 0; $i < count($articleDetails); $i++) {
                            echo '<a href="./detail.php?id=' . $articleDetails[$i]['detail_id'] . '"><li class="list-group-item">関連記事' . $i + 1 . '日目</li></a>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./php/footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
