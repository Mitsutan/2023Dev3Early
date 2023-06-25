// selectで選択されたoptionをpostでdetailCnt.phpに渡し、fetchでデータを取得する
function getNextDetailNum(articleId) {
    // const select = document.getElementById("detailNum");
    // const detailNum = select.value;
    const url = "./php/detailCnt.php";
    const data = {
        articleId: articleId
        // detailNum: detailNum
    };
    // console.log(data);
    const options = {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams(data).toString()
    };
    fetch(url, options)
        .then(response => response.text())
        .then(rtn => {
            // console.log(rtn);
            // const detailCnt = json.detailCnt;
            const detailCntText = document.getElementById("detail-date");
            detailCntText.innerHTML = Number(rtn) + 1;
        })
        .catch(error => console.error(error));
}

// フォローボタンをクリックした時の処理
function followUser(id) {
    var followingUserId = id;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/follow.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            // alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
            // ボタンの表示を切り替える
            // document.getElementById("followButtonContainer").innerHTML = '<button onclick="unfollowUser()">フォロー解除する</button>';
            const fbc = document.getElementsByClassName("followButtonContainer-" + id);
            for (let i = 0; i < fbc.length; i++) {
                fbc[i].innerHTML = '<button class="btn btn-primary btn-sm" onclick="unfollowUser(' + id + ')">フォロー解除する</button>';
            }
        } else {
            alert("フォローに失敗しました");
        }
    };
    xhr.send("followingUserId=" + encodeURIComponent(followingUserId));
}

// アンフォローボタンをクリックした時の処理
function unfollowUser(id) {
    var unfollowingUserId = id;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./php/unfollow.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            // alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
            // ボタンの表示を切り替える
            // document.getElementById("followButtonContainer").innerHTML = '<button onclick="followUser()">フォローする</button>';
            const fbc = document.getElementsByClassName("followButtonContainer-" + id);
            for (let i = 0; i < fbc.length; i++) {
                fbc[i].innerHTML = '<button class="btn btn-outline-primary btn-sm" onclick="followUser(' + id + ')">フォローする</button>';
            }
        } else {
            alert("フォロー解除に失敗しました");
        }
    };
    xhr.send("unfollowingUserId=" + encodeURIComponent(unfollowingUserId));
}

// スクロールによってアニメーション発火
const targetElement = document.querySelectorAll(".fade-in");
const animation = new IntersectionObserver(animationCallback, { threshold: 0.8 });

targetElement.forEach(function (el) {
    animation.observe(el);
});

function animationCallback(el) {
    el.forEach(function (e) {
        if (e.isIntersecting) {
            e.target.classList.add("fire");
        }
    });
}
