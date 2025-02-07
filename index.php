<?php
session_start();
// require 'db.php';
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
    <section class="intro">
        <h2>Bienvenue sur OWASP E-comm</h2>
        <p>Explorez nos produits et profitez d'offres exceptionnelles. Vous trouverez une large sélection d'articles disponibles à l'achat, allant de l'électronique aux accessoires. Commencez dès maintenant à parcourir notre catalogue.</p>
    </section>

    <section class="products">
        <h2>Nos Produits Populaires</h2>
        <div class="product-list">
            <?php foreach ($produits as $produit): ?>
                <div class="product-card">
                    <img src="images/<?= $produit['image']; ?>" alt="<?= htmlspecialchars($produit['nom']); ?>" class="product-image">
                    <h3 class="product-name"><?= htmlspecialchars($produit['nom']); ?></h3>
                    <p class="product-description"><?= substr(htmlspecialchars($produit['description']), 0, 100); ?>...</p>
                    <p class="product-price"><?= number_format($produit['prix'], 2, ',', ' '); ?> €</p>
                    <a href="product_detail.php?id=<?= $produit['id']; ?>" class="btn">Voir Détails</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <p>&copy; 2024 Micro E-commerce - Tous droits réservés</p>
</footer>

</body>
</html>
