<?php

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Mon profil","Annuaire M2 DEFI", "Mon profil") ; 

$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND nom='$nom' AND prenom='$prenom' " ;
$res = mysql_query($req) ;

$ligne=mysql_fetch_object($res) ;
	$_SESSION['nom'] = $ligne->nom ;
	$_SESSION['prenom'] = $ligne->prenom ; 	
	$id_role = $ligne->id_role ;
	$id_statut = $ligne->id_statut ;
	$role = $ligne->nom_role ;
	$statut = $ligne->nom_statut ; 
	$annee_promo = $ligne->annee_promo ;
	$mail = $ligne->mail ;
	$pass = $ligne->pass ;

	if ($id_role = 1)
		{ 
		
		affichetitre("Vos informations personnelles :","3") ;
		echo "<p>$nom $prenom <br/> 
		Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";	
		
		$req_role1 = "SELECT * 
					FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
					WHERE u.id = eu.id_utilisateur
					AND u.id = etau.id_utilisateur
					AND e.id = eu.id_etudes
					AND eta.id = etau.id_etablissement
					AND v.id = vp.id_ville
					AND v.id = etav.id_ville
					AND p.id = vp.id_pays
					AND nom='$nom'" ;
		$res_role1 = mysql_query($req_role1) ;
		
		if(mysql_num_rows($res_role1) > 0)
	{

		$ligne=mysql_fetch_object($res_role1) ; 	
			$diplome = $ligne->diplome_etudes ;
			$nom_etablissement = $ligne->nom_etablissement ;
			$siteweb_etablissement = $ligne->siteweb_etablissement ;
			$nom_ville = $ligne->nom_ville ; 
			$cp = $ligne->cp ;
			$pays = $ligne->nom_pays ;
		
		echo "Diplôme : $diplome <br/>
			Etablissement : $nom_etablissement <br/>
			Adresse web de l'établissement : $siteweb_etablissement <br/>
			$nom_ville - $cp - $pays </p>";
		
			} }
			
			
		elseif ($id_role = 2)
		{
			
		affichetitre("2","vos informations personnelles :") ;
		echo "$nom $prenom <br/> 
		$id_role : $id_statut <br/>
		$annee_promo <br/>
		Adresse mail : $mail <br/>";
		
		echo "
			<p><a href=\"pageAccueil.php\">Accueil</a></p>  
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
		
		}
		
		
		elseif ($id_role = 4)
		{ 
		affichetitre("2","Vos informations personnelles :") ;
		echo "$nom $prenom <br/> 
		$role <br/>
		Adresse mail : $mail <br/>"; }

	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";




finhtml() ;

mysql_close() ;

?>