<?php
// Lecture directe du dossier "uploads/
$photos = [];
$dir = 'uploads/';

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file !== '.' && $file !== '..' && is_file($dir . $file)) {
                $photos[] = $dir . $file;
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
    <title>Mini Insta Accueil</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>MINI INSTA</h1>

    <!-- Formulaire vers upload.php -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <p class="upload-label">Ajouter une photo !</p>
        <div class="form-row">
            <label class="big-button">
                Parcourir...
                <input type="file" name="photo" required>
            </label>
            <button type="submit" class="big-button">Envoyer</button>
        </div>
    </form>

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
</div>

</body>
</html>
