<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = $_POST["mail"];
    $introduce = $_POST["Introduce"];
    $name = $_POST["name"];

    // プロフィール画像のアップロード処理
    if ($_FILES["avatar"]["name"]) {
        mkdir("../img/userpics/".$_SESSION["user_id"]);
        $avatar = "userpic".$_FILES["avatar"]["name"];
        $avatarPath = "../img/userpics/".$_SESSION["user_id"]."/".$avatar;
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatarPath);
    } else {
        $avatar = ""; // もし画像がアップロードされていない場合は、空の値を設定する
    }

    // データベースの更新処理
    $db->editUser($_SESSION["user_id"], $mail,$name, $introduce);
}

// $userData = $db->getUser($_SESSION["user_id"]);

header("Location: ../mypage.php");
?>
