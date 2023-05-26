<?php
require_once "DBManager.php";

// プロフィール情報を取得
$dbManager = new DBManager();
$userId = 1; // ユーザーIDを適切な値に置き換える
$followersCount = $dbManager->getFollowersCount($userId);
$followingCount = $dbManager->getFollowingCount($userId);

// 投稿記事一覧を取得
$articleList = []; // 投稿記事のデータを格納する配列
// 投稿記事のデータをDBから取得し、$articleListに追加する処理を実装

// 応答データを生成
$response = [
    "followersCount" => $followersCount,
    "followingCount" => $followingCount,
    "articleList" => $articleList
];

// JSON形式で応答
header("Content-Type: application/json");
echo json_encode($response);
?>