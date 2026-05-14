<?php
include_once "../DBOperations/ManageCart.php";
$manageCart = new ManageCart();
$cartItems = $manageCart->getCartItems();
?>
<style>
/* ✅ Layout Alignment Fix */
body {
  background-color: #f8f9fa;
  overflow-x: hidden;
}

#sidebar {
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  width: 260px;
  
  color: #ffffffff;
  border-right: 1px solid #e1e1e1;
  z-index: 999;
  transition: width 0.3s ease;
}

#sidebar.collapsed {
  width: 80px;
}

#adminHeader {
  position: fixed;
  top: 0;
  left: 260px;
  right: 0;
  height: 60px;
  background: linear-gradient(90deg, #0E8388, #072E33);
  color: white;
  z-index: 1000;
  transition: all 0.3s ease;
}

#adminHeader.expanded {
  left: 80px;
}

.content {
  margin-left: 260px;
  margin-top: 70px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

.content.expanded {
  margin-left: 80px;
}

/* ✅ Charts Auto Height */
.chart-container {
  position: relative;
  height: calc(100vh - 420px);
  min-height: 280px;
  width: 100%;
}

/* ✅ Responsive Fix */
@media (max-width: 768px) {
  #sidebar {
    width: 0;
    overflow: hidden;
  }
  #adminHeader {
    left: 0 !important;
  }
  .content {
    margin-left: 0 !important;
  }
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cart</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>🛒 Manage Cart</h2>

    <?php if (empty($cartItems)) { ?>
        <p>No items in cart.</p>
    <?php } else { ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php foreach ($cartItems as $item) { ?>
                <tr>
                    <td><?= $item['product_id'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><img src="../uploads/<?= $item['image_url'] ?>" width="60"></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['discount_price'] ?></td>
                    <td><?= $item['discount_price'] * $item['quantity'] ?></td>
                    <td><a href="../Controllers/CartController.php?ID=<?= $item['product_id'] ?>&method=delete">❌</a></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</body>
</html>
