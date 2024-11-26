<?php
include_once "db.php";

if(isset($_POST['rub'])){
    $id = $_POST['id'];
    $rub = $conn->query("UPDATE tb_orders SET order_status ='1' where order_id = '$id'");
    $rs = $rub->fetch();
    header("Location: ../frontend/manage.php?page=order");
}

?>