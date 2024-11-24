<?php
include_once "../backend/db.php";
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    header("location: ../index.php");
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="home.php">
                <strong style="color:blue; font-size: 1.5rem;" class="ms-3">KTP</strong> Delivery
            </a>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <form action="home.php" class="me-4">
                        <input type="search" name="search" class="form-control me-2 " placeholder="Seacrh" required>
                    </form>
                </ul>
                <div class="dropdown">
                    <a class="link-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="profile-img" src="../img/<?php echo getUid($_SESSION['id'])['userimg'] ?>"></a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php">จัดการข้อมูลส่วนตัว</a></li>
                        <li><a class="dropdown-item" href="res.php">ลงทะเบียนร้านค้า</a></li>
                        <li><a class="dropdown-item" href="#">ลงทะเบียนไรเดอร์</a></li>
                        <?php if (getUid($_SESSION['id'])['role'] == "admin") { ?>
                            <hr>
                            <li><a href="admin.php?page=user" class="dropdown-item">เมนูแอดมิน</a></li>
                        <?php }
                        if (getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "rider") { ?>
                            <hr>
                            <li><a href="rider.php?page=status" class="dropdown-item">หน้ารับงานไรเดอร์</a></li>
                        <?php }
                        if (getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "owner") { ?>
                            <hr>
                            <li><a href="manage.php?page=home" class="dropdown-item">จัดการหลังบ้าน</a></li>
                        <?php } ?>
                        <hr>
                        <li>
                            <form method="post" action="home.php">
                                <button type="submit" name="logout" class="dropdown-item">ออกจากระบบ</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-2 col-sm-12 mb-4">
                <div class="list-group list-group-flush">
                    <a href="status.php" class="text-decoration-none list-group-item list-group-item-action">สถานะการสั่งซื้อ</a>
                    <a href="status.php?page=history" class="text-decoration-none list-group-item list-group-item-action">ประวัติการสั่งซื้อ</a>
                </div>
            </div>
            <div class="col-lg-10 col-sm-12">
                <?php if (isset($_GET['page']) == 'history') { ?>
                    <?php
                    $uid = $_SESSION['id'];
                    $s = $conn->query("SELECT * FROM tb_orders WHERE order_uid = '$uid' AND order_status = 3");
                    while ($r = $s->fetch()) {
                        $oid = $r['order_id'];
                    ?>
                        <div class="border p-3 mt-4 rounded-2">
                            <div class="status-menu d-flex">
                                <p class="fw-bold me-2">เมนู &nbsp; :</p>
                                <P class="status-menu-list"><?php
                                                            $i = $conn->query("SELECT * FROM tb_detail WHERE order_id = '$oid'");
                                                            while ($x = $i->fetch()) {
                                                                echo $x['food_name'] . " ";
                                                            }
                                                            ?></P>
                            </div>
                            <div class="status-price d-flex">
                                <p class="fw-bold me-2">ราคาทั้งหมด &nbsp; :</p>
                                <p><?php echo $r['order_total'] . " ฿" ?></p>
                            </div>
                            <div class="d-flex">
                                <a class="me-3 btn btn-success">จัดส่งสำเร็จ </a> <?php if ($r['review'] == '0') { ?>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#review" onclick="reviewItem('<?php echo $r['order_id'] ?>','<?php echo $r['res_id'] ?>')" class="job-accpact">
                                        รีวิว
                                    </button>
                                    <button onclick="reviewItem('<?php echo $r['order_id'] ?>','<?php echo $r['res_id'] ?>')"><?php echo $r['order_id'] ?></button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <?php
                    $uid = $_SESSION['id'];
                    $s = $conn->query("SELECT * FROM tb_orders WHERE order_uid = '$uid' AND order_status BETWEEN 0 AND 2");
                    while ($r = $s->fetch()) {
                        $oid = $r['order_id'];
                    ?>
                        <div class="border p-3 mt-4 rounded-2">
                            <div class="status-menu d-flex">
                                <p class="fw-bold me-2">เมนู &nbsp; :</p>
                                <P class="status-menu-list"><?php
                                                            $i = $conn->query("SELECT * FROM tb_detail WHERE order_id = '$oid'");
                                                            while ($x = $i->fetch()) {
                                                                echo $x['food_name'] . " ";
                                                            }
                                                            ?></P>
                            </div>
                            <div class="d-flex">
                                <p class="fw-bold me-2">ราคาทั้งหมด &nbsp; :</p>
                                <p><?php echo $r['order_total'] . " ฿" ?></p>
                            </div>
                            <?php if ($r['order_status'] == '0') { ?>
                                <p class="btn btn-warning">รอร้านอาหารรับออเดอร์</p>
                            <?php } else if ($r['order_status'] == '1') { ?>
                                <p class="btn btn-warning">รอไรเดอร์ไปรับอาหาร</p>
                            <?php } else if ($r['order_status'] == '2') { ?>
                                <p class="btn btn-warning">รอก่อน ไรเดอร์กำลังไปหาคุณ</p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <form action="../backend/review.php" method="POST">
        <div class="modal fade" id="review">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3> รีวิวของคุณ</h3>
                        <button class="btn btn-close" data-bs-dismiss="modal" type="button"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">รีวิว</label>
                        <textarea name="text" id="" cols="30" rows="3" class="form-control"></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <h6>1</h6>
                            <h6>5</h6>
                        </div>
                        <input type="range" name="rate" min="1" max="5" class="form-range" id="">
                        <input type="text" name="fname" value="<?php echo getUid($_SESSION['id'])['fname'] ?>" hidden>
                        <input type="text" name="oid" id="oid" hidden>
                        <input type="text" name="sid" id="sid" hidden>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" name="review" value="รีวิว">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="../css/bootstrap.bundle.min.js"></script>
    <script>
        function reviewItem(oid, sid) {
            document.getElementById("oid").value = oid
            document.getElementById("sid").value = sid
        }
    </script>
</body>

</html>