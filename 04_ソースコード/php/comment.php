<?php
header("Content-Type: application/json");
session_start();
require_once './DBManager.php';
$db = new DBManager();

$response = array();

try {
    // コメントが空白でないかチェック

    if (empty(trim($_POST['comment']))) {
        $response['success'] = false;
      $response['message'] = 'コメントを入力してください。';
    } else {
        $result = $db->submitComment($_SESSION['user_id'], (int)$_POST['detailId'], $_POST['comment']);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'コメントが投稿されました';
        } else {
            $response['success'] = false;
            $response['message'] = 'コメントの投稿に失敗しました';
        }
    }    

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
