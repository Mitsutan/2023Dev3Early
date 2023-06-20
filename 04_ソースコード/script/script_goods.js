// フォローボタンをクリックした時の処理
function clickGoods(article) {
    var articleId = article;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/goods.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            // alert(xhr.response); // レスポンスの表示（成功メッセージなど）
            data = JSON.parse(xhr.response);
            document.getElementById("goodsCnt" + article).innerHTML = data['count'];
            if (data['result']) {
                document.getElementById("goodsIcon" + article).classList.remove('fa-regular');
                document.getElementById("goodsIcon" + article).classList.add('fa-solid');
            } else {
                document.getElementById("goodsIcon" + article).classList.remove('fa-solid');
                document.getElementById("goodsIcon" + article).classList.add('fa-regular');
            }
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
