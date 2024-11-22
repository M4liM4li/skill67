<?php
include_once "../db.php";

if(isset($_POST['acc'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='owner' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=owner");
};
if(isset($_POST['rem'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='po' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=owner");
};
if(isset($_POST['del'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='member' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=owner");
}
?>