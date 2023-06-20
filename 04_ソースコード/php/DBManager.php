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

    function submitDetail(int $articleId, string $detail) {
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
    public function updateArticle(int $articleId, string $title, string $detailText)
    {
        $currentTime = date('Y-m-d H:i:s');

        // 記事の更新
        $ps = $this->connectDb()->prepare("UPDATE articles SET title = ?, update_datetime = ? WHERE article_id = ?");
        $ps->bindValue(1, $title, PDO::PARAM_STR);
        $ps->bindValue(2, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(3, $articleId, PDO::PARAM_INT);

        if (!$ps->execute()) {
            throw new Exception("記事の更新に失敗しました。");
        }

        // 記事詳細の更新
        $ps = $this->connectDb()->prepare("UPDATE details SET detail_text = ?, detail_updateday = ? WHERE article_id = ?");
        $ps->bindValue(1, $detailText, PDO::PARAM_STR);
        $ps->bindValue(2, $currentTime, PDO::PARAM_STR);
        $ps->bindValue(3, $articleId, PDO::PARAM_INT);

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

    // ユーザーIDから記事を全件取得するメソッド
    public function getArticlesByUserId(int $userId)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM articles WHERE user_id = ?");
        $ps->bindValue(1, $userId, PDO::PARAM_INT);
        $ps->execute();

        $articles = $ps->fetchAll();

        return $articles;
    }

    // 記事名から記事を検索するメソッド
    public function getArticlesByTitle(string $title)
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM articles WHERE title LIKE ?");
        $ps->bindValue(1, "%$title%", PDO::PARAM_STR);
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
    
    //いいねボタン押下情報の登録と削除
    public function submitGoods(int $user, int $article)
    {
        $look = $this->connectDb()->prepare("SELECT * FROM goods WHERE user_id = ? AND article_id = ?");
        $look->bindValue(1, $user, pdo::PARAM_INT);
        $look->bindValue(2, $article, pdo::PARAM_INT);
        $look->execute();
        $result = $look->fetchColumn();
        if($result > 0) {
            $delete = $this->connectDb()->prepare("DELETE FROM goods WHERE user_id = ? AND article_id = ?");
            $delete->bindValue(1, $user, pdo::PARAM_INT);
            $delete->bindValue(2, $article, pdo::PARAM_INT);
            $delete->execute();

        }else {
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

    
}
