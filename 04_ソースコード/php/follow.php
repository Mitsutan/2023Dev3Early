<?php
// DBManagerクラスを使用できるようにします
session_start();
require_once 'DBManager.php';

// フォローユーザーのIDを取得
$followingUserId = $_POST['followingUserId'];

// 自分のユーザーIDを設定（例えば、セッションから取得するなど）
$userId = $_SESSION['user_id']; // 自分のユーザーIDを設定してください

// DBManagerのインスタンスを作成
$dbManager = new DBManager();

try {
  // フォローユーザーを追加
  $dbManager->followUser($userId, $followingUserId);

  // フォロー成功の処理
  echo "フォローしました";
} catch (Exception $e) {
  // フォロー失敗の処理
  http_response_code(500);
  echo $e->getMessage();
  echo "フォローに失敗しました";
}
