<?php
session_start();

// DBManager.php ファイルをインクルードします
require_once './DBManager.php';

// DBManagerのインスタンスを作成
$db = new DBManager();

// 自分のユーザーIDを設定（例えば、セッションから取得するなど）
$userId = $_SESSION['user_id']; // 自分のユーザーIDを設定してください
$articleId = $_POST['articleNum'];

// POST リクエストの処理を行います
try {
    echo $db->submitGoods($userId, $articleId);

    exit;
} catch (Exception $e) {
    // エラーが発生した場合の処理（例: エラーメッセージの表示）
    $_SESSION['errorMsg'] = $e->getMessage();
    header("Location: ../write.php");
}
?>

?>