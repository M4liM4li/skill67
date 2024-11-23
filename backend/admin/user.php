<?php
include_once "../db.php";

if(isset($_POST['ban'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='ban' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=user");
};
if(isset($_POST['unban'])){
    $id = $_POST['id'];
    $sql = "UPDATE tb_user SET role='member' WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=user");
}
if(isset($_POST['add'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];

    if($pass == $repass){
            $sql = $conn->query("INSERT INTO tb_user(fname,lname,Email,password,role) VALUE('$fname','$lname','$email','$pass','member')");
            $rs = $sql->fetch();
            header("location: ../../frontend/admin.php?page=user");
            alert("../../frontend/admin.php?page=user","เพื่มผู้ใช้เสร็จสิ้น","success");

        }else{
            alert("../../frontend/admin.php?page=user","รหัสไม่ตรงกัน","danger");
        } 
}

if(isset($_POST['del'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM tb_user WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=user");
    alert("../../frontend/admin.php?page=user","ลบข้อมูลเสร็จสิ้น","danger");

}

if(isset($_POST['edit'])){
    
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    if (trim($_FILES["userimg"]["tmp_name"]) != "") {
        $images = $_FILES["userimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["userimg"]["name"];
        copy($_FILES["userimg"]["tmp_name"], "../../img/" . $new_images);
        
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/admin.php?page=user");
        alert("../../frontend/admin.php?page=user","เปลี่ยนข้อมูลส่วนตัวเสร็จสิ้น","success");

    }else{
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/admin.php?page=user");
        alert("../../frontend/admin.php?page=user","เปลี่ยนข้อมูลส่วนตัวเสร็จสิ้น","success");

    }
}
if(isset($_POST['useredit'])){
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    if (trim($_FILES["userimg"]["tmp_name"]) != "") {
        $images = $_FILES["userimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["userimg"]["name"];
        copy($_FILES["userimg"]["tmp_name"], "../../img/" . $new_images);
        
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email', userimg = '$new_images' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/profile.php");
        alert("../../frontend/profile.php","เปลี่ยนข้อมูลส่วนตัวเสร็จสิ้น","success");
    }else{
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/profile.php");
        alert("../../frontend/profile.php","เปลี่ยนข้อมูลส่วนตัวเสร็จสิ้น","success");

    }
}

if(isset($_POST['passedit'])){
    $id = $_POST['id'];
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];

    if(getUid($_SESSION['id'])['password'] == $oldpass){
        $sql = $conn->query("UPDATE tb_user SET password = '$newpass' where uid ='$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/profile.php");
        alert("../../frontend/profile.php","เปลี่ยนรหัสเสร็จสิ้น","success");
    }else{
        alert("../../frontend/profile.php","รหัสไม่ถูกต้อง","danger");
    }
}
?>