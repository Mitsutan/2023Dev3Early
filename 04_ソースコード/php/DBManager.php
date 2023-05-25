<?php
class DBManager
{
    private function connectDb()
        {
            $pdo = new PDO("mysql:host=localhost;dbname=mmemorial;charset=utf8", 'root', 'root');// 開発用
            return $pdo;
        }
}
