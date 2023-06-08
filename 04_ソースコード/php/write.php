<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager;

try {
    $db->submitArticle($_SESSION['user_id'], $_POST['title'], $_POST['overview'], $_POST['content'], $_POST['tags']);

    // 登録成功時の処理
    header('Location: ../mypage.php');
    exit;
} catch (Exception $e) {
    // エラーが発生した場合の処理（例: エラーメッセージの表示）
    $_SESSION['errorMsg'] = $e->getMessage();
    header("Location: ../write.php");
}
?>
