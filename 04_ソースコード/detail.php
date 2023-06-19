<?php
session_start();

require_once "./php/DBManager.php";
$db = new DBManager;

$detailData = $db->getDetailById($_GET['id']);
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
        <h1 class="mb-3">記事の見出し-1日目-</h1>

        <div class="row">
            <div class="col-6">
                <a href="./update.php"><button type="submit" class="btn btn-warning mb-3 fs-5">　編集　</button></a>
                <p>説明</p>
                <div class="rounded p-2 mb-3">
                    <!-- <p>
                        <?php //echo "本文を表示----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------" ?>
                    </p> -->
                    <div class="trix-content"><?php echo $detailData['detail_text'] ?></div>
                </div>
                <hr aline="center" size="5" class="bg-primary mb-3">
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                    <div class="row h3">
                        <div class="col-6">
                            <?php echo "　コメント"?>
                        </div>
                        <div class="col-6 text-center">
                            <?php echo "××" ?>
                            <?php echo "件" ?>
                        </div>
                    </div>
                </div>
                <script language=javascript>
                function show(inputData){
                    var objID=document.getElementById( "layer_" + inputData );
                    var buttonID=document.getElementById( "category_" + inputData );
                    if(objID.className=='close') {
                        objID.style.display='block';
                        objID.className='open';
                    }else{
                        objID.style.display='none';
                        objID.className='close';
                    }
                }
                </script>
                <div class="alert-secondary border border-1 border-dark rounded p-2 mb-3">
                <p>　コメント一件目</p>
                    <div class="text-center">
                    <a href="javascript:void(0)" id="category_折りたたみ" onclick="show('折りたたみ');">続きを表示</a>
                    </div>
                    <div id="layer_折りたたみ" style="display: none;position:relative;margin-left:15pt" class="close">
                        二件目<br>
                        三件目<br>
                        四件目
                    </div>
                </div>
                <div class="text-center">
                <a href=""><button type="submit" class="btn btn-warning mb-3 fs-5">　コメントを投稿　</button></a>
                </div>
            </div>
            <div class="col-2">
            </div>
            <div class="col-4">
                <div class="mb-3">
                    <h2>同じシリーズの記事</h2>
                </div>
                <div class="h2 text-center alert-secondary border border-1 border-dark rounded p-2 mb-2" >
                    <a href="./signup.php" class="mb-2 text-dark"> <?php echo "関連記事1日目" ?> </a> 
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
