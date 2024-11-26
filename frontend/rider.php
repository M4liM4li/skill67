<?php
include_once "../backend/db.php";
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
  <div class="container mt-5">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-2 col-sm-12 mb-4">
        <div class="list-group list-group-flush">
          <a href="rider.php?page=status"
            class="text-decoration-none list-group-item  mt-2">รับงาน</a>
          <a href="rider.php?page=now"
            class="text-decoration-none list-group-item mt-2">ออเดอร์ปัจจุบัน</a>
          <a href="rider.php?page=history"
            class="text-decoration-none list-group-item mt-2">ประวัติการส่ง</a>
        </div>
      </div>
      <!-- Job Cards -->
      <div class="col-lg-8 col-sm-12">
      <?php if($_GET['page']=='status'){?>
        <?php
            $getOrder = $conn->query("SELECT * FROM tb_orders LEFT JOIN tb_res ON tb_orders.res_id = tb_res.res_id WHERE order_status = '1'");
            while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)){
            ?>
          <div class="card mt-3">
            <div class="card-body">
            <h5 class=" text-center">ออเดอร์</h5>
              <p>ชื่อร้าน : <?php echo $rw['res_name'];?></p>
              <p>ที่อยู่ร้านอาหาร :<?php echo $rw['res_address'];?></p>
              <p>ราคารวม :<?php echo $rw['order_total'];?></p>
              <p>สถานะ : <b class="text-success">ร้านอาหารกำลังทำอาหาร</b></p>
              <form action="../backend/rider.php" method="POST">
                <div class="col-sm-3">
                  <input type="text" value="<?php echo $rw['order_id']; ?>" hidden name="id">
                  <button type="submit" name="rub" class="btn btn-success">รับงาน</button>
                </div>
              </form>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
    <?php }else if($_GET['page'] == 'now'){?>
      <div class="row">
          <?php
          $getOrder = $conn->query("SELECT * FROM tb_orders LEFT JOIN tb_res ON tb_orders.res_id = tb_res.res_id LEFT JOIN tb_user ON tb_orders.order_uid = tb_user.uid WHERE tb_orders.order_status IN ('2', '3');");
          while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <!-- การจัดการคอลัมน์ให้แสดงออเดอร์หลายๆ อันในแถวเดียวกัน -->
              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class=" text-center">ออเดอร์</h5>
                      <div class="row"> 
                        <!-- คอลัมน์ข้อมูลออเดอร์ -->
                        <div class="col-md-6">
                          <h5 class="text-center mb-3">ข้อมูลร้านอาหาร</h5>
                          <p>ชื่อร้าน : <?php echo $rw['res_name']; ?></p>
                          <p>ที่อยู่ : <?php echo $rw['res_address']; ?> </p>
                          <h5 class="text-center mb-3">ข้อมูลลูกค้า</h5>
                          <p>ชื่อ : <?php echo $rw['fname']; ?></p>
                          <p>ที่อยู่ : <?php echo $rw['order_address']; ?> </p>
                          <p>ราคารวม : <?php echo $rw['order_total']; ?> บาท</p>
                          <?php if($rw['order_status'] == '2'){?>
                            <p>สถานะ : <b class="text-success">ไรเดอร์กำลังไปที่ร้านอาหาร</b></p>
                          <?php }else{?>
                            <p>สถานะ : <b class="text-success">กำลังไปส่งอาหารให้คุณ</b></p>
                          <?php }?>
                          <form action="../backend/rider.php" method="POST" class="mt-3">
                                  <input type="hidden" value="<?php echo $rw['order_id']; ?>" name="id">
                                  <?php if ($rw['order_status'] == '2') { ?>
                                    <button type="submit" class="btn btn-primary w-100" name="song">กำลังไปส่งอาหารให้คุณ</button>
                                  <?php } else if ($rw['order_status'] == '3') { ?>
                                    <button type="submit" class="btn btn-success w-100" name="success">ยืนยันการส่งและชำระเงิน</button>
                                  <?php } ?>
                          </form>
                        </div>
                        <!-- คอลัมน์รายการอาหาร -->
                        <div class="col-md-6">
                            <h6 class="text-center"><b>รายการอาหาร</b></h6>
                            <table class="table">
                              <thead>
                                <th>ชื่อ</th>
                                <th>จำนวน</th>
                                <th>ราคา</th>
                              </thead>
                              <?php
                              $id = $rw['order_id'];
                              $getDetail = $conn->query("SELECT * FROM tb_detail where order_id ='$id'");
                              while($rw2 = $getDetail->fetch(PDO::FETCH_ASSOC)){?>
                              <tbody>
                                <td><?php echo $rw2['food_name'];?></td>
                                <td><?php echo $rw2['food_qty'];?></td>
                                <td><?php echo $rw2['food_price'];?></td>
                              </tbody>                                  
                            </tbody>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
          <?php } ?>
      </div>
  </div>
  <?php } else if ($_GET['page'] == 'history') { ?>
    <div class="row">
        <?php
        $getOrder = $conn->query("
            SELECT * FROM tb_orders 
            LEFT JOIN tb_res ON tb_orders.res_id = tb_res.res_id 
            LEFT JOIN tb_user ON tb_orders.order_uid = tb_user.uid 
            WHERE tb_orders.order_status = '4';
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
                            <h5 class="text-center mb-3">ข้อมูลร้านอาหาร</h5>
                            <p>ชื่อร้าน : <?php echo $rw['res_name']; ?></p>
                            <p>ที่อยู่ : <?php echo $rw['res_address']; ?></p>
                            <h5 class="text-center mb-3">ข้อมูลลูกค้า</h5>
                            <p>ชื่อ : <?php echo $rw['fname']; ?></p>
                            <p>ที่อยู่ : <?php echo $rw['order_address']; ?></p>
                            <p>ราคารวม : <?php echo $rw['order_total']; ?> บาท</p>
                            <p>สถานะ : <b class="text-success"><?php echo str_replace('4', 'ส่งอาหารเสร็จสิ้น ชำระเงินเรียบร้อย', $rw['order_status']); ?></b></p>
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
<?php } ?>

</body>
<script src="../css/bootstrap.bundle.min.js"></script>

</html>
