
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="">
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
                                <label class="form-label">First name</label>
                                <input type="text" class="form-control" name="fname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last name</label>
                                <input type="text" class="form-control" name="lname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="pass" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="repass" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ใส่รูป</label>
                                <input type="file" class="form-control" name="userimg" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100" name="regis" value="regis">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                            <div class="mt-3 text-center">
                                <a href="index.php">Already have an account? Log in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>