<?php
include_once "db.php";

if(isset($_POST['register'])){
    $resname = $_POST['rname'];
    $resdetail = $_POST['rdetail'];
    $restype = $_POST['rtype'];
    $resaddress = $_POST['raddress'];
    $resid = $_POST['id'];

    if (trim($_FILES["rimg"]["tmp_name"]) != "") {
        $images = $_FILES["rimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["rimg"]["name"];
        copy($_FILES["rimg"]["tmp_name"], "../img/" . $new_images);

        $sql = $conn->query("INSERT INTO tb_res(res_name,res_detail,res_type,res_owner,res_status,res_address,res_img) VALUE('$resname','$resdetail','$restype','$resid','1','$resaddress','$new_images')");
        $rs = $sql->fetch();
        header("location: ../frontend/manage.php?page=home");
    }else{
        $sql = $conn->query("INSERT INTO tb_res(res_name,res_detail,res_type,res_owner,res_status,res_address) VALUE('$resname','$resdetail','$restype','$resid','1','$resaddress')");
        $rs = $sql->fetch();
        header("location: ../frontend/manage.php?page=home");
    }
    
}
if(isset($_POST['po'])){
        $id = $_POST['id'];
        $sql = $conn->query("UPDATE tb_user SET role='po' WHERE uid = '$id'");
        alert("../frontend/openres.php","สมัครเสร็จสิ้นโปรดรอผู้ดูแลอนุมัติคำขอ","success");
    }

if(isset($_POST['editres'])){
    $resid = $_POST['id'];
    $resname = $_POST['rname'];
    $resdetail = $_POST['rdetail'];
    $restype = $_POST['rtype'];

    if (trim($_FILES["rimg"]["tmp_name"]) != "") {
        $images = $_FILES["rimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["rimg"]["name"];
        copy($_FILES["rimg"]["tmp_name"], "../img/" . $new_images);

        $sql = $conn->query("UPDATE tb_res set res_name='$resname', res_detail='$resdetail',res_type='$restype',res_img ='$new_images' where res_id = '$resid'");
        $rs = $sql->fetch();
        header("location: ../frontend/manage.php?page=res");
    }else{
        $sql = $conn->query("UPDATE tb_res set res_name='$resname', res_detail='$resdetail',res_type='$restype' where res_id = '$resid'");
        $rs = $sql->fetch();
        header("location: ../frontend/manage.php?page=res");
    }
    
}

?>