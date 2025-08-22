<?php session_start() ?>
<?php require './conn.php' ?>

<?php
if (isset($_SESSION['auth_user'])) {
    header("Location: login.php");
}
?>

<?php

if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    

    if ($result->num_rows == 0) {
        $_SESSION['error'] = 'Invalid Data';
        header("Location: login.php");
        die;
    } else {
        $row = $result->fetch_assoc();
        var_dump($row);
        if (password_verify($password, $row['password'])) {
            $_SESSION['auth_user'] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'image' =>$row['profile_image'],
            ];
            $_SESSION['success'] = 'Login Successfuly';
            header("Location: profile.php");

            die;
        } else {
            $_SESSION['error'] = 'Invalid Data';
            header("Location: login.php");
            die;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <?php require './partials/head.php' ?>
 <?php require './partials/alert.php' ?>



<div class="container">
    
    <h1 class="m-5 fw-bold">Login</h1>
    <form class="m-5 w-50" method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Email address*</label>
            <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput4" class="form-label">Password*</label>
            <input type="password" name="password" class="form-control" id="exampleFormControlInput4" placeholder="User Password">
        </div>

        
        <div class="mb-3">
            <span>Create New Account</span>
            <a class="link-primary" href="register.php">Register</a>
        </div>
        <button type="submit" class="btn btn-primary" name="action" value="login">Login</button>
    </form>
</div>
</body>
</html>