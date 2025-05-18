<?php 

session_start(); 
$totalAmount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
  $id = $_POST['id'];
  unset($_SESSION['bag'][$id]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancelOrPay'])) {
  $_SESSION['bag'] = [];
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
</head>
<body>
    
    <?php  include "../includes/header.php" ?>

    <main>
         <?php if (empty($_SESSION['bag'])): ?>
            <div class="d-flex justify-content-center align-items-center" >
              <a class="title-text" href="products.php">Перейти до покупок</a>
            </div>

          <?php else: ?>
            <table class="table table-bordered table-striped align-middle">
              <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">price</th>
                    <th scope="col">count</th>
                    <th scope="col">sum</th>
                    <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($_SESSION['bag'] as $id => $data): 
                  $title = $data['title'];
                  $quantity = $data['quantity'];
                  $price = $data['price'];
                  $totalAmount += $quantity * $price;
                ?>
                  <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $price * $quantity; ?></td>
                    <td>
                      <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
          <?php endforeach; ?>
          <tr>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $totalAmount; ?></td>
          </tr>
        </tbody>
      </table>
      <form method="POST" action="">
        <input type="hidden" name="cancelOrPay">
        <div class="mt-3 d-flex justify-content-center gap-2">
          <button type="submit" class="btn btn-primary">cancel</button>
          <button type="submit" class="btn btn-primary">pay</button>
        </div>
      </form>
    <?php endif; ?>

    </main>

    <?php  include "../includes/footer.php" ?>

</body>
</html>
