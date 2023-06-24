<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager;

try {
    if ($_SESSION['edit-type'] == 1) {
        $db->updateDetail($_POST['id'], $_POST['content']);
    } else {
        $db->updateArticle($_POST['id'], $_POST['title'], $_POST['overview'], $_POST['tags']);
    }
} catch (Exception $e) {
    
} finally {
    unset($_SESSION['edit-type']);
    header("Location: ../detail.php?id=" . $_POST['id']);
}
?>
