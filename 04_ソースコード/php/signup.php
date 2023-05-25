<?php
session_start();

// DBManager.php ファイルをインクルードします
require_once './php/DBManager.php';

// POST リクエストの処理を行います
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力された情報を取得します
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];

    // DBManager オブジェクトを作成します
    $dbManager = new DBManager();

    try {
        // ユーザーを登録します
        $dbManager->submitUser('', $pass, $mail); // ユーザー名は空文字列としていますが、適宜修正してください

        // 登録成功時の処理（例: ログイン画面にリダイレクト）
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        // エラーが発生した場合の処理（例: エラーメッセージの表示）
        $errorMessage = $e->getMessage();
    }
}
?>