<?php
session_start();

// DBManager.php ファイルをインクルードします
require_once './DBManager.php';

// POST リクエストの処理を行います
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力された情報を取得します
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];

    // DBManager オブジェクトを作成します
    $dbManager = new DBManager();

    unset($_SESSION['errorMsg']);
    try {
        //パスワードｎの条件チェック
        if($dbManager->checkPass($pass)){
            // ユーザーを登録します
            $dbManager->submitUser($name, $pass, $mail); // ユーザー名は空文字列としていますが、適宜修正してください

            // 登録成功時の処理（例: ログイン画面にリダイレクト）
            header('Location: ../welcome.php');
            exit;
        } else {
            // throw new Exception('パスワードは半角英数字、6文字以上の入力が必要です。');
            $_SESSION['errorMsg'] .= 'パスワードは半角英数字、6文字以上の入力が必要です。';
        }
    } catch (Exception $e) {
        // エラーが発生した場合の処理（例: エラーメッセージの表示）
        if ($e->getCode() == 23000) {
            $_SESSION['errorMsg'] .= 'このメールアドレスは既に登録されています。';
        } else {
            $_SESSION['errorMsg'] .= $e->getMessage();
        }
    } finally {
        // セッションにエラーメッセージが設定されている場合は、サインアップ画面にリダイレクトします
        if (isset($_SESSION['errorMsg'])) {
            header('Location: ../signup.php');
            exit;
        }
    }
}
?>
