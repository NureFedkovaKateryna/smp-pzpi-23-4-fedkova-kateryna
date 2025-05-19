<header class="d-flex justify-content-between align-items-center p-3 border-bottom border-dark">
  <a href="/" class="text-decoration-none text-dark">
    <i class="fas fa-home me-1"></i> Home
  </a>

  <a href="/products" class="text-decoration-none text-dark">
    <i class="fas fa-list me-1"></i> Products
  </a>

  <?php if (isset($_SESSION['username'])) : ?>
    <a href="/basket" class="text-decoration-none text-dark">
      <i class="fas fa-shopping-cart me-1"></i> Cart
    </a>
    <a href="/profile" class="text-decoration-none text-dark">
      <i class="bi bi-person"></i> Profile
    </a>
    <a href="/logout.php" class="text-decoration-none text-dark">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>
  <?php else : ?>
    <a href="/login" class="text-decoration-none text-dark">
      <i class="bi bi-box-arrow-in-right"></i> Login
    </a>
  <?php endif; ?>

</header>
