<?php
session_start();

$totalAmount = 0;
$quoteHTML = '<h2>Devis</h2>';
$quoteHTML .= '<ul>';

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $quoteHTML .= '<li>' . $item['name'] . ' - ' . $item['price'] . ' €</li>';
        $totalAmount += $item['price'];
    }
}

$quoteHTML .= '</ul>';
$quoteHTML .= '<p>Total: ' . $totalAmount . ' €</p>';

// Afficher le devis
$_SESSION['quote'] = $quoteHTML;

// Rediriger vers la page précédente
header('Location: index.php');
exit;
?>
