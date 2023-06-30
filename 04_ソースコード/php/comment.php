<?php

session_start();
require_once './DBManager.php';
$db = new DBManager();

try {
    // header("Content-Type: application/json; charset=UTF-8");
    // echo json_encode($db->submitComment($_SESSION['user_id'], $_POST['detailId'], $_POST['comment']));
    $db->submitComment($_SESSION['user_id'], (int)$_POST['detailId'], $_POST['comment']);
    header("Location: ../detail?id=" . $_POST['detailId']);

    exit;
} catch (Exception $e) {
    // エラーが発生した場合の処理（例: エラーメッセージの表示）
    // $_SESSION['errorMsg'] = $e->getMessage();
    // header("Location: ../write.php");
    echo $e->getMessage();
}
?>
