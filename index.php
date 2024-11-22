<?php
include_once "backend/db.php";
if(isset($_SESSION['id'])){
    header("location: frontend/home.php");
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <?php if(isset($_SESSION['text'])){ ?>
                    <div class="alert alert-<?php echo $_SESSION?>"><?php echo $_SESSION['text']; unset($_SESSION['text']) ?></div>
                <?php } ?>
                <div class="card">
                    <div class="card-header text-center">
                        <h3><i class="fas fa-sign-in-alt"></i> Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="backend/auth.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="login">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                            <div class="mt-3 text-center">
                                <a href="register.php">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>