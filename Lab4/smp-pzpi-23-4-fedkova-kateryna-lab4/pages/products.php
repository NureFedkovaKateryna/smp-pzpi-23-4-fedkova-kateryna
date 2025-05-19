<?php 

require_once __DIR__ . '/../db/db_connection.php';

$formData = $_SESSION['form_data'] ?? [];
$formError = $_SESSION['form_error'] ?? '';
unset($_SESSION['form_data'], $_SESSION['form_error']);
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

      <?php $products= get_products() ?>

        <?php if ($formError): ?>
          <div class="alert alert-danger text-center"><?php echo $formError; ?></div>
        <?php endif; ?>

        <form class="product-form" method="POST" action="/add_to_bag.php">
          <table class="table table-bordered table-striped align-middle">
          <tbody>
            <?php foreach ($products as $product): 
              $id = $product['id'];
              $oldQuantity = $formData[$id]['quantity'] ?? 0;
            ?>
              <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $product['title']; ?></td>
                <td>
                  <input type="hidden" name="bag[<?php echo $id; ?>][title]" value="<?php echo $product['title']; ?>">
                  <input
                    name="bag[<?php echo $id; ?>][quantity]"
                    type="number"
                    step="1"
                    value="<?php echo $oldQuantity; ?>"
                    class="form-control form-control-sm"
                  >
                  <input type="hidden" name="bag[<?php echo $id; ?>][price]" value="<?php echo $product['price']; ?>">
                </td>
                <td><?php echo $product['price']; ?> грн</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          </table>

          <div class="mt-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>
    </main>

</body>
</html>
