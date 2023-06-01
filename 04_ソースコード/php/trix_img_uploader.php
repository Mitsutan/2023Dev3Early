<?php
session_start();

if (is_uploaded_file($_FILES['file']['tmp_name'])) {

    mkdir("../img/article/".$_SESSION["user_id"]);

    move_uploaded_file($_FILES['file']['tmp_name'], "../img/article/".$_SESSION["user_id"]."/".$_FILES['file']['name']);
}
?>
