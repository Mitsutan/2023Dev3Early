<?php

session_start();

require_once "./DBManager.php";
$db = new DBManager;

unset($_SESSION['errorMsg']);
try {
    $db->editUser($_SESSION['user_id'], $_POST['mail'], $_POST['name'], $_POST['desc']);
} catch (Exception $e) {
    $_SESSION['errorMsg'] = $e->getMessage();
}

header("Location: ../mypage.php");

?>
