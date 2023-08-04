<?php
// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Oops! There was a problem with your submission. Please complete the form and try again.";
        exit;
    }

    // Update this to your desired email address.
    $recipient = "hajbrahem.habib@gmail.com";
    $email_subject = "Message from $name";

    // Email content.
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Subject: $subject\n";
    $email_content .= "Message: $message\n";

    // Email headers.
    $email_headers = "From: $name <$email>\r\nReply-to: <$email>";

    // Send the email.
    $mail_result = mail($recipient, $email_subject, $email_content, $email_headers);

    // Store the message in the database.
    $servername = "localhost";
    $username = "root"; // Remplacez par le nom d'utilisateur de votre base de données
    $password = ""; // Remplacez par le mot de passe de votre base de données
    $dbname = "brahem"; // Remplacez par le nom de votre base de données

    // Créez une connexion à la base de données
    $connexion = new mysqli($servername, $username, $password, $dbname);

    // Vérifiez la connexion
    if ($connexion->connect_error) {
        die("Échec de la connexion à la base de données : " . $connexion->connect_error);
    }

    // Échappez les données pour éviter les attaques par injection SQL
    $name = $connexion->real_escape_string($name);
    $email = $connexion->real_escape_string($email);
    $subject = $connexion->real_escape_string($subject);
    $message = $connexion->real_escape_string($message);

    // Requête SQL pour insérer les données dans la table de la base de données
    $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($connexion->query($sql) === TRUE && $mail_result) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

    // Fermez la connexion à la base de données
    $connexion->close();

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
