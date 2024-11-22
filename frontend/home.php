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
  <div class="container my-5">
    <div class="row pb-0 pe-lg-0 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
        <h1 class="display-5 lh-1">KTP Delivery</h1>
        <p class="display-4 fw-bold lh-1 pt-1 text-success">อยากกิน ต้องได้กิน</p>
        <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3 pt-5">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Primary</button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
        </div> -->
      </div>
      <div class="col-lg-5 offset-lg-1 p-0 overflow-hidden shadow-lg" style="margin-left: 0px;">
        <img class=" rounded-lg-3" src="../img/ed4e96ec-3cb1-47cf-9eac-f5363b060a0e.jpg" alt="" width="920">
      </div>
    </div>
  </div>
  <!-- hero -->

  <!-- test -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-2 col-xs-none col-2-category">
        <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 280px;">
          <span class="fs-4">Shop Categories</span>
          <hr>
          <ul class="nav nav-pills flex-column mb-auto">
            <a href="home.php" class="nav-link link-dark hold">ทั้งหมด</a>
            <?php
            $getType = $stmt = $conn->query("SELECT * FROM tb_type");
            while ($rw = $getType->fetch()) {
            ?>
              <li>
                <a href="home.php?type=<?php echo $rw['type_id'] ?>" class="nav-link link-dark hold">
                  <?php echo $rw['type_name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
          <hr>
        </div>
      </div>


      <div class="col-lg-10 col-sm-12">
        <div class="row nopadding">
          <?php if (isset($_GET['type'])) { ?>
            <?php
            $type = $_GET['type'];
            $getFood = $conn->query("SELECT * FROM tb_res WHERE res_status = '1' AND res_type = '$type'");
            while ($rw = $getFood->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                <a href="store.php?sid=<?php echo $rw['res_id'] ?>" class="text-decoration-none">
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
            $search = @$_GET['search'];
            $getFood = $conn->query("SELECT * FROM tb_res WHERE res_status = '1' AND res_name LIKE '%$search%'");
            while ($rw = $getFood->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                <a href="store.php?sid=<?php echo $rw['res_id'] ?>" class="text-decoration-none">
                  <img src="../img/<?php echo $rw['res_img'] ?>" class="index-store-img">
                  <div class="index-store-content">
                    <p class="index-store-review"><?php echo getRate($rw['res_id'])['rate'] ?></p>
                    <h5 class="fw-bold"><?php echo $rw['res_name'] ?></h5>
                    <p><?php echo $rw['res_detail'] ?></p>
                  </div>
                </a>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>

  <!-- test -->
  </div>
</body>

</html>