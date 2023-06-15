<?php
session_start();

// DBManager.php ファイルをインクルードします
require_once './DBManager.php';

// POST リクエストの処理を行います
try {
    $db->submitGoods($_SESSION['user_id'], $_POST['art']);
    $db->countGoods($_POST['art']);

    exit;
} catch (Exception $e) {
    // エラーが発生した場合の処理（例: エラーメッセージの表示）
    $_SESSION['errorMsg'] = $e->getMessage();
    header("Location: ../write.php");
}
?>

?>