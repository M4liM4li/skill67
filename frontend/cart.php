<?php
include "../backend/db.php";

$product = [];

$isfirst = true;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $itemId => $itemQty) {
        if ($isfirst) {
            $isfirst = false;
            continue;
        };
        $product[] = $itemId;
    }
};
$ids = 0;
if (count($product) > 0) {
    $ids = implode(", ", $product);
};

$stmt = $conn->query("SELECT * FROM tb_food WHERE food_id IN ($ids)");
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
    <title>Admin Panel</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    

    <style>
        
    </style>
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



    <div class="container-fluid mt-5 mx-5">
        <h2 style="color: darkslategray;" class="mb-4 ms-3 fw-bold">ตะกร้า</h2>
        <?php if (isset($_SESSION['text'])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION['text'];
                                                unset($_SESSION['text']) ?></div>
        <?php } ?>
        <div class="row cart-body">
            <?php
            while ($rw = $stmt->fetch()) {
            ?>
                <div class="col-md-6 me-2 col-sm-12 cart mb-3">
                    <img src="../img/<?php echo $rw['food_img']  ?>" class="cart-img" alt="">
                    <div class="cart-content">
                        <div class="cart-menu d-flex">
                            <span class="me-2 fw-bold">เมนู &nbsp; :</span><span class="cart-menu-list"><?php echo $rw['food_name']  ?></span>
                        </div>
                        <div class="cart-price d-flex">
                            <span class="me-2 fw-bold">ราคา &nbsp; :</span><span><?php echo $rw['food_price'] * (100 - $rw['food_discount']) / 100 . " ฿" ?></span>
                        </div>
                        <div class="cart-quatity d-flex">
                            <span class="me-2 fw-bold">จำนวน &nbsp; :</span><span><?php echo $_SESSION['cart'][$rw['food_id']] ?></span>
                        </div>
                        <div class="action d-flex justify-content-end">
                            <form action="../backend/cart.php" method="POST">
                                <input type="text" value="<?php echo $rw['food_id'] ?>" name="id" hidden>
                                <input type="submit" class="cart-action" name="del" value="ลบ">
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                @$total += @$rw['food_price'] * $_SESSION['cart'][$rw['food_id']] * (100 - $rw['food_discount']) / 100;
                $rid = $rw['res_id'];
            } ?>
        </div>
    </div>


    <footer class="shadow-sm">
        <div class="cart-footer">
            <div class="cart-footer-price">
                <span class="me-2 fw-bold">ราคารวม &nbsp; :</span><span><?php echo @$total . " ฿" ?></span>
            </div>
            <button type="button" class="tab-to-buy" data-bs-target="#buy" data-bs-toggle="modal">สั่งซื้อ</button>
        </div>
    </footer>

    <form action="../backend/cart.php" method="POST">
        <div class="modal fade" id="buy">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="4">สั่งซื้อสินค้า</div>
                        <button class="btn btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">ที่อยู่จัดส่ง</label>
                        <textarea name="address" id="" cols="30" rows="3" class="form-control"></textarea>
                        <input type="text" name="fname" value="<?php echo getUid($_SESSION['id'])['fname'] ?>" id="" hidden>
                        <input type="text" name="total" value="<?php echo $total ?>" id="" hidden>
                        <input type="text" name="rid" value="<?php echo $rid; ?>" id="" hidden>
                        <input type="text" name="id" value="<?php echo $_SESSION['id'] ?>" hidden>
                        <?php
                        $getItem = $conn->query("SELECT * FROM tb_food WHERE food_id ='$ids'");
                        while ($gT = $getItem->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <input type="text" name="product[<?php echo $gT['food_id'] ?>][name]" value="<?php echo $gT['food_name'] ?>" hidden>
                            <input type="text" name="product[<?php echo $gT['food_id'] ?>][price]" value="<?php echo $gT['food_price'] * (100 - $gT['food_discount']) / 100 ?>" hidden>
                            <input type="text" name="product[<?php echo $gT['food_id'] ?>][id]" value="<?php echo $gT['food_id'] ?>" hidden>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" name="buy">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


</body>
<script src="../css/bootstrap.bundle.min.js"></script>
<script src="main.js"></script>
</html>