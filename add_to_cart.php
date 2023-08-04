<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Remplacer cette partie par la logique pour récupérer les détails du produit à partir de la base de données
    $product_name = "Produit " . $product_id;
    $product_price = rand(5, 50);

    // Ajouter le produit au panier
    $_SESSION['cart'][] = array(
        'name' => $product_name,
        'price' => $product_price
    );
}

// Rediriger vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
