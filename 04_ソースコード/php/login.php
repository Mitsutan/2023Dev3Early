<?php

session_start();

//データベースマネージャーの読み込み
require_once "./DBManager.php";
$db = new DBManager;

//フォーム情報取得
$mail = $_POST['mail'];
$pass = $_POST['pass'];

try {
    //ログイン処理
    $user = $db->loginUser($mail, $pass);

    //ログイン成功時
    //どうするかわからないので何も書いてません
    
} catch (LogicException $e) {
    // パスワードが間違っている場合のエラーメッセージを表示
    echo "パスワードが違います。";
} catch (BadMethodCallException $e) {
    // メールアドレスが存在しない場合のエラーメッセージを表示
    echo "メールアドレスが存在しません。";
}
?>