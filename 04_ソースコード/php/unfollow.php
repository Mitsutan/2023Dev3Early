<?php
session_start();
// DBManagerクラスを使用できるようにします
require_once 'DBManager.php';

// フォローユーザーのIDを取得
$unfollowingUserId = $_POST['unfollowingUserId'];

// 自分のユーザーIDを設定（例えば、セッションから取得するなど）
$userId = $_SESSION['user_id']; // 自分のユーザーIDを設定してください

// DBManagerのインスタンスを作成
$dbManager = new DBManager();

try {
  // フォローユーザーを解除
  $dbManager->unfollowUser($userId, $unfollowingUserId);

  // フォロー解除成功の処理
  echo "フォローを解除しました";
} catch (Exception $e) {
  // フォロー解除失敗の処理
  http_response_code(500);
  echo "フォロー解除に失敗しました";
}
