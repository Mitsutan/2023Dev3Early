<?php
session_start();

// DBManager.php ファイルをインクルードします
require_once './DBManager.php';

// POST リクエストの処理を行います
try {
    $db->submitGoods($_SESSION['user_id'], $_POST['art']);
    
    // 登録成功時の処理
    header('Location: ../mypage.php');
    exit;
} catch (Exception $e) {
    // エラーが発生した場合の処理（例: エラーメッセージの表示）
    $_SESSION['errorMsg'] = $e->getMessage();
    header("Location: ../write.php");
}
?>

?>