<?php

//データベースマネージャーの読み込み

class Search{
    public function SearchArticle(){
        require_once "./php/DBManager.php";
        $db = new DBManager;
        if(isset($_POST["Check"])){
            if(isset($_POST["Radio"])){
                $cs = $_POST["Radio"];
                
            }
        }
        if(isset($_POST["Radio"])){
            switch($_POST["Radio"]){
                case 'tag':
                    //処理
                    break;
                case 'title':
                    $box = $db -> getArticlesByTitle($_POST["keyword"]);
                    
                    break;
                case 'name':
                    //処理
                    break;
            }
        }
    }

    public function ShowArticle($box){
        foreach($box as $article){ ?>
            <div class="row border-start border-end border-dark border-1 p-2">
                        <div class="col-7">
                            <h3><?php echo $article['title']?></h3>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $article['post_datetime']?></p>
                                <p><i class="fa-solid fa-thumbs-up me-1"></i>1234</p>
                            </div>
                            <div>
                                <div style="display:inline-block;">#ダイエット</div>
                                <div style="display:inline-block;">#筋トレ</div>
                                <div style="display:inline-block;">#胸</div>
                            </div>
                            <div class="row align-items-end" style="min-height: 10vmax;">
                                <div class="col-4">
                                    <img src="<?php
                                                // $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
                                                // if ($userpic) {  
                                                //     echo $userpic[0];
                                                // } else {
                                                    echo "./img/user_default.png";
                                                // }
                                                ?>" class="rounded-circle ratio ratio-1x1">
                                </div>
                                <div class="col-8">
                                    <div>
                                        <div><?php $name = $db -> getUserNameByUserId($article['user_id']);
                                            echo $name;
                                        ?></div>
                                        <div id="followButtonContainer">
                                            <?php
                                            // DBManagerクラスをインスタンス化
                                            $dbManager = new DBManager();
                                            $followingUserId = 1;
                                            // フォロー状態の判定と表示
                                            $isFollowing = $dbManager->isFollowingUser($userId, $followingUserId);
                                            if ($isFollowing) {
                                                echo '<button onclick="unfollowUser()">フォロー解除する</button>';
                                            } else {
                                                echo '<button onclick="followUser()">フォローする</button>';
                                            }
                                            ?>
                                        </div>
    
                                        <script>
                                            // フォローボタンをクリックした時の処理
                                            function followUser() {
                                                var followingUserId = "1";
    
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "./php/follow.php");
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
                                                        // ボタンの表示を切り替える
                                                        document.getElementById("followButtonContainer").innerHTML = '<button onclick="unfollowUser()">フォロー解除する</button>';
                                                    } else {
                                                        alert("フォローに失敗しました");
                                                    }
                                                };
                                                xhr.send("followingUserId=" + encodeURIComponent(followingUserId));
                                            }
    
                                            // アンフォローボタンをクリックした時の処理
                                            function unfollowUser() {
                                                var unfollowingUserId = "1";
    
                                                var xhr = new XMLHttpRequest();
                                                xhr.open("POST", "./php/unfollow.php");
                                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        alert(xhr.responseText); // レスポンスの表示（成功メッセージなど）
                                                        // ボタンの表示を切り替える
                                                        document.getElementById("followButtonContainer").innerHTML = '<button onclick="followUser()">フォローする</button>';
                                                    } else {
                                                        alert("フォロー解除に失敗しました");
                                                    }
                                                };
                                                xhr.send("unfollowingUserId=" + encodeURIComponent(unfollowingUserId));
                                            }
                                        </script>
    
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <img src="kawaii.jpg" class="w-100 h-100">
                        </div>
                    </div><?php
        }
    }
}

?>
