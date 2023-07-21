<?php
session_start();
    require_once "DBManager.php";
    $db = new DBManager;

if (isset($_POST['delete'])) {
    // 削除の処理を実行する
    $articleId = $_POST['id'];
    // 記事の削除を呼び出し
    $db->deleteDetail($detailId);
    $db->deleteArticle($articleId);
    // 削除後のリダイレクトまたはメッセージ表示などの処理を実装
    // ...
    // 削除後のリダイレクト例:
    header("Location: ../index.php");
    exit();
    
}
?>
