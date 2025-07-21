<?php

// Configuration
$uploadDir = 'uploads/';
$uploadSuccess = false;

// Traitement du formulaire
if (
    isset($_FILES['photo']) &&
    $_FILES['photo']['error'] === UPLOAD_ERR_OK
) {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $infos = $_FILES['photo'];
    $tmpName = $infos['tmp_name'];
    $originalName = $infos['name'];

    $fileInfo = pathinfo($originalName);
    $filename = preg_replace('/[^a-z0-9_-]/i', '_', $fileInfo['filename']);
    $extension = strtolower($fileInfo['extension']);

    $timestamp = date('YmdHis');
    $newName = "{$timestamp}-{$filename}.{$extension}";
    $destination = $uploadDir . $newName;

    if (move_uploaded_file($tmpName, $destination)) {
        $uploadSuccess = true;
    }
}

// Lecture du dossier uploads/ avec readdir()
$photos = [];
if (is_dir($uploadDir)) {
    if ($dh = opendir($uploadDir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file !== '.' && $file !== '..' && is_file($uploadDir . $file)) {
                $photos[] = $uploadDir . $file;
            }
        }
        closedir($dh);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mini Insta - Upload</title>
    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>MINI INSTA</h1>

    <?php if ($uploadSuccess): ?>
        <div class="success-message">
            Upload<br>réussi !
        </div>
    <?php endif; ?>

    <div class="photos">
        <?php foreach ($photos as $photo): 
            $fileInfo = pathinfo($photo);
            $fileName = $fileInfo['filename'];
            $extension = $fileInfo['extension'];
        ?>
            <div class="photo-item">
                <img src="<?= htmlspecialchars($photo) ?>" alt="Photo">
                <p><?= htmlspecialchars($fileName) . '.' . htmlspecialchars($extension) ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="back-button">
        <a href="index.php">
            <button class="big-button">Retour à l'accueil</button>
        </a>
    </div>
</div>

</body>
</html>
