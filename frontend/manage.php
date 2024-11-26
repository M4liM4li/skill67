
<?php
include_once "../backend/db.php";
if (isset($_POST['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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

    <?php 
$id = $_SESSION['id'];

$sql = $conn->query("SELECT tb_user.uid, tb_res.res_owner 
                     FROM tb_user 
                     LEFT JOIN tb_res ON tb_user.uid = tb_res.res_owner 
                     WHERE tb_user.uid = '$id'");
$rw = $sql->fetch(PDO::FETCH_ASSOC);

if ($rw && $rw['res_owner'] != $id) { 
?>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>สร้างร้านอาหาร</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="../backend/res.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">ชื่อร้านอาหาร</label>
                                <input type="text" class="form-control" name="rname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รายละเอียดร้านอาหาร</label>
                                <textarea class="form-control" name="rdetail" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ที่อยู่ร้านอาหาร</label>
                                <textarea class="form-control" name="raddress" rows="3" required></textarea>
                            </div>
                          
                            <div class="mb-3">
                                <label class="form-label">เลือกหมวดหมู่</label>
                                <select class="form-select" name="rtype" required>
                                    <option value="" disabled selected>-- กรุณาเลือกหมวดหมู่ --</option>
                                    <?php
                                        $sql = $conn->query("SELECT * FROM tb_type");
                                        while ($rw = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <option value="<?php echo $rw['type_id']; ?>"><?php echo $rw['type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รูปภาพร้านอาหาร</label>
                                <input type="file" class="form-control" name="rimg" required>
                            </div>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['id'];?>" hidden name="id">
                            <button type="submit" class="btn btn-success w-100" name="register">สร้างร้านอาหาร</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
} else { 
?>
    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <h3 class="text-center p-3">จัดการร้านค้า</h3>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=home">หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=res">จัดการร้านค้า</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=order">จัดการออเดอร์</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page="></a>
                        </li>
                        <hr>
                        <?php 
                         if(getUid($_SESSION['id'])['role'] != "admin"){?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=food">จัดการอาหาร</a>
                         </li>
                        <?php }?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=type">จัดการหมวดหมู่อาหาร</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </nav>

            <!-- Content Area -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <?php if($_GET['page']=='home'){?>
                    <!-- Form เลือกวันที่ -->
                    <form method="GET" class="mb-4" action="">
                    <input type="hidden" name="page" value="home"> 
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">วันที่เริ่มต้น</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" 
                                    value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">วันที่สิ้นสุด</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                    value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-4 align-self-end">
                                <button type="submit" class="btn btn-primary">แสดงรายงาน</button>
                            </div>
                        </div>
                    </form>
                    <!-- รายงานยอดขาย -->
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            $id = $_SESSION['id'];
                            // ค่าเริ่มต้นถ้าไม่มีการเลือกวันที่
                            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
                            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

                            // การ query ข้อมูลจากฐานข้อมูล
                            $sql = $conn->query("SELECT 
                                tb_res.res_name,
                                tb_orders.order_date,
                                SUM(tb_orders.order_total) AS total_sales,
                                COUNT(tb_orders.order_id) AS total_orders 
                            FROM 
                                tb_orders
                            JOIN 
                                tb_res ON tb_orders.res_id = tb_res.res_id
                            WHERE 
                                tb_orders.order_pay = '1' 
                                AND tb_orders.order_date BETWEEN '$start_date' AND '$end_date'
                                AND tb_res.res_owner = '$id'
                            GROUP BY 
                                tb_orders.order_date,
                                tb_res.res_name
                            ORDER BY 
                                tb_orders.order_date");

                            // ตัวแปรสำหรับเก็บยอดขายรวม
                            $total_sales_all_days = 0;
                            ?>
                            <h4>รายงานยอดขาย</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>ยอดขาย (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // ใช้ while loop เพื่อแสดงผลทุกแถว
                                    while ($rw = $sql->fetch(PDO::FETCH_ASSOC)) {
                                        $total_sales_all_days += $rw['total_sales']; // เพิ่มยอดขายแต่ละวันลงในตัวแปร $total_sales_all_days
                                    ?>
                                        <tr>
                                            <td><?php echo $rw['order_date']; ?></td>
                                            <td><?php echo number_format($rw['total_sales'], 2); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td><b>รวม</b></td>
                                        <td><b><?php echo number_format($total_sales_all_days, 2); ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }else if($_GET['page'] =='res'){ ?>
                    <div class="container mt-5">
                        <?php
                        $id = $_SESSION['id'];
                        $sql = $conn->query("SELECT * FROM tb_res where res_owner = '$id'");
                        $rw = $sql->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="row">
                            <!-- ฟอร์ม -->
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h3>แก้ไขข้อมูลร้านอาหาร</h3>
                                </div>

                                <form method="POST" action="../backend/res.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">ชื่อร้านอาหาร</label>
                                        <input type="text" class="form-control" name="rname" required value="<?php echo $rw['res_name'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">รายละเอียดร้านอาหาร</label>
                                        <textarea class="form-control" name="rdetail" rows="3" required><?php echo $rw['res_detail'] ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">เลือกหมวดหมู่</label>
                                        <select class="form-select" name="rtype" required>
                                            <option value="" disabled selected>-- กรุณาเลือกหมวดหมู่ --</option>
                                            <?php
                                            $sql = $conn->query("SELECT * FROM tb_type");
                                            while ($rw2 = $sql->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <option value="<?php echo $rw2['type_id']; ?>" <?php echo $rw['res_type'] == $rw2['type_id'] ? 'selected' : ''; ?>>
                                                    <?php echo $rw2['type_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">รูปภาพร้านอาหาร</label>
                                        <input type="file" class="form-control" name="rimg">
                                    </div>
                                    <input type="text" class="form-control" value="<?php echo $rw['res_id'] ?>" hidden name="id">
                                    <button type="submit" class="btn btn-success w-100" name="editres">บันทึกข้อมูล</button>
                                </form>
                            </div>
                            <!-- รูปภาพ -->
                            <div class="col-md-4 text-center">
                                <img src="../img/<?php echo $rw['res_img']; ?>" class="mb-3 user-img" alt="รูปภาพร้านอาหาร">
                            </div>
                        </div>
                    </div>

                    <?php }else if($_GET['page'] =='order'){ ?>
                    <div class="container mt-5">
                        <h2 class="text-center mb-4">จัดการออเดอร์</h2>
                        <div class="row">
                        <!-- Sidebar -->
                        <div class="col-lg-2 col-sm-12 mb-4">
                            <div class="list-group list-group-flush">
                                <a href="manage.php?page=order" class="text-decoration-none list-group-item ">ออเดอร์</a>
                                <a href="manage.php?page=history" class="text-decoration-none list-group-item ">ประวัติออเดอร์</a>
                            </div>
                        </div>
                        <!-- Job Cards -->
                        <div class="col-lg-8 col-sm-12">
                        <?php
                            $id = $_SESSION['id'];
                            $getOrder = $conn->query("
                            SELECT * FROM tb_orders 
                            LEFT JOIN tb_res ON tb_orders.res_id = tb_res.res_id 
                            LEFT JOIN tb_user ON tb_orders.order_uid = tb_user.uid 
                            WHERE tb_orders.order_status != '4' AND res_owner = '$id';
                        ");
                            while($rw = $getOrder->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                       <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="text-center">ออเดอร์</h5>
                                        <div class="row">
                                            <!-- คอลัมน์ข้อมูลออเดอร์ -->
                                            <div class="col-md-6">
                                                <h5 class="text-center mb-3">ข้อมูลลูกค้า</h5>
                                                <p>ชื่อ : <?php echo $rw['fname']; ?></p>
                                                <p>ที่อยู่ : <?php echo $rw['order_address']; ?></p>
                                                <p>ราคารวม : <?php echo $rw['order_total']; ?> บาท</p>
                                                <?php if($rw['order_status']=='0'){?>
                                                    <p>สถานะ : <b class="text-danger">ยังไม่ได้รับออเดอร์</b></p>
                                                <?php } else if($rw['order_status']=='1'){?>
                                                    <p>สถานะ : <b class="text-success">กำลังทำอาหาร</b></p>
                                                <?php }else if($rw['order_status']=='2'){?>
                                                    <p>สถานะ : <b class="text-success">ไรเดอร์กำลังมารับอาหาร</b></p>
                                                <?php }else{?>
                                                    <p>สถานะ : <b class="text-success">ไรเดอร์กำลังไปส่งอาหาร</b></p>
                                                <?php }?>
                                            </div>
                                            <!-- คอลัมน์รายการอาหาร -->
                                            <div class="col-md-6">
                                                <h6 class="text-center"><b>รายการอาหาร</b></h6>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ชื่อ</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $id = $rw['order_id'];
                                                        $getDetail = $conn->query("SELECT * FROM tb_detail WHERE order_id = '$id'");
                                                        while ($rw2 = $getDetail->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr>
                                                                <td><?php echo $rw2['food_name']; ?></td>
                                                                <td><?php echo $rw2['food_qty']; ?></td>
                                                                <td><?php echo $rw2['food_price']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                       
                                                    </tbody>
                                                </table>
                                               
                                            </div>
                                           
                                        </div>
                                        <form action="../backend/order.php" method="POST">
                                        <div class="text-center mt-4">
                                            <input type="text" value="<?php echo $rw['order_id']; ?>" hidden name="id">
                                            <?php if($rw['order_status']=='0'){?>
                                                <button type="submit" name="rub" class="btn btn-success me-3">รับออเดอร์</button>
                                            <?php } else{?>
                                                <b class="text-success">รับออร์นี้แล้ว</b>
                                            <?php }?>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                <?php }else if($_GET['page'] =='history'){ ?>
                    <div class="container mt-5">
                        <h2 class="text-center mb-4">จัดการออเดอร์</h2>
                        <div class="row">
                        <!-- Sidebar -->
                        <div class="col-lg-2 col-sm-12 mb-4">
                            <div class="list-group list-group-flush">
                                <a href="manage.php?page=order" class="text-decoration-none list-group-item ">ออเดอร์</a>
                                <a href="manage.php?page=history" class="text-decoration-none list-group-item ">ประวัติออเดอร์</a>
                            </div>
                        </div>
                        <!-- Job Cards -->
                        <div class="col-lg-8 col-sm-12">
                        <div class="row">
                            <?php
                            $id = $_SESSION['id'];
                            $getOrder = $conn->query("
                                SELECT * FROM tb_orders 
                                LEFT JOIN tb_res ON tb_orders.res_id = tb_res.res_id 
                                LEFT JOIN tb_user ON tb_orders.order_uid = tb_user.uid 
                                WHERE tb_orders.order_status = '4' AND res_owner = '$id';
                            ");
                            while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <!-- การจัดการคอลัมน์ให้แสดงออเดอร์หลายๆ อันในแถวเดียวกัน -->
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="text-center">ออเดอร์</h5>
                                        <div class="row">
                                            <!-- คอลัมน์ข้อมูลออเดอร์ -->
                                            <div class="col-md-6">
                                                <h5 class="text-center mb-3">ข้อมูลลูกค้า</h5>
                                                <p>ชื่อ : <?php echo $rw['fname']; ?></p>
                                                <p>ที่อยู่ : <?php echo $rw['order_address']; ?></p>
                                                <p>ราคารวม : <?php echo $rw['order_total']; ?> บาท</p>
                                                <p>สถานะ : <b class="text-success"><?php echo str_replace('4', 'ลูกค้าได้รับอาหาร ชำระเงินเรียบร้อย', $rw['order_status']); ?></b></p>
                                            </div>
                                            <!-- คอลัมน์รายการอาหาร -->
                                            <div class="col-md-6">
                                                <h6 class="text-center"><b>รายการอาหาร</b></h6>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>ชื่อ</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคา</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $id = $rw['order_id'];
                                                        $getDetail = $conn->query("SELECT * FROM tb_detail WHERE order_id = '$id'");
                                                        while ($rw2 = $getDetail->fetch(PDO::FETCH_ASSOC)) { ?>
                                                            <tr>
                                                                <td><?php echo $rw2['food_name']; ?></td>
                                                                <td><?php echo $rw2['food_qty']; ?></td>
                                                                <td><?php echo $rw2['food_price']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                <!-- This is a comment -->
                <?php } else if($_GET['page'] =='food' ){?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>จัดการอาหาร</h2>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFood">เพิ่มอาหาร</button>
                </div>
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <th>ID</th>
                        <th>รูปอาหาร</th>
                        <th>ชื่อ</th>
                        <th>ราคา</th>
                        <th>หมวดหมู่</th>
                    </thead>
                    <?php
                    $id = $_SESSION['id'];
                    $sql=$conn->query("SELECT * FROM tb_food INNER JOIN tb_res ON tb_food.res_id = tb_res.res_id INNER JOIN food_cate ON tb_food.food_type = food_cate.cate_id WHERE res_owner = '$id'");
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row['food_id'];?></td>
                            <td><img src="../img/<?php echo $row['food_img'];?>" alt="" height="30px"></td>
                            <td><?php echo $row['food_name'];?></td>
                            <td><?php echo $row['food_price'];?></td>
                            <td><?php echo $row['cate_name'];?></td>

                        </tr>
                    </tbody>
                    <?php }?>
                </table>
                <?php } else if($_GET['page'] =='type' ){?>
                    <div class="container mt-4">
                        <h1>จัดการหมวดหมู่อาหาร</h1>
                    </div>
                    <div class="container mt-4 mb-4">
                        <!-- start form-->
                        
                        <div class="mt-2 border p-4">
                            <h3 class="mb-4">ฟอร์มเพิ่มหมวดหมู่อาหาร</h3>
                            <form method="POST" action="../backend/food.php" class="mb-2">
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <b>ชื่อประเภทอาหาร</b>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="catename" class="form-control" placeholder="ชื่อประเภทอาหาร">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-2">
                                    </div>
                                   
                                    <div class="col-10">
                                    <?php
                                     $id = $_SESSION['id'];
                                     $getRes = $conn->query("SELECT * FROM tb_res where res_owner = '$id'");
                                     $res = $getRes->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                        <input type="text" class="btn btn-success" name="id" value="<?php echo $res['res_id']?>" hidden>
                                        <input type="submit" class="btn btn-success" name="foodcate" value="เพิ่มข้อมูล">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end form -->
                        <!-- start form-->
                        <div class="my-2 border p-4">
                            <h3>หมวดหมู่อาหาร</h3>
                            <form action="../backend/food.php" method="POST">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>ชื่อประเภทอาหาร</th>
                                    <th class="text-center">ลบ</th>
                                </thead>
                                <tbody>
                                <?php
                                    $rid = $_SESSION['id'];
                                    $sql = $conn->query("SELECT * FROM food_cate inner join tb_res on tb_res.res_id = food_cate.cate_rid where res_owner = '$rid'");
                                    while($rw = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <tr>
                                        <td><?php echo $rw['cate_id'];?></td>
                                        <td><?php echo $rw['cate_name'];?></td>
                                        <td align="center">
                                            <form action="../backend/admin/type.php" method="POST">
                                                <input type="text" value="<?php echo $rw['cate_id']; ?>" hidden name="id">
                                                <button class="btn btn-danger me-2" name="delfoodcate">ลบ</button>
                                            </form>
                                        </td>
                                    </tr> 
                                <?php } ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                        <!-- end form -->
                    </div>
                <?php } ?>
                
            </main>
        </div>
    </div>
<!-- modal-->
    <form action="../backend/food.php" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="addFood">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>เพิ่มรายการอาหาร</h3>
                    <button class="btn btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label mt-2">ชื่ออาหาร</label>
                    <input type="text" class="form-control" name="foodname" required>
                    <label class="form-label mt-2">ราคา</label>
                    <input type="text" class="form-control" name="foodprice" required>
                    <label class="form-label mt-2">ประเภท</label>
                    <select class="form-control" name="foodtype">
                        <option disabled selected>เลือกประเภทอาหาร</option>
                    <?php
                        $rid = $_SESSION['id'];
                        $getType =$conn->query("SELECT * FROM food_cate INNER JOIN tb_res ON food_cate.cate_rid = tb_res.res_id where res_owner = '$rid'");
                        while($row = $getType->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <option value="<?php echo $row['cate_id'];?>"><?php echo $row['cate_name'];?></option>
                    <?php }?>
                    </select>
                    <label class="form-label mt-2">รูปอาหาร</label>
                    <input type="file" class="form-control" name="foodimg" required>
                </div>
                <div class="modal-footer">
                    <?php 
                        $rid = $_SESSION['id'];

                        $getRes = $conn->query("SELECT * FROM tb_res where res_owner='$id'");
                        $res = $getRes->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <input type="text" class="form-control" name="id" value="<?php echo $res['res_id']?> " hidden>
                    <button class="btn btn-success" name="add">เพิ่ม</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php 
} 
?>
</body>
<script src="../css/bootstrap.bundle.min.js"></script>

</html>
                           