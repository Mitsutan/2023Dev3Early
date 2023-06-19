<?php
session_start();
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

    <title>筋肉Memorial -検索-</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class = "from-group">
        <p class="control-label"><b>対象</b></p>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault1">
            <label class="form-check-label" for="Radio1">タグ</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">記事名</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="Radio" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">ユーザー名</label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">フォローのみ</label>
        </div>
    </div>

    <div class="input-group">
        <input type="text" class="form-control" placeholder="キーワードを入力">
        <button class="btn btn-outline-success" type="button" id="button-addon2"><i class="fas fa-search"></i> 検索</button>
    </div>

    <div class="container">
        <h1>検索結果</h1>
    </div>

    <div class="row">
        <div class="col-6">
            <span>並び替え：</span>
            <select name=”item”>
                <option value=”item1”>人気順　　　　</option>
                <option value=”item2”>新着順　　　　</option>
                <option value=”item3”>過去１週間の人気順</option>
            </select>
        </div>
        <div class="col-6">
            <p>XXX件中～X件表示</p>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./script/script.js"></script>
</body>

</html>