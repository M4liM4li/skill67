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
    <div class="container d-flex justify-content-between align-items-center ">
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

    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-12 col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky">
                <h3 class="text-center p-3">Admin</h3>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="admin.php?page=user">จัดการผู้ใช้</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="admin.php?page=rider">จัดการไรเดอร์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="admin.php?page=owner">จัดการเจ้าของร้าน</a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="admin.php?page=res">จัดการร้านอาหาร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="admin.php?page=type">จัดการหมวดหมู่ร้าน</a>
                    </li>
                </ul>
            </div>
        </nav>

            <!-- Content Area -->
            <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4">
                <?php if (isset($_SESSION['text'])): ?>
                    <div class="alert mt-2 alert-<?php echo $_SESSION['alert_color']; ?>"><?php echo $_SESSION['text']; unset($_SESSION['text']);unset($_SESSION['alert_color']);?></div>
                <?php endif; ?>
                <?php if ($_GET['page'] == 'user') { ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>จัดการผู้ใช้</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addUser">เพิ่มสมาชิก</button>
                </div>
                <!-- User Table -->
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ชื่อจริง</th>
                            <th>นามสกุล</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = $conn->query("SELECT * FROM tb_user WHERE role != 'admin'");
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $row['uid']; ?></td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo str_replace('pr', 'รออนุมัติ', $row['role']); ?></td>
                            <td>
                                <?php if ($row['role'] != 'ban') { ?>
                                <form action="../backend/admin/user.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['uid']; ?>">
                                    <button class="btn btn-danger" name="ban">ระงับ</button>
                                </form>
                                <?php } else { ?>
                                <form action="../backend/admin/user.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['uid']; ?>">
                                    <button class="btn btn-success" name="unban">ปลดระงับ</button>
                                </form>
                                <?php } ?>
                            </td>
                            <td class="d-flex">
                                <form action="admin.php?page=edit" method="POST">
                                    <input type="text" value="<?php echo $row['uid']; ?>" hidden name="id">
                                    <button class="btn btn-success me-2" name="edit">แก้ไข</button>
                                </form>
                                <form action="../backend/admin/user.php" method="POST">
                                    <input type="text" value="<?php echo $row['uid']; ?>" hidden name="id">
                                    <button class="btn btn-danger" name="del" onclick="return confirm('ต้องการลบข้อมูลใช่หรือไม่?')">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else if($_GET['page'] == 'rider') { ?>
                <!-- Rider management section -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>จัดการไรเดอร์</h2>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addUser">เพิ่มสมาชิก</button>
                </div>
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ชื่อจริง</th>
                            <th>นามสกุล</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = $conn->query("SELECT * FROM tb_user WHERE role='rider' OR role='pr'");
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $row['uid']; ?></td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo str_replace('pr', 'รออนุมัติ', $row['role']); ?></td>

                            <td>
                                <?php if($row['role'] == 'rider'){ ?>
                                <form action="../backend/admin/rider.php" method="POST">
                                    <input type="text" value="<?php echo $row['uid']; ?>" hidden name="id">
                                    <button class="btn btn-danger" name="rem">ระงับ</button>
                                </form>
                                <?php } else if($row['role'] == 'pr'){ ?>
                                <form action="../backend/admin/rider.php" method="POST">
                                    <input type="text" value="<?php echo $row['uid']; ?>" hidden name="id">
                                    <button class="btn btn-success" name="acc">อนุมัติ </button>
                                    <button class="btn btn-danger" name="del">ลบคำขอ </button>
                                </form>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php }else if($_GET['page'] == 'owner'){ ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>จัดการเจ้าของร้าน</h2>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addUser">เพิ่มสมาชิก</button>
                </div>
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ชื่อ</th>
                            <th>คำอธิบายร้าน</th>
                            <th>รูปแบบ</th>
                            <th>สถานะ</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = $conn->query("SELECT * FROM tb_user WHERE role='owner' OR role='po'");
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $row['uid'];?></td>
                            <td><?php echo $row['fname'];?></td>
                            <td><?php echo $row['lname'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo str_replace('po', 'Pending', str_replace('owner', 'Active', $row['role'])); ?></td>
                            <td>
                                <?php if($row['role'] == 'owner'){ ?>
                                <form action="../backend/admin/owner.php" method="POST">
                                    <input type="text" value="<?php echo $row['uid'] ?>" hidden name="id">
                                    <button class="btn btn-danger" name="rem">ระงับ</button>
                                </form>
                                <?php }else if($row['role'] == 'po'){ ?>
                                <form action="../backend/admin/owner.php" method="POST">
                                    <input type="text" value="<?php echo $row['uid'] ?>" hidden name="id">
                                    <button class="btn btn-success" name="acc">อนุมัติ </button>
                                    <button class="btn btn-danger" name="del">ลบคำขอ </button>
                                </form>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php }else if($_GET['page'] == 'edit'){ ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>แก้ไขผู้ใช้</h2>
                </div>
               <?php
                $id = $_POST['id'];
                $sql = $conn->query("SELECT * FROM tb_user WHERE uid = $id");
                $row = $sql->fetch(PDO::FETCH_ASSOC)
               ?>
                <div class="col-6">
                <form method="POST" action="../backend/admin/user.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" name="fname" required value="<?php echo $row['fname'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" name="lname" required value="<?php echo $row['lname'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required value="<?php echo $row['email'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ใส่รูป</label>
                        <input type="file" class="form-control" name="userimg" >
                    </div>
                    <input type="text" value="<?php echo $row['uid']; ?>" hidden name="id">
                    <button type="submit" class="btn btn-success w-100" name="edit" value="edit"> แก้ไข</button>
                </form>
                </div>
                <?php }else if($_GET['page'] == 'res'){ ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>จัดการร้านอาหาร</h2>
                </div>
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <th>ID</th>
                        <th>ชื่อร้านอาหาร</th>
                        <th>รายละเอียดร้าน</th>
                        <th>ประเภทร้านอาหาร</th>
                        <th>เจ้าของร้าน</th>
                        <th>status</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = $conn->query("SELECT 
                                            tb_res.*, 
                                            tb_user.fname AS owner_name, 
                                            tb_type.type_name AS type_name FROM tb_res LEFT JOIN tb_user ON tb_res.res_owner = tb_user.uid LEFT JOIN tb_type ON tb_res.res_type = tb_type.type_id;");
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $row['res_id'] ?></td>
                            <td><?php echo $row['res_name'] ?></td>
                            <td><?php echo $row['res_detail'] ?></td>
                            <td><?php echo $row['type_name'] ?></td>
                            <td><?php echo $row['owner_name'] ?></td>
                            <td><?php echo str_replace('0', 'ปิด', str_replace('1', 'เปิด', $row['res_status'])); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php }else if($_GET['page'] == 'type'){ ?>
                <div class="container mt-4">
                    <h1>ประเภทร้านอาหาร</h1>
                </div>
                    <div class="container mt-2 mb-4">
                        <!-- start form-->
                        
                        <div class="mt-2 border p-4">
                            <h3 class="mb-4">ฟอร์มเพิ่มประเภทร้านอาหาร</h3>
                            <form method="POST" action="../backend/admin/type.php" class="mb-2">
                                <div class="row mt-3">
                                    <div class="col-2">
                                        <b>ชื่อประเภทร้านอาหาร</b>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="typename" class="form-control" placeholder="ชื่อประเภทร้านอาหาร">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-10">
                                        <input type="submit" class="btn btn-success" name="add" value="เพิ่มข้อมูล">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end form -->
                        <!-- start form-->
                        <div class="my-2 border p-4">
                            <h3>ประเภทร้านอาหาร</h3>
                            <form action="../backend/admin/type.php" method="POST">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>#</th>
                                    <th>ชื่อประเภทร้านอาหาร</th>
                                    <th class="text-center">ลบ</th>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = $conn->query("SELECT * FROM tb_type");
                                    while($rw = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <tr>
                                        <td><?php echo $rw['type_id'];?></td>
                                        <td><?php echo $rw['type_name'];?></td>
                                        <td align="center">
                                            <form action="../backend/admin/type.php" method="POST">
                                                <input type="text" value="<?php echo $rw['type_id']; ?>" hidden name="id">
                                                <button class="btn btn-danger me-2" name="del">ลบ</button>
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
    <!-- Modal for Add User -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >เพิ่มสมาชิก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../backend/admin/user.php" method="POST">
                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass" required>
                        </div>
                        <div class="mb-3">
                            <label for="repass" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="repass" id="repass" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="add">เพิ่ม</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../css/bootstrap.bundle.min.js"></script>

</html>
