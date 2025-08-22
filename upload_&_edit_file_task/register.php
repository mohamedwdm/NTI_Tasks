<?php session_start() ?>
<?php require './conn.php' ?>



<?php

if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $image = $_FILES['form_file'];
    echo '<pre>';
    print_r($image);
    echo '</pre>';

    $image_name = $image['name'];
    $image_temp = $image['tmp_name'];

    $allowed_extensions = array('jpg', 'gif', 'jpeg', 'png');
    $image_extension = strtolower(end(explode('.', $image_name)));
    // to make it unique
    // $target_image_name  = "user_" . time() . "." . $image_extension;
    $target_image_name  = "user_" . $_POST['email'] . "." . $image_extension;
    print_r($image_name);

    if (!in_array($image_extension, $allowed_extensions)) {
        die("Only JPG, JPEG, PNG, GIF allowed.");
    }

    if (move_uploaded_file($image_temp, './uploads/images/' . $target_image_name)) {
        
           $sql = "INSERT INTO users (name, email, password, profile_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $target_image_name);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Login Successfuly';

            header("Location: login.php");
            exit();

        } 
    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register page</title>
</head>

<body>
    <?php require './partials/head.php' ?>

    <div class="container">


        <h1 class="m-5 fw-bold">Register</h1>
        <form class="m-5 w-50" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">User Name*</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="User Name" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label" >Email address*</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com" required>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput4" class="form-label">Password*</label>
                <input type="password" name="password" class="form-control" id="exampleFormControlInput4" placeholder="User Password" required>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Your Profile Image</label>
                <input class="form-control" type="file" id="formFile" name="form_file" required>
            </div>
            <div class="mb-3">
                <span>Already Have an Account</span>
                <a class="link-primary" href="./login.php">Login</a>
            </div>

            <button type="submit" class="btn btn-primary" name="action" value="register">Register</button>
        </form>
    </div>
</body>

</html>