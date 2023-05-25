<!DOCTYPE html>
<html>
<head>
    <title>プロフィール</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header>
        <!-- ヘッダーの内容 -->
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2>プロフィール名</h2>
                <img src="path_to_profile_image" alt="プロフィール画像">
                <p>自己紹介文</p>
                <p>フォロー数: <span id="following-count"></span></p>
                <p>フォロワー数: <span id="followers-count"></span></p>
            </div>
            <div class="col-md-9">
                <h2>投稿した記事一覧</h2>
                <ul id="article-list"></ul>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // ページ読み込み時にプロフィール情報を取得
            getProfileData();
        });

        function getProfileData() {
            // バックエンドとのデータ連携（Ajax）
            $.ajax({
                url: "backend.php", // バックエンドの処理を実行するファイルのパスを指定
                type: "GET",
                dataType: "json",
                success: function(response) {
                    // 応答データを元にプロフィール情報を表示
                    $("#following-count").text(response.followingCount);
                    $("#followers-count").text(response.followersCount);

                    // 投稿記事一覧を表示
                    var articleList = response.articleList;
                    for (var i = 0; i < articleList.length; i++) {
                        var article = articleList[i];
                        $("#article-list").append("<li>" + article.title + "</li>");
                    }
                },
                error: function(xhr, status, error) {
                    console.log("エラー: " + error);
                }
            });
        }
    </script>
</body>
</html>
