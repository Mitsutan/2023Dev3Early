<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = $_POST["mail"];
    $introduce = $_POST["Introduce"];

    // プロフィール画像のアップロード処理
    if ($_FILES["avatar"]["name"]) {
        $avatar = $_FILES["avatar"]["name"];
        $avatarPath = "./avatars/" . $avatar;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatarPath);
    } else {
        $avatar = ""; // もし画像がアップロードされていない場合は、空の値を設定する
    }

    // データベースの更新処理
    $db->editUser($_SESSION["user_id"], $mail, $introduce, $avatar);
}

$userData = $db->getUser($_SESSION["user_id"]);
?>
