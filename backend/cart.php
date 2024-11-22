<?php
include_once "db.php";

if (isset($_POST['addCart'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $sid = $_POST['sid'];
    if (empty($_SESSION['cart'][$id])) {
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart']['storeId'] = $sid;
            $_SESSION['cart'][$id] = $qty;
        } else {
            if ($_SESSION['cart']['storeId'] != $sid) {
                headWt("../frontend/store.php?sid=$sid", "กรุณาสั่งอาหารจากร้านเดียวกัน");
            } else {
                $_SESSION['cart'][$id] = $qty;
            };
        };
    } else {
        $_SESSION['cart'][$id] += $qty;
    };
    header("location: ../frontend/store.php?sid=$sid");
};
if (isset($_POST['buy'])) {
    $fname = $_POST['fname'];
    $total = $_POST['total'];
    $sid = $_POST['sid'];
    $id = $_POST['id'];
    $address = $_POST['address'];

    $order = $db->query("INSERT INTO orders(order_fname,order_total,res_id,order_status,order_pay,order_uid,order_address) VALUES ('$fname','$total','$sid','0','0','$id','$address')");
    $oid = $db->lastInsertId();
    $isFirst = true;
    foreach ($_SESSION['cart'] as $itemId => $itemQty) {
        if ($isFirst) {
            $isFirst = false;
            continue;
        };
        $iName = $_POST['product'][$itemId]['name'];
        $iPrice = $_POST['product'][$itemId]['price'];
        $tid = $_POST['product'][$itemId]['id'];

        $s = $db->query("INSERT INTO detail(prod_name,prod_price,prod_qty,oid,tid) VALUES ('$iName','$iPrice','$itemQty','$oid','$tid')");
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
