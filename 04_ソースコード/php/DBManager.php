<?php
class DBManager
{
    private function connectDb()
    {
        $pdo = new PDO("mysql:host=localhost;dbname=mmemorial;charset=utf8", 'root', 'root'); // 開発用
        return $pdo;
    }

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
}
