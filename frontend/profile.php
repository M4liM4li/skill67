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
    <title>User Profile - eCommerce</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        .user-img {
            width: 200px;
            height: 200px;
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
        <ul class="navbar-nav ms-auto">
         
        </ul>
        <!-- User avatar dropdown -->
        <div class="dropdown">
        <a class="link-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><img class="profile-img" src="../img/<?php echo getUid($_SESSION['id'])['userimg'] ?>"></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">จัดการข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item" href="openres.php">ลงทะเบียนร้านค้า</a></li>
            <li><a class="dropdown-item" href="rerider.php">ลงทะเบียนไรเดอร์</a></li>
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
    <h2 class="text-center mb-4">ข้อมูลส่วนตัว</h2>
    <div class="row">
        <div class="col-md-4 mb-4"> 
            <div class="card">
                <div class="card-body text-center">
                  <?php
                   $id = $_SESSION['id'];
                   $getUser = $conn->query("SELECT * FROM tb_user where uid = '$id'");
                   $rw = $getUser->fetch();
                  
                  ?>
                    <img src="../img/<?php echo $rw['userimg']; ?>" class="mb-3  user-img">
                    <h5 class="card-title"><?php echo $rw['fname'];?></h5>
                    <p class="card-text"><?php echo $rw['email'];?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                <?php if (isset($_SESSION['text'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['alert_color']; ?>"><?php echo $_SESSION['text']; unset($_SESSION['text']);unset($_SESSION['alert_color']);?></div>
                <?php endif; ?>
                    <form action="../backend/admin/user.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" name="fname" value="<?php echo $rw['fname'];?>" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" name="lname" value="<?php echo $rw['lname'];?>" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo $rw['email'];?>" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">โปรไฟร์</label>
                            <input type="file" id="currentFile" class="form-control mb-2" name="userimg">
                        </div>
                        <input type="text" class="form-control" name="id" value="<?php echo $_SESSION['id'];?> " hidden>
                        <button type="submit" class="btn btn-success" name="useredit" >บันทึก</button>
                    </form>
                </div>
                <h2 class="text-center mb-4">เปลี่ยนรหัสผ่าน</h2>
                <div class="card-body">
                    <form action="../backend/admin/user.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่านเดิม</label>
                            <input type="text" class="form-control" name="oldpass">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่านใหม่</label>
                            <input type="text" class="form-control mb-2 " name="newpass">
                        </div>
                        <input type="text" class="form-control" name="id" value="<?php echo $_SESSION['id'];?> " hidden>
                        <button type="submit" class="btn btn-success" name="passedit"  onclick="confirmChange()">เปลี่ยนรหัสผ่าน</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>