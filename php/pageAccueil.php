<?php
require("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$pass = $_POST['mdp'] ;

$connexion = connexion() ;


$req = "select * from utilisateur where nom='$nom' AND prenom='$prenom' AND naissance='$naissance' AND pass='$pass'" ;
$res = mysql_query($req) ;

if(mysql_num_rows($res)>0) {
$ligne=mysql_fetch_object($res) ;
$id = $ligne->id ;
$nom = $ligne->nom ;
$prenom = $ligne->prenom ;}



$req_b = "select role,id_role,u.id from role AS r,roles_utilisateur AS ru, utilisateur AS u where r.id=ru.id_role and u.id=ru.id_utilisateur and u.id_utilisateur='$id'" ; 
$res_b = mysql_query($req_b) ;

if(mysql_num_rows($res_b)>0) {
$ligne=mysql_fetch_object($res_b) ;
	$id_role = $ligne->id_role;
	$role = $ligne->role;}

$req_c = "select statut,id_statut, u.id from statut AS s, statut_ancien_etudiant AS sa, utilisateur AS u where s.id=sa.id_statut and u.id=sa.id_utilisateur and id_utilisateur='$id'" ;
$res_c = mysql_query($req_c) ;

if(mysql_num_rows($res_c)>0) {
$ligne=mysql_fetch_object($res_c) ;
	$id_statut = $ligne->id_statut;
	$statut = $ligne->statut; }

if(mysql_num_rows($res)>0)
	{
	session_start() ;
	$ligne=mysql_fetch_object($res) ;
	$_SESSION['nom'] = $ligne->nom ;
	$_SESSION['prenom'] = $ligne->prenom ; 

	$prenom = ucfirst(strtolower($_SESSION['prenom']));
	$nom = ucfirst(strtolower($_SESSION['nom']));

	debutpagehtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
	
			
		if ($id_role = 1)
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
			}
		if ($id_role = 2)
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($id_role = 3)
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
		<p><a href=\"administration.html\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($id_role = 4)
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
		<p><a href=\"administration.html\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}

	endpagehtml() ;
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	}
  
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
?>
