<?php
session_start();
// require 'db.php'; 

// Vérification CSRF
$token = bin2hex(random_bytes(32)); 
$_SESSION['csrf_token'] = $token;

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du token CSRF
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        
        $nom = htmlspecialchars($_POST['nom']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $sujet = htmlspecialchars($_POST['sujet']);
        $message_content = htmlspecialchars($_POST['message']);
        
        if (!$nom || !$email || !$sujet || !$message_content) {
            $error = "Tous les champs sont requis, et l'email doit être valide.";
        } else {
            // Traitement du formulaire (envoi par email, enregistrement en base, etc.)
            $to = "exemple@gmail.com";
            $subject = "Nouveau message de contact : $sujet";
            $body = "Nom: $nom\nEmail: $email\n\n$message_content";
            $headers = "From: $email\r\n";
            
            if (mail($to, $subject, $body, $headers)) {
                $message = "Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.";
            } else {
                $error = "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer.";
            }
        }
    } else {
        $error = "Erreur survenue. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OWASP E-comm</title>
    <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>

<header>
    <h1>OWASP E-comm</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="login.php">Connexion</a></li>
            <li><a href="register.php">Inscription</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="contact-intro">
        <h2>Nous contacter</h2>
        <p>Nous sommes toujours prêts à répondre à vos questions ! Que vous ayez des questions sur nos produits, des problèmes avec votre commande, ou si vous avez simplement un commentaire ou une suggestion, nous serons heureux de vous aider.</p>
        <p>Veuillez remplir le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>
    </section>

    <?php if ($error): ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="success"><?= $message; ?></div>
    <?php endif; ?>

    <form action="contact.php" method="POST" class="contact-form">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required placeholder="Entrez votre nom">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required placeholder="Entrez votre adresse email">

        <label for="sujet">Sujet :</label>
        <input type="text" id="sujet" name="sujet" value="<?= isset($_POST['sujet']) ? htmlspecialchars($_POST['sujet']) : ''; ?>" required placeholder="Le sujet de votre message">

        <label for="message">Message :</label>
        <textarea id="message" name="message" required placeholder="Écrivez votre message ici..."><?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>

        <button type="submit">Envoyer le message</button>
    </form>
</main>

<footer>
    <p>&copy; 2024 Micro E-commerce - Tous droits réservés</p>
</footer>

</body>
</html>
