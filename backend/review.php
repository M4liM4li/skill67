<?php
include_once "db.php";

if (isset($_POST['review'])) {
    $text = $_POST['text'];
    $rate = $_POST['rate'];
    $fname = $_POST['fname'];
    $sid = $_POST['sid'];
    $oid = $_POST['oid'];

    $s = $conn->query("INSERT INTO tb_review(review_name,review_text,review_rate,review_oid,review_sid) VALUES ('$fname','$text','$rate','$oid','$sid')");
    $d = $conn->query("UPDATE tb_orders SET review='1' WHERE order_id = '$oid'");
    header("location: ../frontend/status.php?page=history");
}
