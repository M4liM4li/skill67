<?php
include_once "../backend/db.php";
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
          
        </ul>
        <!-- User avatar dropdown -->
        <div class="dropdown">
        <a class="link-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="profile-img" src="../img/<?php echo getUid($_SESSION['id'])['userimg'] ?>"></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">จัดการข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item" href="openres.php">ลงทะเบียนร้านค้า</a></li>
            <li><a class="dropdown-item" href="regrider.php">ลงทะเบียนไรเดอร์</a></li>
            <?php if(getUid($_SESSION['id'])['role'] == "admin"){ ?>
            <hr>
              <li><a href="admin.php?page=user" class="dropdown-item">เมนูแอดมิน</a></li>
            <?php } if(getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "rider"){?>
            <hr>
              <li><a href="rider.php?page=status" class="dropdown-item">หน้ารับงานไรเดอร์</a></li>
            <?php } if(getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "owner"){?>
              <hr>
              <li><a href="manage.php?page=status" class="dropdown-item">จัดการหลังบ้าน</a></li>
            <?php }?>
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
          $getOrder = $conn->query("SELECT * FROM tb_order LEFT JOIN tb_res ON tb_order.res_id = tb_res.res_id WHERE order_status = '1'");
          while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)){
          ?>
        <div class="card mt-3">
          <div class="card-body">
          <h5 class="card-title text-center">ออเดอร์</h5>
            <p class="card-text">ชื่อร้าน : <?php echo $rw['res_name'];?></p>
            <p class="card-text">ที่อยู่ร้านอาหาร :<?php echo $rw['res_address'];?></p>
            <p class="card-text">ราคารวม :<?php echo $rw['order_total'];?></p>
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
    <?php
          $getOrder = $conn->query("SELECT * FROM tb_order LEFT JOIN tb_res ON tb_order.res_id = tb_res.res_id WHERE order_status IN ('2', '3');");
          while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)){
          ?>
        <div class="card mt-3">
          <div class="card-body">
          <h5 class="card-title text-center">ออเดอร์</h5>
            <p class="card-text">ชื่อร้าน : <?php echo $rw['res_name'];?></p>
            <p class="card-text">เมนู : <?php echo $rw['order_total'];?></p>
            <p class="card-text">ที่อยู่ :</p>
            <p class="card-text">ราคารวม :<?php echo $rw['order_total'];?></p>
            <form action="../backend/rider.php" method="POST" class="row g-3 align-items-center mt-2">
                <div class="col-sm-4">
                  <?php if($rw['order_status'] == '2'){?>
                    <input type="text" value="<?php echo $rw['order_id']; ?>" hidden name="id">
                    <button type="submit" class="btn btn-primary w-100" name="song">กำลังไปส่งอาหารให้คุณ</button>
                  <?php }else if($rw['order_status'] == '3'){?>
                    <input type="text" value="<?php echo $rw['order_id']; ?>" hidden name="id">
                    <button type="submit" class="btn btn-success w-100" name="success">ส่งอาหารเสร็จสิ้น</button>
                    <?php }?>
                </div>
            </form>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
  <?php }else if($_GET['page'] == 'history'){?>
    <?php
          $getOrder = $conn->query("SELECT * FROM tb_order LEFT JOIN tb_res ON tb_order.res_id = tb_res.res_id WHERE order_status ='4'");
          while ($rw = $getOrder->fetch(PDO::FETCH_ASSOC)){
          ?>
        <div class="card mt-3">
          <div class="card-body">
          <h5 class="card-title text-center">ออเดอร์</h5>
            <p class="card-text">ชื่อร้าน : <?php echo $rw['res_name'];?></p>
            <p class="card-text">เมนู : <?php echo $rw['order_total'];?></p>
            <p class="card-text">ที่อยู่ : </p>
            <p class="card-text">ราคารวม :<?php echo $rw['order_total'];?></p>
            <p class="card-text text-success"><?php echo str_replace('4', 'ส่งอาหารเสร็จสิ้น', $rw['order_status']); ?></p>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
  <?php }?>
</body>

</html>
