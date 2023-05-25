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
        <h1>（関数記入）のページ</h1>
        <div class="container">
        <div class="d-grid gap-2"><a href="./signup.php" class="btn btn-warning">新規記事投稿</a></div>
        </div>
        <form action="./php/update.php" method="post">
            <div class="mb-3">
                <label for="UpdateEmail1" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="UpdateEmail1" name="mail" aria-describedby="emailHelp" required>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <div class="mb-3">
                <label for="UpdatePassword1" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="UpdatePassword1" name="pass" required>
            </div>
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <div class="mb-3">
                <label for="UpdateIntroduce" class="form-label">自己紹介</label>
                <input type="text" class="form-control" id="updateIntroduce" name="Introduce" required>
            </div>
            <button type="submit" class="btn-lg btn-warning">更新</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./script/script.js"></script>
</body>

</html>
---