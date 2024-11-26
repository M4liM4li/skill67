<?php
include_once "../backend/db.php";
if(getUid($_SESSION['id'])['role'] == 'ban'){
    header("location: ../index.php");

  };

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Registration - Details and Qualifications</title>
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
        <h1 class="text-center mb-4">เปิดร้านอาหาร</h1>
        <?php if (isset($_SESSION['text'])): ?>
          <div class="alert alert-<?php echo $_SESSION['alert_color']; ?>"><?php echo $_SESSION['text']; unset($_SESSION['text']);unset($_SESSION['alert_color']);?></div>
        <?php endif; ?>
        <section id="details" class="mb-5">
            <h2>Details</h2>
            <p>Welcome to the restaurant registration page. Please fill in the necessary information about your restaurant to complete the registration process.</p>
        </section>

        <section id="qualifications" class="mb-5">
            <h2>Qualifications</h2>
            <ul>
                <li><i class=""></i> Must have valid business licenses and permits.</li>
                <li><i class=""></i> Compliance with health and safety regulations.</li>
                <li><i class=""></i> Valid ID for the owner(s).</li>
                <li><i class=""></i> Proof of the restaurant's business address.</li>
            </ul>
        </section>
        <form class="col-12 text-center" method="POST" action="../backend/res.php">
            <input type="text" class="form-control" value="<?php echo $_SESSION['id'] ?> " name="id" hidden>
            <button type="submit" class="btn btn-success btn-lg" name="po">ลงทะเบียนร้านอาหาร</button>
        </form>
    </div>
</body>
<script src="../css/bootstrap.bundle.min.js"></script>

</html>
