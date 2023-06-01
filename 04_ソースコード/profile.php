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
    <div class="container-fluid">
        <h1 style = "margin-top:70px; margin-left:30px;">（ここにユーザー名）</h1>
        <div class = "row gx-3" style = "height: 400px">
        <div class = "col-3 d-flex align-items-center">
            <img src="kawaii.jpg" class="mx-auto d-block" style = "border-radius: 50%; width: 250px; height: 250px;">
        </div>
        <div class="follower-box">
            <div class="follow-count">フォロー:</div>
            <div class="follower-count">フォロワー:</div>
        

    <div class ="col-9">
    <?php
        $showIntroduction = true; // 紹介文を表示するかどうかの条件
        if ($showIntroduction) {
            echo "<div>（ここに自己紹介文）</div>";
        } else {
            // 紹介文を表示しない場合の処理
        }
    ?>
    </div>
    </div>
    

            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./script/script.js"></script>
</body>

</html>
