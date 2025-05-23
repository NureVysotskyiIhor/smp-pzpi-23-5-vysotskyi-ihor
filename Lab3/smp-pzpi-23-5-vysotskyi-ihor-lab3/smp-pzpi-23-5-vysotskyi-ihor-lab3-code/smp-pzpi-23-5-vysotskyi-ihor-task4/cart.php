<?php
session_start();

$products = [
    1 => ["name" => "Fanta",  "price" => 1],
    2 => ["name" => "Sprite", "price" => 1],
    3 => ["name" => "Nuts",   "price" => 1],
];

if (isset($_GET['delete'])) {
    unset($_SESSION['cart'][$_GET['delete']]);
    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cart</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <nav>
      <a href="index.php">🏠 Home</a>
      <a href="products.php">📦 Products</a>
      <a href="cart.php">🛒 Cart</a>
    </nav>
  </header>

  <main>
    <?php if (empty($cart)): ?>
      <p><a href="products.php">Перейти до покупок</a></p>
    <?php else: ?>
      <table>
        <tr><th>Id</th><th>Name</th><th>Price</th><th>Count</th><th>Sum</th><th>Action</th></tr>
        <?php $total = 0; foreach ($cart as $id => $count): 
          $product = $products[$id];
          $sum = $product['price'] * $count;
          $total += $sum;
        ?>
        <tr>
          <td><?= $id ?></td>
          <td><?= htmlspecialchars($product['name']) ?></td>
          <td>$<?= $product['price'] ?></td>
          <td><?= $count ?></td>
          <td>$<?= $sum ?></td>
          <td><a href="?delete=<?= $id ?>">🗑</a></td>
        </tr>
        <?php endforeach; ?>
        <tr><td colspan="4">Total</td><td>$<?= $total ?></td><td></td></tr>
      </table>
      <button>Cancel</button>
      <button>Pay</button>
    <?php endif; ?>
  </main>

  <footer>
    <nav>
      <a href="index.php">Home</a> |
      <a href="products.php">Products</a> |
      <a href="cart.php">Cart</a> |
      <a href="#">About Us</a>
    </nav>
  </footer>
</body>
</html>
