<?php
session_start()
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

    <title>タイトル</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container-fluid">
        <div class="row col-md-7">
            <div class="container-fluid">
                <!-- <div class="row"> -->
                    <h1 class="mb-3">ハッシュタグ一覧</h1>
                    <button type="submit" class="btn btn-warning mb-3"><a href="./update.php" style="font-size: 20px;">編集</a></button><br>
                    <img class="img-fluid img-thumbnail mb-3 col-md-10" src="./kawaii.jpg" />
                    <label for="article_tags" class="h3 form-label alert-secondary col-md-10" style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333; border-radius: 10px;" >
                        <?php echo "#タグ #を #表示 #します" ?></label><br />
                    <hr aline="center" size="5" class="col-md-10 bg-primary mb-3">
                    <p for="article_detail" class="form-label alert-secondary col-md-10 mb-3" style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333; border-radius: 10px;" >
                        <?php echo"本文を表示----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------" ?></p><br>
                    <label for="article_tags" class="form-label alert-secondary col-md-10" style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333; border-radius: 10px;" >
                        <h3><?php echo "投稿者プロフィール" ?><h3><br>
                        <div class="row">
                            <img src="./kawaii.jpg" class="col-md-5" style="border-radius: 50%; width: 140px; height: 140px;">
                            <p class="col-md-7"> <?php echo "投稿者名"?> </p>
                        </div>
                    </label><br />
                <!-- </div>  -->
            </div>
            <!-- <div class="col-md-5">
                <div class="container-fluid"> 
                </div>
            </div> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>