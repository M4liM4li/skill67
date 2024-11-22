<?php
include_once "db.php";

if(isset($_POST['register'])){
    $resname = $_POST['rname'];
    $resdetail = $_POST['rdetail'];
    $restype = $_POST['rtype'];
    $resid = $_POST['id'];

    if (trim($_FILES["rimg"]["tmp_name"]) != "") {
        $images = $_FILES["rimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["rimg"]["name"];
        copy($_FILES["rimg"]["tmp_name"], "../img/" . $new_images);

        $sql = $conn->query("INSERT INTO tb_res(res_name,res_detail,res_type,res_owner,res_status,res_img) VALUE('$resname','$resdetail','$restype','$resid','1','$new_images')");
        $rs = $sql->fetch();
        header("location: ../frontend/manage.php?page=home");
    }
    
}
if(isset($_POST['po'])){
        $id = $_POST['id'];
        $sql = $conn->query("UPDATE tb_user SET role='po' WHERE uid = '$id'");
        alert("../frontend/openres.php","สมัครเสร็จสิ้นโปรดรอผู้ดูแลอนุมัติคำขอ","success");
    }
?>