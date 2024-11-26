<?php
include_once "../db.php";
if(isset($_POST['add'])){
    $name = $_POST['typename'];
    if($_POST['typename'] != null){
        $sql = "INSERT INTO tb_type(type_name) VALUES ('$name')";
        $query = $conn->query($sql);
        header("location: ../../frontend/admin.php?page=type");
        alert("../../frontend/admin.php?page=type","เพิ่มประเภทร้านอาหารเสร็จสิ้น","success");
    }else{
        alert("../../frontend/admin.php?page=type","โปรดใส่ประเภทร้านอาหาร","danger");
    }
}
if(isset($_POST['del'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM tb_type WHERE type_id = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=type");
    alert("../../frontend/admin.php?page=type","ลบประเภทร้านอาหารเรียบร้อย","danger");
}
?>