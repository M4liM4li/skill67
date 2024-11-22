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

$stmt = $conn->query("SELECT * FROM tb_food WHERE food_id = '$ids'");
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
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .hold:hover {
            color: green;
        }

        .nopadding {
            padding: 0 !important;
        }

        /*cart*/

        .cart-action {
            border: none;
            color: red;
            font-size: 1.1em;
            font-weight: 600;
            background: transparent;
            transition: all 0.2s;
        }

        .cart-action:active {
            color: rgb(104, 0, 0);
            transform: translateY(1.5px);
        }

        .cart-content {
            padding: 0px 15px;
        }

        .cart-img {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .cart {
            width: fit-content;
            padding: 15px;
            border-radius: 15px;
            border: 0.25px solid #0000001c;
            display: flex;
        }

        .cart-body {
            padding: 15px;
            background: #fff;
            border-radius: 15px;
            border: 0.25px solid #0000001c;
            width: fit-content;
        }

        .cart-footer {
            padding: 10px;
            display: flex;
            justify-content: end;
            align-items: center;
            background: #0000000a;
        }

        .tab-to-buy {
            border: none;
            border-radius: 8px;
            background: darkslategray;
            font-weight: 600;
            color: #fff;
            transition: all 0.2s;
            padding: 0.5rem 2rem;
            width: 280px;
        }

        .tab-to-buy:active {
            background: rgba(47, 79, 79, 0.562);
            transform: translateY(1.5px);
        }

        .cart-footer-price {
            margin: 0rem 1.5rem;
        }

        footer {
            position: fixed;
            bottom: 0%;
            width: 100%;
            background: #fff;

        }

        .cart-menu-list {
            width: 480px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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
                        <li><a class="dropdown-item" href="openres.php">ลงทะเบียนร้านค้า</a></li>
                        <li><a class="dropdown-item" href="regrider.php">ลงทะเบียนไรเดอร์</a></li>
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


    <div class="container-fluid mt-5 mx-5">
        <h2 style="color: darkslategray;" class="mb-4 ms-3 fw-bold">ตะกร้า</h2>
        <?php if (isset($_SESSION['text'])): ?>
            <div class="alert alert-<?php echo $_SESSION['alert_color']; ?>"><?php echo $_SESSION['text']; unset($_SESSION['text']);unset($_SESSION['alert_color']);?></div>
        <?php endif; ?>
        <div class="row cart-body">
            <?php
            while ($r = $stmt->fetch()) {
            ?>
                <div class="col-md-6 me-2 col-sm-12 cart mb-3">
                    <img src="<?php echo $r['food_img']  ?>" class="cart-img" alt="">
                    <div class="cart-content">
                        <div class="cart-menu d-flex">
                            <span class="me-2 fw-bold">เมนู &nbsp; :</span><span class="cart-menu-list"><?php echo $r['food_name']  ?></span>
                        </div>
                        <div class="cart-price d-flex">
                            <span class="me-2 fw-bold">ราคา &nbsp; :</span><span><?php echo $r['food_price'] * (100 - $r['food_discount']) / 100 . " ฿" ?></span>
                        </div>
                        <div class="cart-quatity d-flex">
                            <span class="me-2 fw-bold">จำนวน &nbsp; :</span><span><?php echo $_SESSION['cart'][$r['food_id']] ?></span>
                        </div>
                        <div class="action d-flex justify-content-end">
                            <form action="../backend/cart.php" method="POST">
                                <input type="text" value="<?php echo $r['food_id'] ?>" name="id" hidden>
                                <input type="submit" class="cart-action" name="del" value="ลบ">
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                @$total += @$r['food_price'] * $_SESSION['cart'][$r['food_id']];
                $sid = $r['res_id'];
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

    <form action="../back/cart.php" method="POST">
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
                        <input type="text" name="sid" value="<?php echo $sid; ?>" id="" hidden>
                        <input type="text" name="id" value="<?php echo $_SESSION['id'] ?>" hidden>
                        <?php
                        $getItem = $db->query("SELECT * FROM item WHERE item_id IN ($ids)");
                        while ($gT = $getItem->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <input type="text" name="product[<?php echo $gT['item_id'] ?>][name]" value="<?php echo $gT['item_name'] ?>" hidden>
                            <input type="text" name="product[<?php echo $gT['item_id'] ?>][price]" value="<?php echo $gT['item_price'] * (100 - $gT['item_discount']) / 100 ?>" hidden>
                            <input type="text" name="product[<?php echo $gT['item_id'] ?>][id]" value="<?php echo $gT['item_id'] ?>" hidden>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" name="buy">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script src="../css/bootstrap.bundle.min.js"></script>
</body>

</html>