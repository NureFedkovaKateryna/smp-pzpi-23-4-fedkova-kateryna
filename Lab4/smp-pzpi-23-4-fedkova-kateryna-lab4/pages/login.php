<?php 

require 'credential.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
  $formUsername = $_POST['username'];
  $formPassword = $_POST['password'];
  if (isset($credentials['username'], $credentials['password'])) {
    if ($credentials['username'] == $formUsername && $credentials['password'] == $formPassword) {
      $_SESSION['username'] = $formUsername;
		  $_SESSION['authorized_at'] = date("Y-m-d H:i:s");
      header('Location: /products');
      exit;
    }
    else {
      $_SESSION['form_error'] = 'Відбулась помилка';
    }
  }
  else {
    $_SESSION['form_error'] = 'Відбулась помилка';
  }
}

$formError = $_SESSION['form_error'] ?? '';
unset($_SESSION['form_error']);

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
</head>
<body>
    
    <main>

      <?php if ($formError): ?>
        <div class="alert alert-danger text-center"><?php echo $formError; ?></div>
      <?php endif; ?>


      <form method="POST" action="">
      <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
          <h2 class="text-center mb-4">Вхід до системи</h2>
          <form method="post" action="login_handler.php">
            <div class="mb-3">
              <input type="text" placeholder="User Name" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
              <input type="password" placeholder="Password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
      </form>

    </main>

</body>
</html>
