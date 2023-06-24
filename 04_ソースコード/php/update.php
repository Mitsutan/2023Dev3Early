<?php
session_start();

require_once "./DBManager.php";
$db = new DBManager;

try {
    $db->updateArticle($_POST['id'], $_POST['title'], $_POST['overview'], $_POST['tags']);
} catch (Exception $e) {
    
}
?>
