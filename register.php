
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-user-plus"></i> Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="backend/auth.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" name="fname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">นามสกุล</label>
                                <input type="text" class="form-control" name="lname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รหัสผ่าน</label>
                                <input type="password" class="form-control" name="pass" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ยืนยันรหัสผ่าน</label>
                                <input type="password" class="form-control" name="repass" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รูปโปรไฟล์</label>
                                <input type="file" class="form-control" name="userimg" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100" name="regis" value="regis">
                                <i class="fas fa-user-plus"></i> สมัครสมาชิก
                            </button>
                            <div class="mt-3 text-center">
                                <a href="index.php">คุณเคยสมัครสมาชิกแล้วใช่มั้ย? เข้าสู่ระบบ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../css/bootstrap.bundle.min.js"></script>

</html>