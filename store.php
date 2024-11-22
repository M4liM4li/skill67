<?php
include_once "../back/db.php";
include_once "../back/res.php";
// if(isset($_POST['logout'])){
//     session_destroy();
//     unset($_SESSION['id']);
//     header("location: ../index.php");
// };
$sid = $_GET['sid'];
//print_r($_SESSION['cart']);
//unset($_SESSION['cart']);
?>

<?php
error_reporting(0);
$sid = $_GET['sid'];
$orderid = rand(100, 1000);
$date = date("jS F Y ");
$_SESSION['orderid'] = $orderid;
if (isset($_GET['add'])) {
    if (!isset($_SESSION['ROW'])) {
        $_SESSION['ROW'] = 0;
        $sid = $_GET['sid'];
        // $fid = $_GET['fid'];
        $sql = "SELECT * FROM item WHERE item_id = 4";
        $rs = $conn->query($sql);
        $rw = mysqli_fetch_assoc($rs);
        $_SESSION['foodid'][0] = $rw['item_id'];
        $_SESSION['name'][0] = $rw['item_name'];
        $_SESSION['price'][0] = $rw['item_price'];
        $_SESSION['qty'][0] = 1;
        header('Location: ?page=store&sid=' . $sid . '');
    } else {
        $key = array_search($_GET['fid'], $_SESSION['foodid']);
        if ((string)$key != "") {
            $_SESSION['qty'][$key] = $_SESSION['qty'][$key] + 1;
        } else {
            $_SESSION['ROW'] += 1;
            $r = $_SESSION['ROW'];
            $id = $_GET['id'];
            $fid = $_GET['fid'];
            $catid = $_GET['catid'];
            $sql = "SELECT * FROM tb_food WHERE id = '$fid'";
            $rs = $conn->query($sql);
            $rw = mysqli_fetch_assoc($rs);
            $_SESSION['foodid'][$r] = $rw['id'];
            $_SESSION['name'][$r] = $rw['name'];
            $_SESSION['price'][$r] = $rw['price'];
            $_SESSION['qty'][$r] = 1;
            header('Location: ?page=store&sid=' . $sid . '');
        }
    }
} else if (isset($_GET['clear'])) {
    $sid = $_GET['sid'];
    $catid = $_GET['catid'];
    unset($_SESSION['ROW']);
    unset($_SESSION['name']);
    unset($_SESSION['price']);
    unset($_SESSION['qty']);
    header('Location: ?page=store&sid=' . $sid . '');
} else if (isset($_GET['del'])) {
    $row = $_GET['row'];
    $id = $_GET['id'];
    $catid = $_GET['catid'];
    $_SESSION['ROW'] -= 1;
    unset($_SESSION['name'][$row]);
    unset($_SESSION['price'][$row]);
    unset($_SESSION['qty'][$row]);
    header('Location: ?page=userfood&id=' . $id . '&catid=' . $catid);
} else if (isset($_GET['confirm'])) {
    for ($i = 0; $i <= (int)$_SESSION['ROW']; $i++) {
        $orderid = $_SESSION['orderid'];
        $stid = $_GET['id'];
        $foodid = $_SESSION['foodid'][$i];
        $userid = $_SESSION['userid'];
        $sumtotal = $_SESSION['total'];
        $od_date = date('Y-m-d');
        $od_time = date("H:i:s");
        $name = $_SESSION['name'][$i];
        $price = $_SESSION['price'][$i];
        $qty = $_SESSION['qty'][$i];
        $total = $price * $qty;

        $sql = "INSERT INTO tb_order(sumtotal,orderid,shopid,foodid,userid,amount,total,orderdate,ordertime) 
            VALUES('$sumtotal','$orderid','$stid','$foodid','$userid','$qty','$total','$od_date','$od_time')";
        $rs = $conn->query($sql);
    }
    header('Location: ?page=userhistory');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav class="navbar nav-expand shadow">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="home.php" class="text-decoration-none d-flex align-item-center" style="color: darkslategray;">
                <h4>Song<h4 class="fw-bold">Kao Kin</h4>
                </h4>
            </a>

            <div class="d-flex align-items-center responsive mt-auto">
                <form action="home.php" class="seacrh-bar responsive">
                    <input type="text" name="search" class="seacrh" placeholder="Seacrh" required>
                </form>

                <!--off-btn-->
                <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" class="offcanvas-btn">Menu</button>

                <button type="button" class="status-btn responsive"><a href="status.php" class="text-decoration-none text-white">สถานะการสั่งซื้อ</a></button>

                <div class="nav-item dropdown responsive">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php echo getMe($_SESSION['id'])['user_pfp'] ?>" class="rounded-circle shadow-sm" alt="" style="height: 52px; width: 52px; object-fit: cover;">
                    </a>

                    <div class="dropdown-menu mt-4 rounded-3">
                        <div class="dropdown-item">
                            <a href="prof.php" class="text-decoration-none">จัดการข้อมูลส่วนตัว</a>
                        </div>
                        <div class="dropdown-item">
                            <a href="openres.php" class="text-decoration-none">เปิดร้านกับเรา</a>
                        </div>
                        <div class="dropdown-item">
                            <a href="berider.php" class="text-decoration-none">สมัครไรเดอร์</a>
                        </div>
                        <?php if (getMe($_SESSION['id'])['role'] == "admin") { ?>
                            <div class="dropdown-item">
                                <a href="admin.php?page=user" class="text-decoration-none">เมนูแอดมิน</a>
                            </div>
                        <?php }
                        if (getMe($_SESSION['id'])['role'] == "admin" || getMe($_SESSION['id'])['role'] == "rider") { ?>
                            <div class="dropdown-item">
                                <a href="delivery.php?page=status" class="text-decoration-none">หน้ารับงานไรเดอร์</a>
                            </div>
                        <?php } ?>
                        <hr class="dropdown-divider">
                        <div class="dropdown-item">
                            <form action="home.php" method="POST">
                                <input type="submit" class="text-danger dropdown-item" name="logout" value="ออกจากระบบ">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--offcanvas-->
    <div class="offcanvas offcanvas-start" id="offcanvas" aria-hidden="true" tabindex="-1">
        <div class="offcanvas-header">
            <h4>Menu</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <hr class="w-70 d-flex justify-content-center">
            <a href="prof.php" class="text-decoration-none offcanvas-list">จัดการข้อมูลส่วนตัว</a>
            <a href="openres.php" class="text-decoration-none offcanvas-list">เปิดรา้นกับเรา</a>
            <a href="berider.php" class="text-decoration-none offcanvas-list">สมัครไรเดอร์</a>
            <a href="status.php" class="text-decoration-none offcanvas-list">สถานะการสั่งซื้อ</a>
            <?php if (getMe($_SESSION['id'])['role'] == "admin") { ?>
                <a href="admin.php?page=user" class="text-decoration-none offcanvas-list">เมนูแอดมิน</a>
            <?php }
            if (getMe($_SESSION['id'])['role'] == "admin" || getMe($_SESSION['id'])['role'] == "rider") { ?>
                <a href="delivery.php?page=status" class="text-decoration-none offcanvas-list">หน้ารับงานไรเดอร์</a>
            <?php } ?>
            <hr class="w-70 d-flex justify-content-center">
            <input type="button" class="text-danger dropdown-item" value="ออกจากระบบ">
        </div>
    </div>
    <!--offcanvas-->
    <div class="store-header shadow-sm">
        <div class="container p-5">
            <h1 class="fw-bold"><?php echo getRes($sid)['res_name'] ?></h1>
            <h5><?php echo getRes($sid)['res_desc'] ?></h5>
            <div class="store-review">
                <p class="store-rate">5</p>
                <a href="#Modalreview" class="text-decoration-none store-tab" data-bs-toggle="modal" data-target="#Modalreview">ดูรีวิว</a>
            </div>
            <?php if (getRes($sid)['res_owner'] == $_SESSION['id']) { ?>
                <a href="manage.php?id=<?php echo $sid ?>&page=res" class="btn btn-primary text-white text-decoration-none">จัดการร้าน</a>
            <?php } ?>
        </div>
    </div>

    <div class="web-content">
        <div class="row">
            <div class="col-2 col-xs-none col-2-category">
                <div class="col-12">
                    <h4 class="fw-bold m-2" style="color: darkslategray;">หมวดหมู่</h4>
                </div>
                <div class="index-category">
                    <a href="store.php?sid=<?php echo $sid ?>" class="text-decoration-none category-item">ทั้งหมด</a>
                    <?php
                    $s = $db->query("SELECT * FROM item_cate WHERE cate_sid = '$sid'");
                    while ($r = $s->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <a href="store.php?sid=<?php echo $sid ?>&cate=<?php echo $r['cate_id'] ?>" class="text-decoration-none category-item"><?php echo $r['cate_name'] ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="row nopadding">
                    <?php if (isset($_SESSION['text'])) { ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['text'];
                                                        unset($_SESSION['text']) ?></div>
                    <?php } ?>
                    <?php if (isset($_GET['cate'])) { ?>
                        <?php
                        $cate = $_GET['cate'];
                        $stmt = $db->query("SELECT * FROM item WHERE res_id = '$sid' AND item_type = '$cate'");
                        while ($r = $stmt->fetch()) {
                            $iid = $r['item_id']
                        ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                                <a href="#Modalproduct" data-bs-toggle="modal" data-target="#Modalproduct" class="text-decoration-none" onclick="viewItem('<?php echo $r['item_name'] ?>','<?php echo $r['item_price'] ?>','<?php echo $r['item_discount'] ?>','<?php echo $r['item_img'] ?>','<?php echo $r['item_id'] ?>')">
                                    <img src="<?php echo $r['item_img'] ?>" class="index-store-img" alt="">
                                    <div class="index-store-content">
                                        <h5 class="fw-bold"><?php echo $r['item_name'] ?></h5>
                                        <p><?php if (!empty($r['item_discount'])) { ?>
                                                <h7 class="text-danger"><s><?php echo $r['item_price'] . " ฿" ?></s></h7>
                                                <h7 class="text-success"><?php echo $r['item_price'] * (100 - $r['item_discount']) / 100 . " ฿"; ?></h7>
                                            <?php } else {
                                                echo $r['item_price'] . " ฿";
                                            } ?>
                                        </p>

                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php
                        $stmt = $db->query("SELECT * FROM item WHERE res_id = '$sid'");
                        while ($r = $stmt->fetch()) {
                        ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                                <a href="#Modalproduct" onclick="viewItem('<?php echo $r['item_name'] ?>','<?php echo $r['item_price'] ?>','<?php echo $r['item_discount'] ?>','<?php echo $r['item_img'] ?>','<?php echo $r['item_id'] ?>')" data-bs-toggle="modal" data-target="#Modalproduct" class="text-decoration-none">
                                    <img src="<?php echo $r['item_img'] ?>" class="index-store-img" alt="">
                                    <div class="index-store-content">

                                        <h5 class="fw-bold"><?php echo $r['item_name'] ?></h5>
                                        <p><?php if (!empty($r['item_discount'])) { ?>
                                                <h7 class="text-danger"><s><?php echo $r['item_price'] . " ฿" ?></s></h7>
                                                <h7 class="text-success"><?php echo $r['item_price'] * (100 - $r['item_discount']) / 100 . " ฿"; ?></h7>
                                            <?php } else {
                                                echo $r['item_price'] . " ฿";
                                            } ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>

            </div>
            <!-- show table -->
            <div class="col-lg-4 border" style="background-color: white;">
                <br>
                <h3 class="" sytle="font-weight:bold;">รายการสั่งซื้อ ว/ด/ป <?php echo $date; ?></h3>
                <p>เลขที่ใบสั่งซื้อ: <?php echo $orderid; ?></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">สินค้า</th>
                            <th scope="col" class="text-center">ราคา</th>
                            <th scope="col" class="text-center">จำนวน</th>
                            <th scope="col" class="text-center">รวม</th>
                            <th scope="col">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum = 0;
                        $_SESSION['total'] = 0;
                        $_SESSION['total_qty'] = 0;
                        for ($i = 0; $i <= (int)$_SESSION['ROW']; $i++) {
                            if (!isset($_SESSION['ROW'])) {
                                echo "ยังไม่ได้เลือกสินค้า";
                            } else {
                                $sum = $_SESSION['price'][$i] * $_SESSION['qty'][$i];
                                $_SESSION['total'] = $_SESSION['total'] + $sum;
                                $_SESSION['total_qty'] += $_SESSION['qty'][$i];
                        ?>
                                <tr>
                                    <td><?php echo $i + 1; ?><input type="hidden" name="food" value="<?php $_SESSION['name'][$i]; ?>"></td>
                                    <td><?php echo $_SESSION['name'][$i]; ?></td>
                                    <td class="text-center"><?php echo number_format($_SESSION['price'][$i], 2, '.', ','); ?></td>
                                    <td align="center">
                                        <?php echo $_SESSION['qty'][$i]; ?>
                                    </td>
                                    <td align="center"><?php echo number_format($sum, 2, '.', ','); ?></td>
                                    <td><a href="?page=userfood&del&row=<?php echo $i; ?>&id=<?php echo $_GET['id']; ?>&catid=<?php echo $rw['ftid'] ?>"><button class="btn btn-danger btn-sm">ลบ</button></a></td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <td colspan="4" align="center">รวม</td>
                            <td><?php echo number_format($_SESSION['total'], 2, '.', ','); ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="6" align="end">
                                <p style="margin-right: 30px;">
                                    <a href="?page=clear&sid=<?php echo $_GET['sid']; ?>"><button class="btn btn-danger" style="margin-right: 10px;">ยกเลิกออร์เดอร์</button></a>
                                    <a href="?page=userfood&confirm&id=<?php echo $_GET['id']; ?>&catid=<?php echo $rw['ftid'] ?>"><button class="btn btn-primary">สั่งซื้อ</button></a>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        <div class="modal fade" id="Modalreview" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="fw-bold" style="color: darkslategray;">ความคิดเห็น</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background: #f7f7f7;">
                        <?php
                        $stmt = $db->query("SELECT * FROM review WHERE review_sid = '$sid'");
                        while ($s = $stmt->fetch()) {
                            $oid = $s['review_oid'];
                        ?>
                            <div class="modal-content-review w-100 mt-4">
                                <div class="review-name fw-bold"><?php echo $s['review_name'] ?></div>
                                <div class="review-menu">
                                    <p class="wewrr me-2">เมนู&nbsp;:</p>
                                    <p class="menu-list">
                                        <?php $i = $db->query("SELECT * FROM detail WHERE oid = '$oid'");
                                        while ($x = $i->fetch()) {
                                            echo $x['prod_name'] . " ";
                                        } ?>
                                    </p>
                                </div>
                                <div class="review-date-rate">
                                    <p class="me-2">คะแนน :</p>
                                    <p><?php echo $s['review_rate'] ?></p>
                                    <p class="date"><?php echo $s['review_date'] ?></p>
                                </div>
                                <p class="review-detail">
                                    <?php echo $s['review_text'] ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!--modalpoduct-->
        <form action="../back/cart.php" method="POST">
            <div class="modal fade" id="Modalproduct" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content nopadding">
                        <div class="modal-body nopadding">
                            <div class="modal-content-product">
                                <img src="pic/35fd571d-3d8d-4044-94f1-960fc29ce60c.jpg" id="prodImg" class="product-img" alt="">
                                <div class="modal-product-detail">
                                    <h5 class="fw-bold" id="prodName">ชื่ออาหาร</h5>
                                    <span class="me-2">ราคา&nbsp;:</span><span id="prodprice">999999฿</span>
                                    <input type="text" id="prodId" name="id" hidden>
                                    <input type="text" value="<?php echo $sid ?>" hidden name="sid">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="product-quatity">
                                <span>จำนวน&nbsp;:</span>
                                <input type="button" value="-" onclick="decrement()" class="pro-quatity">
                                <input type="text" value="1" name="qty" id="qty" class="pro-num">
                                <input type="button" value="+" onclick="increment()" class="pro-quatity">
                            </div>
                            <?php 
                                $cate = $_GET['cate'];
                                $m = $db->query("SELECT * FROM item WHERE res_id = '$sid' AND item_type = '$cate'");
                                $r = $m->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <a href="?page=add&sid=<?php echo $_GET['sid']; ?>&fid=4" class="getcart">ใส่ตะกร้า</a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="../css/bootstrap.bundle.min.js"></script>
        <script src="main.js"></script>
</body>

</html>