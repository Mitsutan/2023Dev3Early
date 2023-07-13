<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager;

try {
    if ($_SESSION['edit-type'] == 1) {
        $db->updateDetail($_POST['id'], $_POST['content']);
        header("Location: ../detail.php?id=" . $_POST['id']);
    } else {
        $db->updateArticle($_POST['id'], $_POST['title'], $_POST['overview'], $_POST['tags']);
        header("Location: ../article.php?id=" . $_POST['id']);
    }
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    unset($_SESSION['edit-type']);
}
