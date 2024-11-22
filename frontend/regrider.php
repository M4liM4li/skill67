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
            <li><a class="dropdown-item" href="">ลงทะเบียนไรเดอร์</a></li>
            <?php if(getUid($_SESSION['id'])['role'] == "admin"){ ?>
            <hr>
              <li><a href="admin.php?page=user" class="dropdown-item">เมนูแอดมิน</a></li>
            <?php } if(getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "rider"){?>
            <hr>
              <li><a href="rider.php?page=status" class="dropdown-item">หน้ารับงานไรเดอร์</a></li>
            <?php } if(getUid($_SESSION['id'])['role'] == "admin" || getUid($_SESSION['id'])['role'] == "owner"){?>
              <hr>

              <li><a href="manage.php?page=home" class="dropdown-item">จัดการหลังบ้าน</a></li>
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
        <h1 class="text-center mb-4">สมัครเป็นไรเดอร์</h1>
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
        <form class="col-12 text-center" method="POST" action="../backend/regrider.php">
            <input type="text" class="form-control" value="<?php echo $_SESSION['id'] ?> " name="id" hidden>
            <button type="submit" class="btn btn-success btn-lg" name="pr">ลงทะเบียนไรเดอร์</button>
        </form>
    </div>
</body>
</html>
