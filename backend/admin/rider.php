<?php
include_once "../db.php";

if(isset($_POST['acc'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='rider' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=rider");
};
if(isset($_POST['rem'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='pr' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=rider");
};
if(isset($_POST['del'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='member' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=rider");
}
?>