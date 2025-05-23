<?php
session_start();

$products = [
    1 => ["name" => "Fanta",  "price" => 1, "image" => "images/Fanta.jfif"],
    2 => ["name" => "Sprite", "price" => 1, "image" => "images/Sprite.jfif"],
    3 => ["name" => "Nuts",   "price" => 1, "image" => "images/Nuts.jfif"],
];

// Ініціалізуємо кошик, якщо ще не існує
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantity'] as $id => $qty) {
        $id = (int)$id;
        $qty = (int)$qty;

        if ($qty > 0) {
            // Якщо товар уже є в кошику — додаємо кількість
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qty;
            } else {
                $_SESSION['cart'][$id] = $qty;
            }
        }
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Products</title>
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
    <form method="post" action="products.php">
      <?php foreach ($products as $id => $product): ?>
        <div class="product">
          <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
          <label><?= htmlspecialchars($product['name']) ?></label>
          <input type="number" name="quantity[<?= $id ?>]" value="0" min="0">
          <span>$<?= $product['price'] ?></span>
        </div>
      <?php endforeach; ?>
      <button type="submit">Send</button>
    </form>
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
