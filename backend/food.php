<?php
include_once "db.php";

if(isset($_POST['add'])){
    $id = $_POST['id'];
    $foodname = $_POST['foodname'];
    $foodprice = $_POST['foodprice'];
    $foodtype = $_POST['foodtype'];

    if (trim($_FILES["foodimg"]["tmp_name"]) != "") {
        $images = $_FILES["foodimg"]["tmp_name"];
        $new_images = "pic_" . $_FILES["foodimg"]["name"];
        copy($_FILES["foodimg"]["tmp_name"], "../img/" . $new_images);

        $sql = $conn->query("INSERT INTO tb_food(food_name,food_price,food_type,res_id,food_img)VALUE('$foodname','$foodprice','$foodtype','$id','$new_images')");
        $rs = $sql->fetch();
        header("Location: ../frontend/manage.php?page=food");
    }
}
?>