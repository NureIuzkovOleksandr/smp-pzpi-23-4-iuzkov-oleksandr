<?php
session_start();

if (!isset($_SESSION['shopping_cart'])) {
    $_SESSION['shopping_cart'] = [];
}

$currentCart = $_SESSION['shopping_cart'];
$submittedItems = $_POST['cart'] ?? [];
$validItemExists = false;

foreach ($submittedItems as $productId => $productData) {
    $productName = trim($productData['name']);
    $productQuantity = (int)$productData['quantity'];
    $productPrice = (float)$productData['price'];

    if ($productQuantity < 0 || $productQuantity > 99) {
        $_SESSION['input_data'] = $submittedItems;
        $_SESSION['input_error'] = 'Перевірте будь ласка введені дані.';
        header('Location: /products');
        exit;
    }

    if ($productQuantity > 0) {
        $validItemExists = true;

        if (isset($currentCart[$productId])) {
            $currentCart[$productId]['quantity'] += $productQuantity;
        } else {
            $currentCart[$productId] = [
                'name' => $productName,
                'quantity' => $productQuantity,
                'price' => $productPrice
            ];
        }
    }
}

if ($validItemExists) {
    $_SESSION['shopping_cart'] = $currentCart;
    unset($_SESSION['input_data'], $_SESSION['input_error']);
    header('Location: /cart');
    exit;
}

$_SESSION['input_error'] = 'Будь ласка, додайте хоча б один товар.';
$_SESSION['input_data'] = $submittedItems;
header('Location: /products');
exit;
