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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];


    // Requête SQL pour insérer la demande de devis dans la table
    $sql = "INSERT INTO quote_requests (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    if ($connexion->query($sql) === TRUE) {
        echo '<!DOCTYPE html>
              <html>
              <head>
                  <title>Demande de devis</title>
                  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
              </head>
              <body>
                  <div class="container mt-5">
                      <div class="alert alert-success">
                          <h2 class="alert-heading">Merci pour votre demande de devis</h2>
                          <p>Nom: ' . $name . '</p>
                          <p>Email: ' . $email . '</p>
                          <p>Téléphone: ' . $phone . '</p>
                          <p>Message: ' . $message . '</p>
                          <p>Vous allez recevoire votre devis par mail bientot</p>
                      </div>
                      <style>.btn-primary {
                        background-color: #007BFF;
                        border-color: #007BFF;
                    }
                    
                    .btn-primary:hover {
                        background-color: #0056b3;
                        border-color: #0056b3;
                    }
                    
                    .btn-primary:focus, .btn-primary.focus {
                        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
                    }
                    
                    .btn-primary.disabled, .btn-primary:disabled {
                        background-color: #007BFF;
                        border-color: #007BFF;
                    }
                    
                    .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active,
                    .show > .btn-primary.dropdown-toggle {
                        background-color: #0056b3;
                        border-color: #0056b3;
                    }
</style>                    
                  </div>
                  <div class="container mt-5">
                  <div class="text-center">
                      <a href="index.html" class="btn btn-primary">Retour à l accueil</a>
                  </div>
              </body>
              </html>';
    } else {
        echo "Erreur lors de l'insertion des données dans la base de données : " . $connexion->error;
    }

    // Fermer la connexion à la base de données
    $connexion->close();
}
?>
