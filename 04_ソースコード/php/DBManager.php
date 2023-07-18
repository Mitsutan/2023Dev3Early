<?php
class DBManager
{
    private function connectDb()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=mmemorial;charset=utf8", 'root', 'root'); // 開発用
        return $pdo;
    }

    // user crud関連 ---
    public function submitUser(string $name, string $pass, string $mail)
    {
        $ps = $this->connectDb()->prepare("INSERT INTO users(user_name,user_password,user_mail,user_pic,user_signup_date_time,user_about_me) VALUES (?,?,?,?,?,?)");
        $ps->bindValue(1, $name, pdo::PARAM_STR);
        $ps->bindValue(2, password_hash($pass, PASSWORD_DEFAULT), pdo::PARAM_STR);
        $ps->bindValue(3, $mail, pdo::PARAM_STR);
        $ps->bindValue(4, null, pdo::PARAM_STR);
        $ps->bindValue(5, date('Y-m-d H:i:s'), pdo::PARAM_STR);
        $ps->bindValue(6, null, pdo::PARAM_STR);

        if (!$ps->execute()) {
            throw new Exception("原因不明のエラーが発生しました。<br />しばらく時間をおいて再度お試しください。", 100);
        }
    }

    public function loginUser(string $mail, string $pass)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM users WHERE user_mail = ?");
        $ps->bindValue(1, $mail, pdo::PARAM_STR);
        $ps->execute();

        $data = $ps->fetch();
        if ($data != false) {
            if (password_verify($pass, $data["user_password"])) {
                return $data;
            } else {
                throw new LogicException("パスワードが違います");
            }
        } else {
            throw new BadMethodCallException("メールアドレスが存在しません");
        }
    }

    public function getUser(int $id)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM users WHERE user_id = ?");
        $ps->bindValue(1, $id, pdo::PARAM_INT);
        $ps->execute();

        return $ps->fetch();
    }

    // ユーザー名からuseridを取得するメソッド
    public function getUserIds(string $name)
    {
        $ps = $this->connectDb()->prepare("SELECT user_id FROM users WHERE user_name LIKE ?");
        $ps->bindValue(1, "%$name%", pdo::PARAM_STR);
        $ps->execute();

        return $ps->fetchAll();
    }

    public function editUser(int $id, string $mail, string $name, string $desc)
    {
        $ps = $this->connectDb()->prepare("UPDATE users SET user_mail = ?, user_name = ?, user_about_me = ? WHERE user_id = ?");
        $ps->bindValue(1, $mail, pdo::PARAM_STR);
        $ps->bindValue(2, $name, pdo::PARAM_STR);
        $ps->bindValue(3, $desc, pdo::PARAM_STR);
        $ps->bindValue(4, $id, pdo::PARAM_INT);
        if (!$ps->execute()) {
            throw new Exception("原因不明のエラーが発生しました。<br />しばらく時間をおいて再度お試しください。", 100);
        }
    }
    // user crud関連ここまで ---

    // follow crud関連 ---

    public function followUser(int $userId, int $followingUserId) //followUser: ユーザーが別のユーザーをフォローするためのメソッド。
    {

        if ($userId == $followingUserId) {
            throw new Exception("自分自身をフォローすることはできません。");
        }

        $ps = $this->connectDb()->prepare("INSERT INTO follows(user_id, following_user_id, follow_datetime) VALUES (?, ?, ?)");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->bindValue(2, $followingUserId, PDO::PARAM_INT);
        $ps->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);

        if (!$ps->execute()) {
            throw new Exception("フォローに失敗しました。");
        }
    }

    public function unfollowUser(int $userId, int $followingUserId) //unfollowUser: ユーザーがフォローしているユーザーをアンフォローするためのメソッド。
    {
        $ps = $this->connectDb()->prepare("DELETE FROM follows WHERE user_id = ? AND following_user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->bindValue(2, $followingUserId, PDO::PARAM_INT);

        if (!$ps->execute()) {
            throw new Exception("アンフォローに失敗しました。");
        }
    }

    public function isFollowingUser(int $userId, int $followingUserId) //isFollowingUser: ユーザーが特定のユーザーをフォローしているかどうかを判定するためのメソッドで
    {
        $ps = $this->connectDb()->prepare("SELECT COUNT(*) FROM follows WHERE user_id = ? AND following_user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->bindValue(2, $followingUserId, PDO::PARAM_INT);
        $ps->execute();

        $count = $ps->fetchColumn();
        return ($count > 0);
    }

    public function getFollowersCount(int $userId) //getFollowersCount: ユーザーがフォローされているユーザー数を取得するためのメソッドです。
    {
        $ps = $this->connectDb()->prepare("SELECT COUNT(*) FROM follows WHERE following_user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();

        $count = $ps->fetchColumn();
        return $count;
    }

    public function getFollowingCount(int $userId) //getFollowingCount: ユーザーがフォローしているユーザー数を取得するためのメソッドです。
    {
        $ps = $this->connectDb()->prepare("SELECT COUNT(*) FROM follows WHERE user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();

        $count = $ps->fetchColumn();
        return $count;
    }
    // follow crud関連ここまで ---

    //新規記事投稿処理　林田作
    public function submitArticle(int $userId, string $title, string $overview, string $detail, $tagIds)
    {
        $currentTime = date('Y-m-d H:i:s'); //現在の日時を取得

        // 記事の投稿
        $pdo = $this->connectDb();
        $ps = $pdo->prepare("INSERT INTO articles(user_id, title, article_description, post_datetime, update_datetime) VALUES (?, ?, ?, ?, ?)");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->bindValue(2, $title, PDO::PARAM_STR);
        $ps->bindValue(3, $overview, PDO::PARAM_STR);
        $ps->bindValue(4, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(5, $currentTime, PDO::PARAM_STR);

        if (!$ps->execute()) {
            throw new Exception("記事の投稿に失敗しました。");
        }

        $articleId = $pdo->lastInsertId(); // 追加された記事のIDを取得

        if (is_uploaded_file($_FILES['topimg']['tmp_name'])) {

            mkdir("../img/article/" . $articleId);

            move_uploaded_file($_FILES['topimg']['tmp_name'], "../img/article/" . $articleId . "/topimage" . $_FILES['topimg']['name']);
        }

        // タグ付与
        foreach ($tagIds as $key) {
            $ps = $this->connectDb()->prepare("INSERT INTO usedtags(article_id, tag_id) VALUES (?, ?)");
            $ps->bindValue(1, $articleId, PDO::PARAM_INT);
            $ps->bindValue(2, $key, PDO::PARAM_STR);

            if (!$ps->execute()) {
                // エラー処理（タグ付与に失敗した場合）
                throw new Exception("タグ付与に失敗しました。");
            }
        }

        // 記事詳細の追加
        $ps = $this->connectDb()->prepare("INSERT INTO details(article_id, detail_submitday, detail_updateday, detail_text) VALUES (?, ?, ?, ?)");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->bindValue(2, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(3, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(4, $detail, PDO::PARAM_STR);

        if (!$ps->execute()) {
            // エラー処理（記事の詳細の追加に失敗した場合）
            throw new Exception("記事の詳細の追加に失敗しました。");
        }

        if (!empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

            mkdir("../img/article/" . $articleId);

            move_uploaded_file($_FILES['file']['tmp_name'], "../img/article/" . $articleId . "/article" . $_FILES['file']['name']);
        }
    }

    function submitDetail(int $articleId, string $detail)
    {
        // 記事詳細の追加
        $ps = $this->connectDb()->prepare("INSERT INTO details(article_id, detail_submitday, detail_updateday, detail_text) VALUES (?, ?, ?, ?)");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->bindValue(2, date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $ps->bindValue(3, date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $ps->bindValue(4, $detail, PDO::PARAM_STR);

        if (!$ps->execute()) {
            // エラー処理（記事の詳細の追加に失敗した場合）
            throw new Exception("記事の詳細の追加に失敗しました。");
        }
    }

    //記事更新処理　林田作
    public function updateArticle(int $articleId, string $title, string $desc, array $tagIds)
    {
        $currentTime = date('Y-m-d H:i:s');

        // 記事の更新
        $ps = $this->connectDb()->prepare("UPDATE articles SET title = ?, article_description = ?, update_datetime = ? WHERE article_id = ?");
        $ps->bindValue(1, $title, PDO::PARAM_STR);
        $ps->bindValue(2, $desc, PDO::PARAM_STR);
        $ps->bindValue(3, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(4, $articleId, PDO::PARAM_INT);

        if (!$ps->execute()) {
            throw new Exception("記事の更新に失敗しました。");
        }

        if (is_uploaded_file($_FILES['topimg']['tmp_name'])) {

            if (file_exists("../img/article/" . $articleId)) {
                array_map('unlink', glob("../img/article/" . $articleId . "/*.*"));
            } else {
                mkdir("../img/article/" . $articleId);
            }

            move_uploaded_file($_FILES['topimg']['tmp_name'], "../img/article/" . $articleId . "/topimage" . $_FILES['topimg']['name']);
        }

        // タグ全削除
        $ps = $this->connectDb()->prepare("DELETE FROM usedtags WHERE article_id = ?");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->execute();

        // タグ付与
        foreach ($tagIds as $key) {
            $ps = $this->connectDb()->prepare("INSERT INTO usedtags(article_id, tag_id) VALUES (?, ?)");
            $ps->bindValue(1, $articleId, PDO::PARAM_INT);
            $ps->bindValue(2, $key, PDO::PARAM_STR);

            if (!$ps->execute()) {
                // エラー処理（タグ付与に失敗した場合）
                throw new Exception("タグ付与に失敗しました。");
            }
        }
    }

    // 記事詳細更新処理
    public function updateDetail(int $detailid, string $detailText)
    {
        $currentTime = date('Y-m-d H:i:s');

        // 記事詳細の更新
        $ps = $this->connectDb()->prepare("UPDATE details SET detail_text = ?, detail_updateday = ? WHERE detail_id = ?");
        $ps->bindValue(1, $detailText, PDO::PARAM_STR);
        $ps->bindValue(2, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(3, $detailid, PDO::PARAM_INT);

        if (!$ps->execute()) {
            throw new Exception("記事の詳細の更新に失敗しました。");
        }
    }
    //記事取得処理
    // 記事を一件取得するメソッド
    public function getArticleById(int $articleId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM articles WHERE article_id = ?");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->execute();

        $article = $ps->fetch(PDO::FETCH_ASSOC);

        // いったんコメントアウト
        // if ($article) {
        //     $ps = $this->connectDb()->prepare("SELECT * FROM details WHERE article_id = ?");
        //     $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        //     $ps->execute();

        //     $details = $ps->fetchAll(PDO::FETCH_ASSOC);
        //     $article['details'] = $details;
        // }

        return $article;
    }

    // 記事詳細全件取得
    public function getDetailsByArticleId(int $articleId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM details WHERE article_id = ?");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->execute();

        $details = $ps->fetchAll(PDO::FETCH_ASSOC);

        return $details;
    }

    // 記事詳細を一件取得するメソッド
    public function getDetailById(int $detailId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM details WHERE detail_id = ?");
        $ps->bindValue(1, $detailId, PDO::PARAM_INT);
        $ps->execute();

        $detail = $ps->fetch(PDO::FETCH_ASSOC);

        return $detail;
    }
    //記事をすべて取得するメソッド
    public function getAllArticles()
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM articles ");
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }
    
    public function deleteArticle($articleId) {
        // 記事を削除するためのSQL文を準備
        $sql = "DELETE FROM articles WHERE article_id = :article_id";

        // SQL文をプリペアードステートメントとして準備
        $ps= $this->connectDb()->prepare($sql);

        // パラメータをバインド
        $ps->bindValue(':article_id', $articleId, PDO::PARAM_INT);

        // SQL文を実行
        $ps->execute();
    }

    // いいね数順に記事idを取得するメソッド
    public function getArticleIdsOrderByGoods()
    {
        $ps = $this->connectDb()->prepare("SELECT article_id FROM goods GROUP BY article_id ORDER BY COUNT(*) DESC");
        $ps->execute();

        $articleIds = $ps->fetchAll();

        return $articleIds;
    }


    // 記事を更新日時順に全件取得するメソッド
    public function getAllArticlesOrderByUpdate(int $index, int $lastIndex)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM articles ORDER BY update_datetime DESC LIMIT ?, ?");
        $ps->bindValue(1, $index, PDO::PARAM_INT);
        $ps->bindValue(2, $lastIndex, PDO::PARAM_INT);
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }

    // ユーザーIDから記事を全件取得するメソッド
    public function getArticlesByUserId(int $userId)
    {
        $ps = $this->connectDb()->prepare("SELECT a.*, COUNT(g.article_id) AS good FROM articles AS a LEFT OUTER JOIN goods AS g ON a.article_id = g.article_id WHERE a.user_id = ? GROUP BY a.article_id");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }

    // 記事名から記事を検索するメソッド
    public function getArticlesByTitle(string $title)
    {
        $ps = $this->connectDb()->prepare("SELECT a.*, COUNT(g.article_id) AS good FROM articles AS a LEFT OUTER JOIN goods AS g ON a.article_id = g.article_id WHERE title LIKE ? GROUP BY a.article_id");
        $ps->bindValue(1, "%$title%", PDO::PARAM_STR);
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }

    // タグidから記事を検索するメソッド
    public function getArticlesByTagId(int $tagId)
    {
        $ps = $this->connectDb()->prepare("SELECT a.*,COUNT(g.article_id) AS good FROM articles AS a LEFT OUTER JOIN usedtags AS ut ON a.article_id = ut.article_id LEFT OUTER JOIN goods AS g ON a.article_id = g.article_id WHERE ut.tag_id = ? GROUP BY a.article_id");
        $ps->bindValue(1, $tagId, PDO::PARAM_INT);
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }

    // -----

    // tags 取得---
    public function getTags()
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM tags");
        $ps->execute();

        return $ps->fetchAll();
    }

    // tag_idからタグを取得するメソッド
    public function getTagById(int $tagId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM tags WHERE tag_id = ?");
        $ps->bindValue(1, $tagId, PDO::PARAM_INT);
        $ps->execute();

        return $ps->fetch();
    }

    // タグ名からタグを検索するメソッド
    public function getTagsByName(string $tagName)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM tags WHERE tag_name LIKE ?");
        $ps->bindValue(1, "%$tagName%", PDO::PARAM_STR);
        $ps->execute();

        return $ps->fetchAll();
    }

    // タグ利用数
    public function getTagCount(int $tagId)
    {
        $ps = $this->connectDb()->prepare("SELECT COUNT(*) FROM usedtags WHERE tag_id = ?");
        $ps->bindValue(1, $tagId, PDO::PARAM_INT);
        $ps->execute();

        return $ps->fetchColumn();
    }

    // article_idから使用タグのタグ名を取得するメソッド
    public function getTagsByArticleId(int $articleId)
    {
        $ps = $this->connectDb()->prepare("SELECT t.tag_name FROM usedtags AS ut LEFT OUTER JOIN tags AS t ON ut.tag_id = t.tag_id WHERE article_id = ?");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->execute();

        $tags = $ps->fetchAll();

        return $tags;
    }
    // -----

    // コメント関連 ---
    // コメント投稿
    public function submitComment(int $userId, int $detailId, string $commentText)
    {
        $currentTime = date('Y-m-d H:i:s');

        $ps = $this->connectDb()->prepare("INSERT INTO comments(user_id, detail_id, comment, post_datetime) VALUES (?, ?, ?, ?)");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->bindValue(2, $detailId, PDO::PARAM_INT);
        $ps->bindValue(3, $commentText, PDO::PARAM_STR);
        $ps->bindValue(4, $currentTime, PDO::PARAM_STR);

        if (!$ps->execute()) {
            return ['status' => false, 'message' => 'コメントの投稿に失敗しました。'];
            // throw new Exception("コメントの投稿に失敗しました。");
        } else {
            return ['status' => true, 'message' => 'コメントの投稿に成功しました。'];
        }
    }

    // コメント取得
    public function getCommentsByDetailId(int $detailId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM comments WHERE detail_id = ?");
        $ps->bindValue(1, $detailId, PDO::PARAM_INT);
        $ps->execute();

        $comments = $ps->fetchAll();

        return $comments;
    }
    // ----

    // goods crud関連 今泉---

    //いいね数表示のメソッド
    public function countGoods(int $article)
    {
        $ps = $this->connectDb()->prepare("SELECT COUNT(*) AS count FROM goods WHERE article_id = ?");

        $ps->bindValue(1, $article, PDO::PARAM_INT);
        $ps->execute();
        $cnt = $ps->fetchColumn();

        return $cnt;
    }

    //いいねボタン押下情報の登録と削除メソッド
    public function submitGoods(int $user, int $article)
    {
        $look = $this->connectDb()->prepare("SELECT * FROM goods WHERE user_id = ? AND article_id = ?");
        $look->bindValue(1, $user, pdo::PARAM_INT);
        $look->bindValue(2, $article, pdo::PARAM_INT);
        $look->execute();
        $result = $look->fetchColumn();
        if ($result > 0) {
            $delete = $this->connectDb()->prepare("DELETE FROM goods WHERE user_id = ? AND article_id = ?");
            $delete->bindValue(1, $user, pdo::PARAM_INT);
            $delete->bindValue(2, $article, pdo::PARAM_INT);
            $delete->execute();
        } else {
            $ps = $this->connectDb()->prepare("INSERT INTO goods(user_id,article_id,good_datetime) VALUES (?,?,?)");
            $ps->bindValue(1, $user, pdo::PARAM_INT);
            $ps->bindValue(2, $article, pdo::PARAM_INT);
            $ps->bindValue(3, date('Y-m-d H:i:s'), pdo::PARAM_STR);
            if (!$ps->execute()) {
                throw new Exception("原因不明のエラーが発生しました。<br />しばらく時間をおいて再度お試しください。", 100);
            }
        }

        return [
            "count" => $this->countGoods($article),
            "result" => $result > 0 ? false : true
        ];
    }

    //いいねボタンの押下状態を指定するメソッド
    public function isGoodsIconArticle(int $user, int $article)
    {
        $look = $this->connectDb()->prepare("SELECT * FROM goods WHERE user_id = ? AND article_id = ?");
        $look->bindValue(1, $user, pdo::PARAM_INT);
        $look->bindValue(2, $article, pdo::PARAM_INT);
        $look->execute();
        $result = $look->fetchColumn();
        return ($result > 0);
    }

    //いいね記事の全件表示
    public function getArticlesByGoods(int $userId)
    {
        $ps = $this->connectDb()->prepare("SELECT article_id FROM goods WHERE user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();
        return $ps->fetchAll();

        // 結果を配列に保存
        // $articleIds = [];
        // while ($row = $ps->fetch(PDO::FETCH_COLUMN)) {
        //     $articleIds[] = $row;
        // }

        // $placeholders = implode(',', array_fill(0, count($articleIds), '?'));
        // $stmt =  $this->connectDb()->prepare("SELECT * FROM articles WHERE article_id IN ($placeholders)");
        // foreach ($articleIds as $index => $articleId) {
        //     $stmt->bindValue($index + 1, $articleId, PDO::PARAM_INT);
        // }
        // $stmt->execute();
        // $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // return $articles;
    }

    //人気記事選出　数値の多い順（人気順)に4件取得
    public function getPopularArtcles(int $index, int $lastIndex)
    {
        $ps = $this->connectDb()->prepare("SELECT T1.article_id, user_id, title, post_datetime, update_datetime,
                                            POWER(T2.count / (1 + 0.1 * TIMESTAMPDIFF(DAY, T1.post_datetime, CURRENT_TIMESTAMP())) * (1 + 0.01 * TIMESTAMPDIFF(DAY, T1.post_datetime, CURRENT_TIMESTAMP())), 1.8) AS popular
                                            FROM articles AS T1
                                            LEFT OUTER JOIN (SELECT article_id, COUNT(*) AS count FROM goods GROUP BY article_id) AS T2
                                            ON T1.article_id = T2.article_id
                                            ORDER BY popular * POWER(1.5, -TIMESTAMPDIFF(WEEK, T1.post_datetime, CURRENT_TIMESTAMP())) DESC
                                            LIMIT ?,?;");

        $ps->bindValue(1, $index, PDO::PARAM_INT);
        $ps->bindValue(2, $lastIndex, PDO::PARAM_INT);

        $ps->execute();
        return $ps->fetchAll();
    }

    //フォローしているユーザー検索
    // public function getFollowUserid(int $userid)
    // {
    //     $ps = $this->connectDb()->prepare("SELECT * FROM follows WHERE user_id = ?");
    //     $ps->bindValue(1, $userid, PDO::PARAM_INT);
    //     $ps->execute();

    //     $articles = $ps->fetchAll();

    //     return $articles;
    // }
    //フォローしているユーザーの記事表示
    // public function getFollowArticles(int $followinguserid)
    // {
    //     $ps = $this->connectDb()->prepare("SELECT * FROM articles WHERE user_id = ?");
    //     $ps->bindValue(1, $followinguserid, PDO::PARAM_INT);
    //     $ps->execute();

    //     $article = $ps->fetchAll();

    //     return $article;
    // }

    public function getFollowArticles(int $userId, int $index, int $count)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM follows WHERE user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();

        $followUsers = $ps->fetchAll();
        // ---
        $ids = array_column($followUsers, 'following_user_id');
        if (count($ids) === 0) {
            return [];
        }
        $stmt = $this->connectDb()->prepare("SELECT * FROM articles WHERE user_id IN (" . implode(',', array_fill(0, count($ids), '?')) . ") ORDER BY update_datetime DESC LIMIT ?, ?;");
        foreach ($ids as $i => $id) {
            $stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
        }
        $stmt->bindValue(count($ids) + 1, $index, PDO::PARAM_INT);
        $stmt->bindValue(count($ids) + 2, $count, PDO::PARAM_INT);

        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    //パスワードの半角英数字確認
    public function checkPass($pass)
    {
        if (preg_match('/^[a-zA-Z0-9]{6,}$/', $pass)) {
            return true;
        } else {
            return false;
        }
    }
}
