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

    <title>筋肉Memorial -新規登録-</title>
</head>

<body>
    <?php require_once "./php/header.php" ?>

    <div class="container-fluid">
        <h1>新規登録</h1>

        <div class="mb-2">
            <a href="./login.php">ログインはこちら</a>
        </div>

        <!-- error message area -->
        <div class="<?php if (!isset($_SESSION['errorMsg'])) echo "d-none" ?>">
            <div class="border border-danger border-2 rounded mb-2 p-1 err_area fw-bold text-danger">
                <?php
                echo $_SESSION['errorMsg'];
                unset($_SESSION['errorMsg']);
                ?>
            </div>
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
            <div class="mb-3">
                <label for="InputName" class="form-label">ユーザー名</label>
                <input type="text" class="form-control" id="InputName" name="name" required>
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-warning">登録</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
