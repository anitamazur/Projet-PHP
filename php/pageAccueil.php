<?php
require("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$pass = $_POST['mdp'] ;

$connexion = connexion() ;

$req = "select * from utilisateur where nom='$nom' AND prenom='$prenom' AND naisance='$naissance' AND pass='$pass'" ;
$res = mysql_query($req) ;

$ligne=mysql_fetch_object($res) ;
	$id = $ligne->id ;
	$nom = $ligne->nom ;
	$prenom = $ligne->prenom ;

$req_b = "select role,id_role,u.id from role AS r,role_utilisateur AS ru, utilisateur AS u where r.id=ru.id_role and u.id=ru.id_utilisateur and id_utilisateur='$id'" ; 

$res_b = mysql_query($req_b) ;
$ligne=mysql_fetch_object($res_b) ;
	$id_utilisateur = $ligne->id_utilisateur;
	$id_role = $ligne->id_role;
	$role = $ligne->role;

if(mysql_num_rows($res) > 0)
	{
	session_start() ;
	$ligne=mysql_fetch_object($res) ;
	$_SESSION['nom'] = $ligne->nom ;
	$_SESSION['prenom'] = $ligne->prenom ; 

	$prenom = ucfirst(strtolower($_SESSION['prenom']));
	$nom = ucfirst(strtolower($_SESSION['nom']));

	debutpagehtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
	
			
		if ($role = 'Etudiant Actuel')
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
			}
		if ($role = 'Ancien étudiant')
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($role = 'Enseignant')
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"administration.html\">Administration</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($role = 'Administrateur')
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"administration.html\">Administration</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}

	endpagehtml() ;
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	}
  
else
	{
	echo "<h2>Mauvaise identification</h2>
	<h3 class=\"erreur\"><a href=\"connexion.php\">Redirection vers le formulaire de connexion</a></h3>\n" ; 
  }
    
mysql_close() ;
?>
