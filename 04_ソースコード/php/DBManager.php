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
    public function submitArticle(int $userId, string $title, string $overview, string $detail)
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

           mkdir("../img/article/".$articleId);
        
             move_uploaded_file($_FILES['file']['tmp_name'], "../img/article/".$articleId."/article".$_FILES['file']['name']);
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

    if ($article) {
        $ps = $this->connectDb()->prepare("SELECT * FROM details WHERE article_id = ?");
        $ps->bindValue(1, $articleId, PDO::PARAM_INT);
        $ps->execute();

        $details = $ps->fetchAll(PDO::FETCH_ASSOC);
        $article['details'] = $details;
    }

    return $article;
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

    // -----

    // tags 取得---
    public function getTags()
    {
        $ps = $this->connectDb()->prepare("SELECT * FROM tags");
        $ps->execute();

        return $ps->fetchAll();
    }
    // -----

}



