<?php session_start() ?>
<?php require './conn.php' ?>

<?php
if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php

$userId = $_SESSION['auth_user']['id'];

if (!isset($_GET['file_id'])) {
    die("No file specified.");
}

$fileId = $_GET['file_id'];

$sql = "SELECT * FROM user_files WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $fileId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("File not found or access denied.");
}

$file = $result->fetch_assoc();


if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $newContent = $_POST['content'];


    if ($file['content'] !== $newContent) {
        $update = $conn->prepare("UPDATE user_files SET content = ? WHERE id = ?");
        $update->bind_param("si", $newContent, $fileId);
        $update->execute();

        // Update file on disk
        $uploadDir = './uploads/files/';
        file_put_contents($uploadDir . $file['filename'], $newContent);
        $file['content'] = $newContent;
        $_SESSION['success'] = "File updated successfully!";
        header("Location: profile.php");
        exit;
    } else {
        $_SESSION['error'] = "No Nhanges Happend";
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

<body style="background-color:cornsilk;">
    <?php require './partials/head.php' ?>
    <?php require './partials/alert.php' ?>


    <div class="container mt-3 d-flex justify-content-center row g-4 mx-auto d-block">

        <div class="card border border-dark col-10" style="height: 500px;">


            <h2 class="text-center">Editing File: <?= htmlspecialchars(string: $file['filename']) ?></h2>
            <div class="d-flex justify-content-center align-items-center h-100">
                <form method="POST" class="">
                    <textarea name="content" rows="6" cols="80" class="form-control mb-3 border border-dark"><?= htmlspecialchars($file['content']) ?></textarea>

                    <button type="submit" class="btn btn-primary" name="action" value="update">Save Changes</button>
                </form>
            </div>
        </div>


    </div>
</body>

</html>