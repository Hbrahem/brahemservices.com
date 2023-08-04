<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "brahem";

$connexion = new mysqli($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

// Requête pour récupérer les produits
$sql = "SELECT * FROM products";
$result = $connexion->query($sql);

// Vérifier s'il y a des produits dans la base de données
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="product">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>Prix: ' . $row['price'] . ' €</p>';
        echo '<form method="post" action="add_to_cart.php">';
        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
        echo '<button type="submit" name="add_to_cart">Ajouter au panier</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "Aucun produit trouvé dans la base de données.";
}

// Fermer la connexion à la base de données
$connexion->close();
?>
