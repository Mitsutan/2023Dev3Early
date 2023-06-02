<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager;

try {
    $db->submitArticle($_SESSION['user_id'], $_POST['title'], $_POST['overview'], $_POST['content']);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
