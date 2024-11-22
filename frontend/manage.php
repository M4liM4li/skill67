
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
                            <input type="text" class="form-control" value="<?php echo $_SESSION['id'] ?> " hidden name="id">
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
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=type">จัดการหมวดหมู่อาหาร</a>
                        </li>
                        <?php 
                         if(getUid($_SESSION['id'])['role'] != "admin"){?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="manage.php?page=food">จัดการอาหาร</a>
                         </li>
                        <?php }?>
                        
                    </ul>
                </div>
            </nav>

            <!-- Content Area -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <?php if($_GET['page']=='home'){?>
                    <div class="container mt-5">
                        <h1 class="text-center mb-4">รายงานร้านอาหาร</h1>

                        <div class="row">
                        <!-- รายงานยอดขาย -->
                        <div class="col-lg-6">
                            <div class="card">
                            <div class="card-header">
                                รายงานยอดขาย
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>วันที่</th>
                                    <th>ยอดขาย (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>01/11/2024</td>
                                    <td>10,000 บาท</td>
                                    </tr>
                                    <tr>
                                    <td>02/11/2024</td>
                                    <td>12,500 บาท</td>
                                    </tr>
                                    <!-- เพิ่มข้อมูลยอดขายในตาราง -->
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                        <!-- รายงานการใช้จ่าย -->
                        <div class="col-lg-6">
                            <div class="card">
                            <div class="card-header">
                                รายงานการใช้จ่าย
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>วันที่</th>
                                    <th>การใช้จ่าย (บาท)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>01/11/2024</td>
                                    <td>5,000 บาท</td>
                                    </tr>
                                    <tr>
                                    <td>02/11/2024</td>
                                    <td>4,800 บาท</td>
                                    </tr>
                                    <!-- เพิ่มข้อมูลการใช้จ่ายในตาราง -->
                                </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>

                        <!-- รายงานเมนูที่ขายดี -->
                        <div class="card mt-4">
                        <div class="card-header">
                            รายงานเมนูที่ขายดี
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>เมนู</th>
                                <th>จำนวนที่ขาย</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>ข้าวผัด</td>
                                <td>150 จาน</td>
                                </tr>
                                <tr>
                                <td>ก๋วยเตี๋ยวเรือ</td>
                                <td>120 จาน</td>
                                </tr>
                                <!-- เพิ่มข้อมูลเมนูที่ขายดี -->
                            </tbody>
                            </table>
                        </div>
                        </div>

                </div>
                
                <?php }else if($_GET['page'] =='res'){ ?>
                <div class="container mt-5">
                    <h2 class="text-center mb-4">จัดการร้านอาหาร</h2>
                    <div class="col-lg-3">
                        <form class="mt-5">
                            <div class="md-3">
                                <label for="" class="form-label">ชื่อร้านค้า</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="md-3">
                                <label for="" class="form-label">รายละเอียดร้านค้า</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="md-3">
                                
                            </div>
                        </form>
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
                            $getOrder = $conn->query("SELECT * FROM tb_order where res_id = '$id' AND order_status != '3'");
                            while($rw = $getOrder->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title text-center">ออเดอร์</h5>
                               
                                <div class="row mt-4">
                               
                                    <div class="col-6 mb-3">
                                        <p class="card-text"><strong>ชื่อ :</strong> <?php echo $rw['order_fname']; ?></p>
                                        <p class="card-text"><strong>ราคารวม :</strong> <?php echo $rw['order_total']; ?></p>
                                        <p class="card-text"><strong>ที่อยู่ :</strong> <?php echo $rw['order_address']; ?></p>
                                        <p class="card-text"><strong>เบอร์ติดต่อ :</strong> 000</p>
                                        <p class="card-text"><strong>ชื่อไรเดอร์ :</strong> gg</p>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" name="rec" class="btn btn-success me-3">รับออเดอร์</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <?php } ?>
                        
                        </div>
                    </div>
                    </div>
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
                        <?php
                            $id = $_SESSION['id'];
                            $getOrder = $conn->query("SELECT * FROM tb_order where res_id = '$id' AND order_status = '3'");
                            while($rw = $getOrder->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                
                               
                                <div class="row mt-4">
                               
                                    <div class="col-6 mb-3">
                                        <p class="card-text"><strong>ชื่อ :</strong> <?php echo $rw['order_fname']; ?></p>
                                        <p class="card-text"><strong>ราคารวม :</strong> <?php echo $rw['order_total']; ?></p>
                                        <p class="card-text"><strong>ที่อยู่ :</strong> <?php echo $rw['order_address']; ?></p>
                                        <p class="card-text"><strong>เบอร์ติดต่อ :</strong> 000</p>
                                        <p class="card-text"><strong>ชื่อไรเดอร์ :</strong> gg</p>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" name="rec" class="btn btn-success me-3">รับออเดอร์</button>
                                        <button type="submit" name="rec" class="btn btn-warning ">รายละเอียดออเดอร์</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <?php } ?>
                        
                        </div>
                    </div>
                    </div>
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
                        <th>ประเภท</th>
                    </thead>
                    <?php
                    $id = $_SESSION['id'];

                    $sql=$conn->query("SELECT * FROM tb_food LEFT JOIN tb_res ON tb_food.res_id = tb_res.res_owner WHERE tb_food.res_id = '$id'");
                    while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row['food_id'];?></td>
                            <td><img src="../img/<?php echo $row['food_img'];?>" alt="" height="30px"></td>
                            <td><?php echo $row['food_name'];?></td>
                            <td><?php echo $row['food_price'];?></td>
                            <td><?php echo $row['food_type'];?></td>

                        </tr>
                    </tbody>
                    <?php }?>
                </table>
                <?php }?>
            </main>
        </div>
    </div>
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
                        $getType =$conn->query("SELECT * FROM tb_type");
                        while($row = $getType->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <option value="<?php echo $row['type_id'];?>"><?php echo $row['type_name'];?></option>
                    <?php }?>
                    </select>
                    <label class="form-label mt-2">รูปอาหาร</label>
                    <input type="file" class="form-control" name="foodimg" required>
                </div>
                <div class="modal-footer">
                    <input type="text" class="form-control" name="id" value="<?php echo $_SESSION['id'];?> " hidden>
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
</html>
