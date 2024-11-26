<?php
$user = "root";
$pword = "";
session_start();
try {
    $conn = new PDO("mysql:host=localhost;dbname=skill67", $user, $pword);
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $d) {
    echo $d->getMessage();
}

function getUid($uid)
{
    global $conn;
    $sql = $conn->query("SELECT * FROM tb_user WHERE uid = '$uid'");
    $rs = $sql->fetch();
    return $rs;
};
function alert($location, $text, $color)
{
    $_SESSION['text'] = $text;
    $_SESSION['alert_color'] = $color;
    header("location: $location");
    exit();
};
function headWt($d, $t)
{
    $_SESSION['text'] = $t;
    header("location: $d");
};
function getRate($sid)
{
    global $conn;
    $rs = $conn->query("SELECT ROUND(AVG(review_rate),1) AS rate FROM tb_review WHERE review_sid = '$sid'");
    $rw = $rs->fetch();
    return $rw;
}
