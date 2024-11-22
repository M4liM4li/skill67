<?php
include_once "../backend/db.php";

if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    header("Location: ../index.php");
    exit;
}
if (getUid($_SESSION['id'])['role'] == 'ban') {
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

        .index-store-img {
            width: 315px;
            height: 180px;
            border-radius: 20px;
            object-fit: cover;
            overflow: hidden;
        }

        /*index-store*/

        .index-store {
            width: 335px;
            height: 300px;
            overflow: hidden;
            border-radius: 20px;
            padding: 10px;
        }

        .index-store-img {
            width: 315px;
            height: 120px;
            border-radius: 20px;
            object-fit: cover;
            overflow: hidden;
        }

        .index-store-content {
            color: darkslategray;
            padding: 15px;
        }

        .index-store-review {
            position: absolute;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.1em;
            font-weight: 600;
            color: #fff;
            background: darkslategray;
            margin-left: 250px;
        }

        .index-store-content {
            color: darkslategray;
            padding: 15px;
        }

        /*cart-btn*/
        .cart-btn {
            position: fixed;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            right: 5rem;
            bottom: 5rem;
            background: #fff;
        }

        .cart-btn-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        /*modalproduct*/

        .product-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .modal-product-detail {
            padding: 1rem;
            color: darkslategray;
        }

        .modal-content-product {
            overflow: hidden;
        }

        .modal-footer {
            display: flex;
            justify-content: end;
            padding: 10px;
        }

        .product-quatity {
            display: flex;
            align-items: center;
        }

        .pro-quatity {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 0.25px solid darkslategray;
            font-weight: 600;
            justify-content: center;
            color: darkslategray;
            background: rgba(47, 79, 79, 0.432);
            display: flex;
            margin: 0rem 0.5rem;
            transition: all 0.2s;
        }

        .pro-quatity:active {
            background: darkslategray;
            transform: translateY(1px);
            color: #fff;
        }

        .pro-num {
            border: none;
            background: transparent;
            outline: transparent;
            font-size: 1.2em;
            font-weight: 600;
            width: 43px;
            padding: 0rem 1rem;
        }

        .getcart {
            padding: 0.2rem 2.3rem;
            border-radius: 5px;
            border: none;
            color: #fff;
            background: darkslategray;
            font-weight: 600;
            transition: all 0.2s;
        }

        .getcart:active {
            transform: translateY(1.5px);
            background: rgba(47, 79, 79, 0.493);
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

    <!-- hero -->
    <?php
    $sid = $_GET['sid'];
    $rs = $conn->query("SELECT * FROM tb_res WHERE res_id = '$sid'");
    $rw = $rs->fetch();
    ?>
    <div class="container col-xxl-8 px-4 py-3">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="../img/<?php echo $rw['res_img'] ?>" class="d-block mx-lg-auto img-fluid" width="700" height="500" loading="lazy" style="border-radius: 28px;">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3"><?php echo $rw['res_name'] ?></h1>
                <p class="lead"> <?php echo $rw['res_detail'] ?> </p>
            </div>
        </div>
    </div>
    <!-- hero -->
    <hr>

    <!-- test -->
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-2 col-xs-none col-2-category">
                <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 280px;">
                    <span class="fs-4">Food Categories</span>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <a href="home.php" class="nav-link link-dark hold">ทั้งหมด</a>
                        <?php
                        $getType = $stmt = $conn->query("SELECT * FROM tb_type");
                        while ($rw = $getType->fetch()) {
                        ?>
                            <li>
                                <a href="store.php?sid=<?php echo $sid ?>?type=<?php echo $rw['type_id'] ?>" class="nav-link link-dark hold">
                                    <?php echo $rw['type_name'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <hr>
                </div>
            </div>


            <!-- food -->
            <div class="col-lg-10 col-sm-12">
                <div class="row nopadding">
                    <?php if (isset($_GET['type'])) { ?>
                        <?php
                        $sid = $_GET['sid'];
                        $type = $_GET['type'];
                        $getFood = $conn->query("SELECT * FROM tb_res WHERE res_status = '1' AND res_type = '$type'");
                        while ($rw = $getFood->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                                <a href="#Modalproduct" data-bs-toggle="modal" data-target="#Modalproduct" class="text-decoration-none" onclick="viewItem('<?php echo $r['food_name'] ?>','<?php echo $r['food_price'] ?>','<?php echo $r['food_discount'] ?>','<?php echo $r['food_img'] ?>','<?php echo $r['food_id'] ?>')">
                                    <img src="../img/<?php echo $rw['res_img'] ?>" class="index-store-img">
                                    <div class="index-store-content">
                                        <!-- rate -->
                                        <h5 class="fw-bold"><?php echo $rw['res_name'] ?></h5>
                                        <p><?php echo $rw['res_detail'] ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?php
                        $sid = $_GET['sid'];
                        $search = @$_GET['search'];
                        $getFood = $conn->query("SELECT * FROM tb_food WHERE food_name LIKE '%$search%' AND res_id = '$sid'");
                        while ($rw = $getFood->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                                <a href="#Modalproduct" data-bs-toggle="modal" data-target="#Modalproduct" class="text-decoration-none" onclick="viewItem('<?php echo $rw['food_name'] ?>','<?php echo $rw['food_price'] ?>','<?php echo $rw['food_discount'] ?>','<?php echo $rw['food_img'] ?>','<?php echo $rw['food_id'] ?>')">
                                    <img src="../img/<?php echo $rw['food_img'] ?>" class="index-store-img">
                                    <div class="index-store-content">
                                        <h5 class="fw-bold"><?php echo $rw['food_name'] ?></h5>
                                        <p><?php if (!empty($rw['food_discount'])) { ?>
                                                <h7 class="text-danger"><s><?php echo $rw['food_price'] . " ฿" ?></s></h7>
                                                <h7 class="text-success"><?php echo $rw['food_price'] * (100 - $rw['food_discount']) / 100 . " ฿"; ?></h7>
                                            <?php } else {
                                                echo $rw['food_price'] . " ฿";
                                            } ?>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- food -->

            <!--modalpoduct-->
            <form action="../backend/cart.php" method="POST">
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
                                <button type="submit" class="getcart" name="addCart">ใส่ตะกร้า</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <script src="../css/bootstrap.bundle.min.js"></script>
            <script src="main.js"></script>

            <!-- cart -->
            <div class="cart-btn shadow-sm">
                <a href="cart.php">
                    <img src="../img/basket.png" class="cart-btn-img" alt="">
                </a>
            </div>
        </div>
    </div>

    <!-- test -->
    </div>
</body>

</html>