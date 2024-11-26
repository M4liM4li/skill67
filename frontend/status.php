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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
 <!--navbar-->
<nav class="navbar nav-expand shadow-lg" >
    <div class="container d-flex justify-content-between align-items-center">
    <a class="navbar-brand" href="home.php">
        <strong style="color:blue; font-size: 1.5rem;" class="ms-3">KTP</strong> Delivery
      </a>
        <div class="d-flex align-items-center responsive mt-auto">
            <!--off-btn-->
            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" class="offcanvas-btn" ><p style="transform: rotate(90deg);">    
            | | |</p></button>
            <div class="nav-item dropdown responsive">
                <a class="link-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <img class="profile-img" src="../img/<?php echo getUid($_SESSION['id'])['userimg'] ?>">
                  </a>
                <div class="dropdown-menu mt-4 rounded-3">
                    <div class="dropdown-item">
                        <a href="profile.php" class="text-decoration-none list-item">จัดการข้อมูลส่วนตัว</a>
                    </div>
                    <div class="dropdown-item">
                        <a href="openres.php" class="text-decoration-none">ลงทะเบียนร้านค้า</a>
                    </div>
                    <div class="dropdown-item">
                        <a href="regrider.php" class="text-decoration-none">ลงทะเบียนไรเดอร์</a>
                    </div>
                    <div class="dropdown-item">
                        <a href="status.php" class="text-decoration-none">สถานะการสั่งซื้อ</a>
                    </div>
                    <?php if (getUid($_SESSION['id'])['role'] == "admin") { ?>
                        <hr>
                        <div class="dropdown-item">
                          <a href="admin.php?page=user" class="text-decoration-none">เมนูแอดมิน</a>
                         </div>
                      <?php }
                      if (getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "rider") { ?>
                        <hr>
                        <div class="dropdown-item">
                          <a href="rider.php?page=status" class="text-decoration-none">หน้ารับงานไรเดอร์</a>
                         </div>
                      <?php }
                      if (getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "owner") { ?>
                        <hr>
                        <div class="dropdown-item">
                          <a href="manage.php?page=home" class="text-decoration-none">จัดการหลังบ้าน</a>
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
<<<<<<< HEAD
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
        <a href="profile.php" class="text-decoration-none offcanvas-list">จัดการข้อมูลส่วนตัว</a>
        <a href="openres.php" class="text-decoration-none offcanvas-list">เปิดร้านกับเรา</a>
        <a href="regrider.php" class="text-decoration-none offcanvas-list">สมัครไรเดอร์</a>
        <a href="status.php" class="text-decoration-none offcanvas-list">สถานะการสั่งซื้อ</a>
        
        <!-- ตรวจสอบบทบาทผู้ใช้ -->
        <?php if (getUID($_SESSION['id'])['role'] == "admin") { ?>
            <a href="admin.php?page=user" class="text-decoration-none offcanvas-list">เมนูแอดมิน</a>
        <?php } ?>

        <?php if (getUID($_SESSION['id'])['role'] == "admin" || getUID($_SESSION['id'])['role'] == "rider") { ?>
            <a href="rider.php?page=status" class="text-decoration-none offcanvas-list">หน้ารับงานไรเดอร์</a>
        <?php } ?>

        <?php if (getUID($_SESSION['id'])['role'] == "admin" || getUID($_SESSION['id'])['role'] == "owner") { ?>
            <a href="manage.php?page=home" class="text-decoration-none offcanvas-list">หน้ารับงานร้านอาหาร</a>
        <?php } ?>
        
        <hr class="w-70 d-flex justify-content-center">
        <input type="button" class="text-danger dropdown-item" value="ออกจากระบบ">
    </div>
</div>
<!--offcanvas-->

=======
    </nav>
    <!-- Navbar -->
>>>>>>> 9b573a476830d08007f65ecc6cbfe4d6de51e00b
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