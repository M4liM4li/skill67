<?php
include_once "db.php";

if(isset($_POST['pr'])){
    $id = $_POST['id'];
    $sql = $conn->query("UPDATE tb_user SET role='pr' WHERE uid = '$id'");
    alert("../frontend/regrider.php","สมัครเสร็จสิ้นโปรดรอผู้ดูแลอนุมัติคำขอ","success");
}

?>