<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
  <?php require './partials/head.php' ?>

    <div class="card shadow p-4 text-center" style="width: 350px;">
        <h2 class="mb-4">Welcome</h2>
        
        <a href="login.php" class="btn btn-primary w-100 mb-3">Login</a>
        <a href="register.php" class="btn btn-success w-100">Register</a>
    </div>

</body>
</html>
