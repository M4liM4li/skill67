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
        }else{
            alert("xxxxxxxx", "../../frontend/admin.php?page=user");
        } 
}

if(isset($_POST['del'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM tb_user WHERE uid = '$id'";
    $query = $conn->query($sql);
    header("location: ../../frontend/admin.php?page=user");
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
    }else{
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/admin.php?page=user");
    }
}
if(isset($_POST['edit2'])){
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
    }else{
        $sql = $conn->query("UPDATE tb_user SET fname = '$fname', lname = '$lname', email = '$email' WHERE uid = '$id'");
        $rs = $sql->fetch();
        header("location: ../../frontend/profile.php");
    }
}

?>