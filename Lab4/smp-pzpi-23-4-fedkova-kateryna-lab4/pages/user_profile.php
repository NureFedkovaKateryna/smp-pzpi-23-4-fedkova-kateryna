<?php

$errors = [];

$userProfile = require 'profile.php';

$name = $userProfile['name'] ?? '';
$surname = $userProfile['surname'] ?? '';
$date_of_birth = $userProfile['date_of_birth'] ?? '';
$description = $userProfile['description'] ?? '';
$photo = $userProfile['photo'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $description = trim($_POST['description'] ?? '');

    if ($name === '' || $surname === '' || $date_of_birth === '' || $description === '') {
        $errors[] = "Fields can't be empty";
    }
    if (strlen($name) < 2) {
        $errors[] = "Довижина імені має бути більше 1";
    }
    if (strlen($surname) < 2) {
        $errors[] = "Довижина імені має бути більше 1";
    }

    $birthDateTime = DateTime::createFromFormat('Y-m-d', $date_of_birth);
    if (!$birthDateTime) {
        $errors[] = "Неправильний формат дати";
    } else {
        $age = (new DateTime())->diff($birthDateTime)->y;
        if ($age < 16) {
            $errors[] = "Користувач не можу бути молодше 16";
        }
    }

    if (strlen($description) < 50) {
        $errors[] = "Опис має містити хоча б 50 символів";
    }

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK && $photo == '') {
        $errors[] = "Фото не завантажено";
    } 
    if ($photo == '') {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['file']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Тип файлу не підтримується";
        } else {
            $uploadDir = './assets/';
            $fileName = uniqid('photo_') . '.' . path_info($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
              $errors[] = "Помилка при збережені файлу";
            }
            $fileName =  'assets/' . $fileName;
        }
    }

    elseif ($photo != '') {
      $fileName = $photo;
    }

    if (empty($errors)) {
        $profileData = [
            'name' => $name,
            'surname' => $surname,
            'date_of_birth' => $date_of_birth,
            'description' => $description,
            'photo' => $fileName,
        ];

        $phpCode = "<?php\nreturn " . var_export($profileData, true) . ";\n";
        file_put_contents('./profile.php', $phpCode);
        $userProfile = require 'profile.php';
        $name = $userProfile['name'] ?? '';
        $surname = $userProfile['surname'] ?? '';
        $date_of_birth = $userProfile['date_of_birth'] ?? '';
        $description = $userProfile['description'] ?? '';
        $photo = $userProfile['photo'] ?? '';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Весна</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    
    <main>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php foreach ($errors as $error): ?>
          <div><?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>



    <form method="POST" action="" enctype="multipart/form-data">
      <div class="container mt-5">
        <div class="row">
          <div class="col-md-4 d-flex flex-column align-items-center">
            <?php if (!empty($photo)) : ?>
              <div style="width: 250px; height: 250px; margin-bottom: 0;">
                <img src="<?php echo $photo; ?>" alt="User Photo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
              </div>
            <?php else : ?>
              <div class="border p-3 d-flex justify-content-center align-items-center" style="width: 250px; height: 250px; margin-bottom: 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                  <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13z"/>
                </svg>
              </div>
            <?php endif; ?>

            <div class="file-upload-wrapper">
              <label class="custom-file-upload">
                Upload
                <input name="file" type="file" />
              </label>
            </div>
          </div>

          <div class="col-md-8">
            <div class="row g-3">
              <div class="col-md-4">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
              </div>
              <div class="col-md-4">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" name="surname" class="form-control" value="<?php echo $surname; ?>">
              </div>
              <div class="col-md-4">
                <label for="birthdate" class="form-label">Date of birth</label>
                <input type="date" name="date_of_birth" class="form-control" value="<?php echo $date_of_birth; ?>">
              </div>
            </div>

            <div class="form-group mt-4">
              <label for="description" class="form-label">Brief description</label>
              <textarea class="form-control" name="description" rows="5"><?php echo $description; ?></textarea>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
          <button type="submit" class="btn btn-primary ms-2">Save</button>
        </div>
      </div>
    </form>

    </main>

</body>
</html>
