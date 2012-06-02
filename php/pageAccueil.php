<?php
require("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$pass = $_POST['mdp'] ;

session_start() ;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['naissance'] = $naissance;
$_SESSION['pass'] = $pass;

$connexion = connexion() ; 

if(isset($_SESSION['nom']) && isset($_SESSION['prenom'])&& isset($_SESSION['naissance'])&& isset($_SESSION['pass']))

{

$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND nom='$nom' AND prenom='$prenom' AND naissance='$naissance' AND pass='$pass'" ;
$res = mysql_query($req) ;


if(mysql_num_rows($res)>0)
	{
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
	

	debuthtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
	 
	
		if ($id_role = 1)
		{ 
			
		affichetitre("Vos informations personnelles :","3") ;
		echo "$nom $prenom <br/> 
		$role : $statut <br/>
		Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/>";	
		
		echo "
		<p><a href=\"monprofil.php\">Mon profil</a></p> 
			<p><a href=\"mapromo.php\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
			}
			
			
		elseif ($id_role = 2)
		{
			
		affichetitre("2","vos informations personnelles :") ;
		echo "$nom $prenom <br/> 
		$id_role : $id_statut <br/>
		$annee_promo <br/>
		Adresse mail : $mail <br/>";
		
		echo "
			<p><a href=\"monprofil.php\">Mon profil</a></p> 
			<p><a href=\"mapromo.php\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		
		
		elseif ($id_role = 3)
		{
		affichetitre("2","Vos informations personnelles :") ;
		echo "$nom $prenom <br/> 
		$role <br/>
		Adresse mail : $mail <br/>";
		
		echo "
		<p><a href=\"monprofil.php\">Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
		<p><a href=\"administration.php\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		
		
		elseif ($id_role = 4)
		{ 
		affichetitre("2","Vos informations personnelles :") ;
		echo "$nom $prenom <br/> 
		$role <br/>
		Adresse mail : $mail <br/>";
		
		echo "
		<p><a href=\"monprofil.php\">Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
		<p><a href=\"administration.php\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}

	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	finhtml() ;
	} }
  
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
?>
