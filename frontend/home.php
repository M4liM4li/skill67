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
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">

</head>

<body>
  <!--navbar-->
  <nav class="navbar nav-expand shadow-lg">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand" href="home.php">
        <strong style="color:blue; font-size: 1.5rem;" class="ms-3">KTP</strong> Delivery
      </a>
      <div class="d-flex align-items-center responsive mt-auto">
        <!--off-btn-->
        <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" class="offcanvas-btn">
          <p style="transform: rotate(90deg);">
            | | |</p>
        </button>
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

  <!-- hero -->
  <div class="container col-xxl-8 px-4 py-3 ">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="../img/ed4e96ec-3cb1-47cf-9eac-f5363b060a0e.jpg" class="d-block mx-lg-auto img-fluid" width="700" height="500" loading="lazy" style="border-radius: 28px;">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 lh-1">KTP Delivery</h1>
        <p class="display-4 fw-bold lh-1 pt-1 text-success">อยากกิน ต้องได้กิน</p>
      </div>
    </div>
  </div>
  <!-- hero -->

  <!-- test -->
  <div class="container-fluid ">
    <div class="row">
      <div class="col-md-3">
        <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 280px;">
          <span class="fs-4">Shop Categories</span>
          <hr>
          <ul class="nav nav-pills flex-column mb-auto">
            <form action="home.php" class="me-4">
              <input type="search" name="search" class="form-control me-2 " placeholder="Seacrh" required>
            </form>
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


      <div class="col-lg-9 col-sm-12">
        <div class="row nopadding">
          <?php if (isset($_GET['type'])) { ?>
            <?php
            $type = $_GET['type'];
            $getFood = $conn->query("SELECT * FROM tb_res WHERE res_status = '1' AND res_type = '$type'");
            while ($rw = $getFood->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 index-store">
                <a href="store.php?rid=<?php echo $rw['res_id'] ?>" class="text-decoration-none">
                  <img src="../img/<?php echo $rw['res_img'] ?>" class="index-store-img">
                  <div class="index-store-content">
                    <p class="index-store-review"><?php echo getRate($rw['res_id'])['rate'] ?></p>
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
                <a href="store.php?rid=<?php echo $rw['res_id'] ?>" class="text-decoration-none">
                  <img src="../img/<?php echo $rw['res_img'] ?>" class="index-store-img">
                  <div class="index-store-content">
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
<script src="../css/bootstrap.bundle.min.js"></script>

</html>