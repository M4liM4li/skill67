<?php
include_once "db.php";

if (isset($_POST['addCart'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $rid = $_POST['rid'];
    if (empty($_SESSION['cart'][$id])) {
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart']['storeId'] = $rid;
            $_SESSION['cart'][$id] = $qty;
        } else {
            if ($_SESSION['cart']['storeId'] != $rid) {
                headWt("../frontend/store.php?rid=$rid", "กรุณาสั่งอาหารจากร้านเดียวกัน");
            } else {
                $_SESSION['cart'][$id] = $qty;
            };
        };
    } else {
        $_SESSION['cart'][$id] += $qty;
    };
    header("location: ../frontend/store.php?rid=$rid");
};
if (isset($_POST['buy'])) {
    $fname = $_POST['fname'];
    $total = $_POST['total'];
    $rid = $_POST['rid'];
    $id = $_POST['id'];
    $address = $_POST['address'];

    $order = $conn->query("INSERT INTO tb_orders(order_fname,order_total,res_id,order_status,order_pay,order_uid,order_address) VALUES ('$fname','$total','$rid','0','0','$id','$address')");
    $oid = $conn->lastInsertId();
    $isFirst = true;
    foreach ($_SESSION['cart'] as $itemId => $itemQty) {
        if ($isFirst) {
            $isFirst = false;
            continue;
        };
        $iName = $_POST['product'][$itemId]['name'];
        $iPrice = $_POST['product'][$itemId]['price'];
        $fid = $_POST['product'][$itemId]['id'];

        $s = $conn->query("INSERT INTO tb_detail(food_name,food_price,food_qty,order_id,food_id) VALUES ('$iName','$iPrice','$itemQty','$oid','$fid')");
    };
    unset($_SESSION['cart']);
    headWt("../frontend/cart.php", "สั่งซื้อสำเร็จ!");
};
if (isset($_POST['del'])) {
    $id = $_POST['id'];
    unset($_SESSION['cart'][$id]);
    $isFirst = true;
    foreach ($_SESSION['cart'] as $itemId => $itemQty) {
        echo $itemId;
        if ($itemId == 'storeId') {
            unset($_SESSION['cart']);
        }
    };


    header("location: ../frontend/cart.php");
}
