<?php

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;
$naissance = $_SESSION['naissance'] ;


require_once("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Mon profil","Annuaire M2 DEFI", "Mon profil") ; 

$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND u.nom='$nom' AND u.prenom='$prenom' " ;

$res = mysql_query($req) ;

if(mysql_num_rows($res) > 0)
		{
$ligne=mysql_fetch_object($res) ;
	$_SESSION['nom'] = $ligne->nom ;
	$_SESSION['prenom'] = $ligne->prenom ; 	
	$_SESSION['id_role'] = $ligne->id_role ;
	$_SESSION['id_statut'] = $ligne->id_statut ;
	$role = $ligne->nom_role ;
	$statut = $ligne->nom_statut ; 
	$annee_promo = $ligne->annee_promo ;
	$mail = $ligne->mail ;
	$pass = $ligne->pass ;
	$id = $ligne->id ;
	$date_inscription=$ligne->date_inscription;
	$date_maj_profil=$ligne->date_maj_profil;

## si ancien etudiant ##	
	if ($_SESSION['id_role'] == 1)
	
		{
		echo "<p>$nom $prenom <br/> 
		Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";
		
		## en poste ##
		
					if ($_SESSION['id_statut'] == 2)
					{
					
					$req_statut2="SELECT *
							FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp
							WHERE u.id = pu.id_utilisateur
							AND u.id = eu.id_utilisateur
							AND p.id = pu.id_poste
							AND p.id = pde.id_poste
							AND e.id = eu.id_entreprise
							AND e.id = pde.id_entreprise
							AND e.id = ev.id_entreprise
							AND vi.id = ev.id_entreprise
							AND vi.id = vp.id_ville
							AND pa.id = vp.id_pays
							AND u.nom='$nom' AND u.prenom='$prenom'";
					
					$res_statut2 = mysql_query($req_statut2) ;
					
					
					if (mysql_num_rows($res_statut2) > 0) {
							
					$ligne=mysql_fetch_object($res_statut2) ; 	
						$poste = $ligne->nom_poste ;
						$nom_entreprise = $ligne->nom_entreprise ;
						$siteweb_entreprise = $ligne->siteweb_entreprise ;
						$secteur_entreprise = $ligne->secteur_entreprise ;
						$nom_ville = $ligne->nom_ville ; 
						$cp = $ligne->cp ;
						$pays = $ligne->nom_pays ;
					
					echo "<p>$role : $statut <br/><br/>
						Poste : $nom_poste <br/>
						Entreprise : $nom_entreprise <br/>
						Adresse web de l'entreprise : $siteweb_entreprise <br/>
						Secteur de l'entreprise : $secteur_entreprise <br/>
						$nom_ville - $cp - $pays </p>";
						
						}
					
					} 
					
		## en formation ##
		
				elseif ($_SESSION['id_statut'] == 3) 
				{
				
				$req_statut3 = "SELECT * 
						FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
						WHERE u.id = eu.id_utilisateur
						AND u.id = etau.id_utilisateur
						AND e.id = eu.id_etudes
						AND eta.id = etau.id_etablissement
						AND eta.id = etav.id_etablissement
						AND v.id = vp.id_ville
						AND v.id = etav.id_ville
						AND p.id = vp.id_pays
						AND u.nom='$nom' AND u.prenom='$prenom'" ;
						
				$res_statut3 = mysql_query($req_statut3) ;
				
				if (mysql_num_rows($res_statut3) > 0) {

				$ligne=mysql_fetch_object($res_statut3) ; 	
					$diplome = $ligne->diplome_etudes ;
					$nom_etablissement = $ligne->nom_etablissement ;
					$siteweb_etablissement = $ligne->siteweb_etablissement ;
					$nom_ville = $ligne->nom_ville ; 
					$cp = $ligne->cp ;
					$pays = $ligne->nom_pays ;
				
				
				echo "<p>$role : $statut <br/><br/>
					Diplôme : $diplome <br/>
					Etablissement : $nom_etablissement <br/>
					Adresse web de l'établissement : $siteweb_etablissement <br/>
					$nom_ville - $cp - $pays </p>";
					
					}
		
				}
		
		## profil à remplir ou en recherche d'emploi ## --> rien à afficher
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		
		echo "
			<p><a href=\"pageAccueil.php\">Accueil</a></p>  
			<p><a href=\"mapromo.php\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"gestionProfil.php\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		} 

## si etudiant actuel ##		

	elseif ($_SESSION['id_role'] == 2)
			{ 
		
		echo "<p>$nom $prenom </p> 
		<p><strong>Année de la promotion</strong> : $annee_promo </p>
		<p><strong>Adresse mail</strong> : $mail </p>";	
		
	#	$req_statut2 = "SELECT * 
	#			FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
	#			WHERE u.id = eu.id_utilisateur
	#			AND u.id = etau.id_utilisateur
	#			AND e.id = eu.id_etudes
	#			AND eta.id = etau.id_etablissement
	#			AND eta.id = etav.id_etablissement
	#			AND v.id = vp.id_ville
	#			AND v.id = etav.id_ville
	#			AND p.id = vp.id_pays
	#			AND u.nom='$nom' AND u.prenom='$prenom'" ;
				
	#	$res_statut2 = mysql_query($req_statut2) ;
		
	#	if (mysql_num_rows($res_statut2) > 0) {

	#	$ligne=mysql_fetch_object($res_statut2) ; 	
	#		$diplome = $ligne->diplome_etudes ;
	#		$nom_etablissement = $ligne->nom_etablissement ;
	#		$siteweb_etablissement = $ligne->siteweb_etablissement ;
	#		$nom_ville = $ligne->nom_ville ; 
	#		$cp = $ligne->cp ;
	#		$pays = $ligne->nom_pays ;
		
		
	#	echo "<p>$role<br/><br/>
	#		Diplôme : $diplome <br/>
	#		Etablissement : $nom_etablissement <br/>
	#		Adresse web de l'établissement : $siteweb_etablissement <br/>
	#		$nom_ville - $cp - $pays </p>";
			
	#		}
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		
		echo "
			<p><a href=\"pageAccueil.php\">Accueil</a></p>  
			<p><a href=\"mapromo.php\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"gestionProfil.php\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
			}
			
			
## si enseignant ou admin ##		
		
		elseif ($_SESSION['id_role'] == 3 or $_SESSION['id_role'] == 4)
		{
		echo "<p>$role <br/><br/>
		$nom $prenom <br/>
		Adresse mail : $mail <br/></p>";
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		
		echo "
			<p><a href=\"pageAccueil.php\">Accueil</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"gestionProfil.php\">Gestion de mon profil</a></p>
			<p><a href=\"Administration.php\">Administration</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		
		
		}
	
	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";




finhtml() ;

mysql_close() ;

?>
