<?php
include_once "db.php";
if(isset($_POST['regis'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];

    if (trim($_FILES["userimg"]["tmp_name"]) != "") {
        $images = $_FILES["userimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["userimg"]["name"];
        copy($_FILES["userimg"]["tmp_name"], "../img/" . $new_images);
    if($pass == $repass){
            $sql = $conn->query("INSERT INTO tb_user(fname,lname,Email,password,role,userimg) VALUE('$fname','$lname','$email','$pass','member','$new_images')");
            $rs = $sql->fetch();
            header("location: ../index.php");
        }else{
            alert("../register.php","รหัสผิดพลาด","danger");
        } 
    }
}
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $sql = $conn->query("SELECT * FROM tb_user WHERE email = '$email'");
    $rw = $sql->fetch();
    if(isset($rw['email'])){
        if($pass == $rw['password']){
            $_SESSION['id'] = $rw['uid'];
            header("location: ../frontend/home.php");
        }else{
            alert("../index.php", "Password is incorrect!","danger");
            return;
        };
    }else{
        alert("../index.php", "Email is incorrect!");
        return;
    }
}
if(isset($_POST['res'])){
    
    $id = $_POST['id'];
    echo $id;
}

?>