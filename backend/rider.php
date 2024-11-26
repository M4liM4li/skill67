<?php
include_once "db.php";

if(isset($_POST['rub'])){
 $id = $_POST['id'];
 $rub = $conn->query("UPDATE tb_orders SET order_status ='2' where order_id = '$id'");
 $rs = $rub->fetch();
 header("Location: ../frontend/rider.php?page=now");
}
if(isset($_POST['song'])){
 $id = $_POST['id'];
 $song = $conn->query("UPDATE tb_orders SET order_status ='3' where order_id = '$id'");
 $rs = $song->fetch();
 header("Location: ../frontend/rider.php?page=now");
}
if(isset($_POST['success'])){
 $id = $_POST['id']; 
 $success = $conn->query("UPDATE tb_orders SET order_status ='4' ,order_pay='1' where order_id = '$id'");
 $rs = $success->fetch();
 header("Location: ../frontend/rider.php?page=history ");
} 
?>