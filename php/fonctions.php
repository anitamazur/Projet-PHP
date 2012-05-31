<?php 
function connexion()
	{
    $serveurBD = "localhost"; m# ࡭odifier pour le serveur de la fac
    $nomUtilisateur = "root"; m# ࡭odifier pour le serveur de la fac
    $motDePasse = ""; # modifier pour le serveur de la fac
    $baseDeDonnees = "essai_annuaire"; # BDD de test / Si BDD ok : changer par "annuaire_defi"
   
    $idConnexion = mysql_connect($serveurBD,
                                 $nomUtilisateur,
                                 $motDePasse);
                                 
    #if ($idConnexion !== FALSE) echo "Connexion au serveur reussie<br/>";
    #else echo "Echec de connexion au serveur<br/>";

    $connexionBase = mysql_select_db($baseDeDonnees);
    #if ($connexionBase) echo "Connexion a la base reussie";
    #else echo "Echec de connexion a la base"; 
	} 
	
function debuthtml($titre_head,$titre_header,$titre_contenu)
	{
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<title>$titre_head</title>
		<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"defi.css\" />
	</head>
	<body>
		<div id=\"header\">
			<h1>$titre_header</h1>
		</div>
		<div id=\"contenu\">
		<h2>$titre_contenu</h2>";
	}	

function finhtml()
	{
	echo "</div>
	<div>Projet de fin d'études des étudiants M2 DEFI</div>
	</body>
	</html>
	";
	}
	
function affichetitre($titre, $n)
	{
	echo "<h$n>$titre</h$n>\n" ; 
	} 
	
//fonction permettant de vérifier si l'utilisateur est bien connecté. Si la requête SQL avec le nom, prenom et mot de passe retourne quelque chose, alors l'utlisateur a donnée les bons identifiants.
function connexionUtilisateurReussie() {
	if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['mdp'])) {
		$req = "SELECT id FROM identification WHERE nom='".$_SESSION['nom']."' AND prenom='".$_SESSION['prenom']."' AND pass='".$_SESSION['mdp']."'" ;
		$res = mysql_query($req) ; 
		if(mysql_num_rows($res) > 0) {
			return True;
		} else {
			return False;
		}
	} else {
		return False;
	}
}

// fonction permettant de connaître l'id du rôle de l'utilisateur connecté
function role($id_utilisateur) {
	$requete = "SELECT id_role FROM roles_utilisateur WHERE id_utilisateur = ".$id_utilisateur ;
	$role = mysql_query($requete) ;
	return $role
}

// fonction permettant de connaître le statut d'un ancien étudiant connecté
function statut($id_utilisateur) {
	if(role($id_utilisateur) == 1) {
		$requete = "SELECT id_statut FROM statut_ancien_etudiant WHERE id_utilisateur = ".$id_utilisateur ;
		$role = mysql_query($requete) ;
		return $statut
	}
}

//fonction qui affiche plusieurs types de menus selon son rôle
function afficheMenu($id_utilisateur) {
	echo "<div id=\"menu\">";
	echo "<h2 class=\"menu_title\">Menu</h2>";
	echo "<ul id=\"menu_liens\">";
	if(connexionUtilisateurReussie()) {
		if(role($id_utilisateur) == 1) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"profil.php\">Mon profil</a></li>";
			echo "<li><a href=\"gestion_profil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"ma_promo.php\">Ma promo</a></li>";
			echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
		}
		elseif(role($id_utilisateur) == 2) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"profil.php\">Mon profil</a></li>";
			echo "<li><a href=\"gestion_profil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
		}
		elseif(role($id_utilisateur) >= 3) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"profil.php\">Mon profil</a></li>";
			echo "<li><a href=\"gestion_profil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"administration.php\">Administration</a></li>";
			echo "<li><a href=\"les_promos.php\">Les promos</a></li>";
			echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
		}
	} else {
			echo "<li><a href=\"connexion.php\">Connexion</a></li>";
		}
	echo "</ul>";
	echo "</div>";
}
?>