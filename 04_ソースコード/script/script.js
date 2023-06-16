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
