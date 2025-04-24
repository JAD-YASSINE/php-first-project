<?php
session_start();
include ("Model/model.php");

if (empty($_GET["action"])) $action = "home";
else $action = $_GET["action"];

// Initialize variables
$plats = [];
$termeRecherche = '';
$platAModifier = null;

if ($action == 'admin') {
	// Handle deletion
	if (isset($_GET['supprimer'])) {
		if(supprimerPlat($_GET['supprimer'])) {
			$_SESSION['message'] = "Plat supprimé avec succès.";
		} else {
			$_SESSION['message'] = "Erreur lors de la suppression du plat.";
		}
		header('Location: index.php?action=admin');
		exit();
	}
	
	// Load item for editing
	if (isset($_GET['id'])) {
		$platAModifier = obtenirPlatParId($_GET['id']);
		if (!$platAModifier) {
			$_SESSION['message'] = "Plat non trouvé.";
			header('Location: index.php?action=admin');
			exit();
		}
	}
	
	// Handle form submission (add/edit)
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		$nom = $_POST['nom'] ?? '';
		$description = $_POST['description'] ?? '';
		$prix = $_POST['prix'] ?? '';
		$categorie = $_POST['categorie'] ?? '';
		$image = isset($_FILES['image']) && $_FILES['image']['error'] !== 4 ? $_FILES['image'] : null;
		
		if (isset($_GET['id'])) {
			// Update existing item
			if(modifierPlat(
				$_GET['id'],
				$nom,
				$description,
				$prix,
				$categorie,
				$image
			)) {
				$_SESSION['message'] = "Plat modifié avec succès.";
				header('Location: index.php?action=admin');
				exit();
			} else {
				$_SESSION['message'] = "Erreur lors de la modification du plat.";
			}
		} else {
			// Add new item
			if(ajouterPlat(
				$nom,
				$description,
				$prix,
				$categorie,
				$image
			)) {
				$_SESSION['message'] = "Plat ajouté avec succès.";
				header('Location: index.php?action=admin');
				exit();
			} else {
				$_SESSION['message'] = "Erreur lors de l'ajout du plat.";
			}
		}
	}
	
	$vue = "vAdmin.php";
} elseif ($action == 'about') {
	$vue = "vAbout.php";
} elseif ($action == 'contact') {
	$vue = "vContact.php";
} elseif ($action == 'menu') {
	$vue = "vMenu.php";
} elseif ($action == 'home') {
	$vue = "vHome.php";
} else {
	$vue = "vServices.php";
}

include("Vue/" . $vue);
include("Vue/Template.php");
?>