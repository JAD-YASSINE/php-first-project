<?php
/////ouvrirconexion
function ouvrirConnexion() {
    $utilisateur = 'root';
    $motDePasse = 'root';
    try {
        $connexion = new PDO('mysql:host=localhost;dbname=restaurant_db', $utilisateur, $motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Créer les tables si elles n'existent pas
        $connexion->exec("CREATE TABLE IF NOT EXISTS plats_menu (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            description TEXT,
            prix DECIMAL(10,2) NOT NULL,
            categorie VARCHAR(50),
            url_image VARCHAR(255),
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        // Créer la table des catégories
        $connexion->exec("CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(50) NOT NULL,
            description TEXT,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        return $connexion;
    } catch(PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// Obtenir tous les plats
function obtenirTousLesPlats() {
    try {
        $connexion = ouvrirConnexion();
        $requete = "SELECT * FROM plats_menu ORDER BY id DESC";
        return $connexion->query($requete)->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Erreur lors de la récupération des plats : " . $e->getMessage());
    }
}

// Obtenir un plat par ID
function obtenirPlatParId($id) {
    try {
        $connexion = ouvrirConnexion();
        $requete = $connexion->prepare("SELECT * FROM plats_menu WHERE id = ?");
        $requete->execute([$id]);
        return $requete->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Erreur lors de la récupération du plat : " . $e->getMessage());
    }
}

// Ajouter un plat
function ajouterPlat($nom, $description, $prix, $categorie, $image = null) {
    try {
        $connexion = ouvrirConnexion();
        
        $urlImage = '';
        if ($image && $image['error'] === 0) {
            $dossierUpload = 'assets/img/menu/';
            if (!file_exists($dossierUpload)) {
                mkdir($dossierUpload, 0777, true);
            }
            $urlImage = $dossierUpload . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $urlImage);
        }
        
        $requete = $connexion->prepare("INSERT INTO plats_menu (nom, description, prix, categorie, url_image) VALUES (?, ?, ?, ?, ?)");
        return $requete->execute([$nom, $description, $prix, $categorie, $urlImage]);
    } catch(PDOException $e) {
        die("Erreur lors de l'ajout du plat : " . $e->getMessage());
    }
}

// Modifier un plat
function modifierPlat($id, $nom, $description, $prix, $categorie, $image = null) {
    try {
        $connexion = ouvrirConnexion();
        
        // Get current image URL
        $platActuel = obtenirPlatParId($id);
        $urlImage = $platActuel['url_image'];
        
        if ($image && $image['error'] === 0) {
            $dossierUpload = 'assets/img/menu/';
            if (!file_exists($dossierUpload)) {
                mkdir($dossierUpload, 0777, true);
            }
            $urlImage = $dossierUpload . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $urlImage);
        }
        
        $requete = $connexion->prepare("UPDATE plats_menu SET nom = ?, description = ?, prix = ?, categorie = ?, url_image = ? WHERE id = ?");
        return $requete->execute([$nom, $description, $prix, $categorie, $urlImage, $id]);
    } catch(PDOException $e) {
        die("Erreur lors de la modification du plat : " . $e->getMessage());
    }
}

// Supprimer un plat
function supprimerPlat($id) {
    try {
        $connexion = ouvrirConnexion();
        // Delete image file if exists
        $plat = obtenirPlatParId($id);
        if ($plat && !empty($plat['url_image']) && file_exists($plat['url_image'])) {
            unlink($plat['url_image']);
        }
        
        $requete = $connexion->prepare("DELETE FROM plats_menu WHERE id = ?");
        return $requete->execute([$id]);
    } catch(PDOException $e) {
        die("Erreur lors de la suppression du plat : " . $e->getMessage());
    }
}

// Rechercher des plats
function rechercherPlats($terme) {
    $connexion = ouvrirConnexion();
    $requete = "SELECT * FROM plats_menu 
               WHERE nom LIKE '%" . $terme . "%' 
               OR description LIKE '%" . $terme . "%' 
               OR categorie LIKE '%" . $terme . "%'";
    $resultat = $connexion->query($requete);
    return $resultat->fetchAll(PDO::FETCH_ASSOC);
}
?>
