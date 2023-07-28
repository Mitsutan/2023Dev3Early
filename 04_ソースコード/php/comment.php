<?php
header("Content-Type: application/json");
session_start();
require_once './DBManager.php';
$db = new DBManager();

$response = array();

try {
    // コメントが空白でないかチェック

    if(isset($_POST['comment'])) {
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
        

    } else {
        $come = $db->getCommentsByDetailId((int)$_GET['detailId']);
        $response['data'] = "";
        foreach ($come as $c) {
            $u = $db->getUser($c['user_id']);

            $response['data'] .= "<hr /><p class='h5'>" . $u['user_name'] . "</p><p>".nl2br($c['comment']) . "</p><p class='text-secondary'>".$c['post_datetime']."</p>";
        }
        $response['cnt'] = count($come);
        
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}
echo json_encode($response);

?>
