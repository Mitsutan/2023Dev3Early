<?php
session_start()

// DBManager.php ファイルをインクルードします
require_once './php/DBManager.php';

// POST リクエストの処理を行います
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力された情報を取得します
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    // DBManager オブジェクトを作成します
    $dbManager = new DBManager();

    try {
        // ユーザーを登録します
        $dbManager->submitUser('', $pass, $mail); // ユーザー名は空文字列としていますが、適宜修正してください

        // 登録成功時の処理（例: ログイン画面にリダイレクト）
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        // エラーが発生した場合の処理（例: エラーメッセージの表示）
        $errorMessage = $e->getMessage();
    }
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

    <title>筋肉Memorial -新規登録-</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container-fluid">
        <h1>新規登録</h1>

        <div class="mb-2">
            <a href="./signup.php">新規登録はこちら</a>
        </div>
        <form action="./php/signup.php" method="post">
            <div class="mb-3">
                <label for="InputEmail1" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="InputEmail1" name="mail" aria-describedby="emailHelp" required>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="InputPassword1" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="InputPassword1" name="pass" required>
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-warning">ログイン</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
---