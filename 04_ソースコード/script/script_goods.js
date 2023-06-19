// フォローボタンをクリックした時の処理
function clickGoods(article) {
    var articleId = article;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/goods.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
            document.getElementById("goodsCnt").innerHTML = xhr.responseText;
            // ボタンの表示を切り替える
            // document.getElementById("followButtonContainer").innerHTML = '<button onclick="unfollowUser()">フォロー解除する</button>';
            //const fbc = document.getElementsByClassName("followButtonContainer-" + id);
            const articles = document.getElementsByClassName("articleGoodsContainer" + article);
            for (let i = 0; i < articles.length; i++) {
                // articles[i].innerHTML = 'a';
            }
        } else {
            alert("フォローに失敗しました");
        }
    };
    xhr.send("articleNum=" + encodeURIComponent(articleId));
}

// アンフォローボタンをクリックした時の処理
function unfollowUser(id) {
    var unfollowingUserId = id;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/unfollow.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
            // ボタンの表示を切り替える
            // document.getElementById("followButtonContainer").innerHTML = '<button onclick="followUser()">フォローする</button>';
            const fbc = document.getElementsByClassName("followButtonContainer-" + id);
            for (let i = 0; i < fbc.length; i++) {
                fbc[i].innerHTML = '<button onclick="followUser(' + id + ')">フォローする</button>';
            }
        } else {
            alert("フォロー解除に失敗しました");
        }
    };
    xhr.send("unfollowingUserId=" + encodeURIComponent(unfollowingUserId));
}
