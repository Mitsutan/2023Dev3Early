<?php
require_once "./DBManager.php";
$db = new DBManager;

// echo print_r($_POST);
if ($_POST["articleId"] == "") {
    $id = 0;
} else {
    $id = $_POST["articleId"];
}
echo count($db->getDetailsByArticleId($id));
?>
