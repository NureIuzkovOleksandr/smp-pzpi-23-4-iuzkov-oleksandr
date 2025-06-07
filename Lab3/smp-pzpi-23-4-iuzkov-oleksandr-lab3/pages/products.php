<?php 
session_start();
require_once __DIR__ . '/../database/database_functions.php';
$databaseConnection = createConnection();
$availableProducts = fetchProducts($databaseConnection);

$previousInput = $_SESSION['input_data'] ?? [];
$errorMessage = $_SESSION['input_error'] ?? '';
unset($_SESSION['input_data'], $_SESSION['input_error']);
?>

<div class="product-page">
    <h1>Доступні товари</h1>

    <?php if ($errorMessage): ?>
    <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form method="POST" action="/utils/save_to_cart.php" class="product-selection-form">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Кількість</th>
                    <th>Ціна</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($availableProducts as $item): 
                $productId = $item['id'];
                $quantityValue = $previousInput[$productId]['quantity'] ?? 0;
            ?>
                <tr>
                    <td><?php echo $productId; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>
                        <input type="hidden" name="cart[<?php echo $productId; ?>][name]"
                            value="<?php echo htmlspecialchars($item['name']); ?>">
                        <input type="number" name="cart[<?php echo $productId; ?>][quantity]"
                            value="<?php echo htmlspecialchars($quantityValue); ?>" class="quantity-input">
                        <input type="hidden" name="cart[<?php echo $productId; ?>][price]"
                            value="<?php echo $item['price']; ?>">
                    </td>
                    <td><?php echo $item['price']; ?> грн</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="form-actions">
            <button type="submit" class="submit-button">Додати до кошика</button>
        </div>
    </form>
</div>
