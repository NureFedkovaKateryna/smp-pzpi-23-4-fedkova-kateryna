<?php

session_start();
$bag = [];

if (isset($_POST['bag'])) {
    foreach ($_POST['bag'] as $id => $data) {
        $title = $data['title'];
        $quantity = $data['quantity'];
        $price = $data['price'];

        if (!is_numeric($quantity) || $quantity < 0 || $quantity > 99) {
            $_SESSION['form_data'] = $_POST['bag'];
            $_SESSION['form_error'] = 'Перевірте будь ласка введені дані';
            header('Location: /products');
            exit;
        }
    
        if ($quantity > 0) {
            $bag[$id] = [
                'title' => $title,
                'quantity' => $quantity,
                'price' => $price
            ];
        }
    }

    $_SESSION['bag'] = $bag;
    unset($_SESSION['form_data'], $_SESSION['form_error']);
    header('Location: /basket');
    exit;
}