<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$totalPrice = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['remove_id'])) {
        $removeId = $_POST['remove_id'];
        if (isset($_SESSION['shopping_cart'][$removeId])) {
            unset($_SESSION['shopping_cart'][$removeId]);
        }
    } elseif (!empty($_POST['action'])) {
        switch ($_POST['action']) {
            case 'clear':
                $_SESSION['shopping_cart'] = [];
                break;
            case 'pay':
                $_SESSION['shopping_cart'] = [];
                $_SESSION['success_message'] = 'Дякуємо за покупку!';
                header('Location: /cart');
                exit;
        }
    }
}

$cartItems = $_SESSION['shopping_cart'] ?? [];
$successMsg = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>

<div class="cart-page">
    <?php if ($successMsg): ?>
        <div class="cart-success"><?php echo htmlspecialchars($successMsg); ?></div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="cart-empty">
            <p>Ваш кошик порожній.</p>
            <a href="/products" class="button-link">Перейти до покупок</a>
        </div>
    <?php else: ?>
        <h2 class="cart-title">Ваш кошик</h2>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Ціна</th>
                    <th>Кількість</th>
                    <th>Сума</th>
                    <th>Дія</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $productId => $product): 
                    $lineTotal = $product['price'] * $product['quantity'];
                    $totalPrice += $lineTotal;
                ?>
                <tr>
                    <td><?php echo $productId; ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo $product['price']; ?> грн</td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $lineTotal; ?> грн</td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="remove_id" value="<?php echo $productId; ?>">
                            <button type="submit" class="btn-delete">Видалити</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr class="cart-total-row">
                    <td colspan="4" class="text-right">Разом:</td>
                    <td colspan="2"><?php echo $totalPrice; ?> грн</td>
                </tr>
            </tbody>
        </table>

        <form method="POST" class="cart-actions">
            <button type="submit" name="action" value="clear" class="btn-clear">Очистити</button>
            <button type="submit" name="action" value="pay" class="btn-pay">Сплатити</button>
        </form>
    <?php endif; ?>
</div>
