<?php
session_start();
require './conn.php';

// Ensure user logged in
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}

$userEmail = $_SESSION['auth_user']['email'];



$sql1 = "SELECT id FROM users WHERE email = ? LIMIT 1";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("s", $userEmail);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$userId = $row1['id'];


if (isset($_POST['action']) && $_POST['action'] === 'uploadfile') {



    $file = $_FILES['txtFile'];
    $file_name = $file['name'];
    $file_temp = $file['tmp_name'];

    $file_extension = strtolower(end(explode('.', $file_name)));
    // to make it unique
    $target_file_name  = "user_" .  $_SESSION['auth_user']['email']  . time() . "." . $file_extension;
    $uploadDir = './uploads/files/';
    $filePath = $uploadDir . $target_file_name;

    if (move_uploaded_file($file_temp, $filePath)) {
        $content = file_get_contents($filePath);

        // Save in DB
        $sql2 = "INSERT INTO user_files (user_id, filename, content) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("iss", $userId,  $target_file_name, $content);
        if ($stmt2->execute()) {

            header("Location: profile.php");
            exit();
        }
    }
}


// Fetch all user files
$sql3 = "SELECT id, filename FROM user_files WHERE user_id = ? ORDER BY id DESC";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param("i", $userId);
$stmt3->execute();
$result3 = $stmt3->get_result();
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="background-color:cornsilk;">
    <?php require './partials/head.php' ?>
    <?php require './partials/alert.php' ?>


    <div class="container mt-3 text-end">
        <a href="./logout.php" class="btn btn-primary">Log out</a>
    </div>

    <div class="container mt-3 d-flex justify-content-center row g-4 mx-auto d-block">

        <div class="card border border-dark col-6">
            <h3 class="text-center mt-2">welcome <?= $_SESSION['auth_user']['name'] ?></h3>
            <img id="image" src="./uploads/images/<?= $_SESSION['auth_user']['image'] ?>" alt="no image" class="card-img-top mx-auto d-block mt-3 rounded-circle" style="width: 250px;">

            <div class="card-body row d-flex">

                <div class="mb-3 mt-3">
                    <label for="yourName" class="form-label">your Name</label>
                    <input type="text" class="form-control" id="yourName" value="<?= $_SESSION['auth_user']['name'] ?>" disabled>
                </div>



                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" value="<?= $_SESSION['auth_user']['email'] ?>" disabled>
                </div>
                <form class="my-3 w-50" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload Your TXT File you want write in</label>
                        <input class="form-control" type="file" id="formFile" name="txtFile" required accept=".txt">
                    </div>
                    <button type="submit" class="btn btn-primary" name="action" value="uploadfile">Upload</button>

                </form>


                <hr>

                <h2>Your Files</h2>
                <?php if ($result3->num_rows > 0): ?>
                    <div class="row ">
                        <?php while ($row3 = $result3->fetch_assoc()): ?>
                            <div class="col-12">
                                <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap m-2">
                                    <span class="text-truncate" style="max-width: 70%;">
                                        <?= htmlspecialchars($row3['filename']) ?>
                                    </span>
                                    <a href="edit.php?file_id=<?= $row3['id'] ?>" class="btn btn-primary btn-sm mt-2 mt-md-0">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p>No files uploaded yet.</p>
                <?php endif; ?>



            </div>

        </div>


    </div>
</body>

</html>