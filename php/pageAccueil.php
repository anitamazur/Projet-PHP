<?php
require_once("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$mail = $_POST['mail'] ;
$salt = "ashrihgbjnbfj";
$pass = crypt($_POST['mdp'], $salt);

session_start() ;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['naissance'] = $naissance;
$_SESSION['pass'] = $pass;

$connexion = connexion() ; 



if(connexionUtilisateurReussie())

{
	

	$req = "SELECT * 
		FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
		WHERE u.id = ru.id_utilisateur
		AND u.id = sa.id_utilisateur
		AND r.id = ru.id_role
		AND s.id = sa.id_statut
		AND nom='$nom' AND prenom='$prenom' AND naissance='$naissance' AND pass='$pass'" ;
	$res = mysql_query($req) ;
	$ligne=mysql_fetch_object($res) ;
	$nom = $ligne->nom ;
	$prenom = $ligne->prenom ; 	
	$id_role = $ligne->id_role ;
	$id_statut = $ligne->id_statut ;
	$role = $ligne->nom_role ;
	$statut = $ligne->nom_statut ; 
	$annee_promo = $ligne->annee_promo ;
	$mail = $ligne->mail ;
	$pass = $ligne->pass ;
	$prenom = ucfirst(strtolower($prenom));
	$nom = ucfirst(strtolower($nom));
	$date_inscription = date($ligne->date_inscription) ;
	$date_inscription_plus_un_an = strtotime(date("Y-m-d", strtotime($date_inscription)) . " +12 month");
	$date_inscription_plus_un_an = date("Y-m-d",$date_inscription_plus_un_an);
	$date_maj_profil = date($ligne->date_maj_profil) ;

	debuthtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
	 
	
		if ($id_role == 1)
		{ 			
			affichetitre("Vos informations personnelles :","3") ;
			echo "<p>$nom $prenom</p>
			<p><strong>$role</strong> : $statut</p>
			<p><strong>Année de la promotion</strong> : $annee_promo</p>
			<p><strong>Adresse mail</strong> : $mail </p><br/>";	
			
			if ($id_statut == 1) {
				echo "<p>Veuillez remplir votre profil en cliquant sur l'onglet <a href=\"Gestiondeprofil.php\">Gestion de mon profil</a>.</p>";
			}
			
			elseif (($id_statut != 1) && ($date_maj_profil > $date_inscription_plus_un_an)) {
				echo "<p>Veuillez mettre à jour votre profil en cliquant sur l'onglet <a href=\"Gestiondeprofil.php\">Gestion de mon profil</a>.</p>";
			} 
			
			

			
			
		elseif ($id_role == 2)
		{
			affichetitre("2","vos informations personnelles :") ;
			echo "<p>$nom $prenom</p>
			<p><strong>$role</strong> : $statut</p>
			<p><strong>Année de la promotion</strong> : $annee_promo</p>
			<p><strong>Adresse mail</strong> : $mail </p><br/>";
		}
		
		
		elseif ($id_role == 3 or $id_role == 4)
		{
			affichetitre("2","Vos informations personnelles :") ;
			echo "<p>$nom $prenom</p>
			<p><strong>$role</strong> : $statut</p>
			<p><strong>Adresse mail</strong> : $mail </p><br/>";
		}

	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	afficheMenu($id_role);
	finhtml() ;
	}
}
  
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
?>
