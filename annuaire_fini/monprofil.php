<?php

session_start() ;
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$mail = $_SESSION['mail'] ;
$annee_promo = $_SESSION['annee_promo'];
$id_role = $_SESSION['id_role'];
$id_statut = $_SESSION['id_statut'];


require_once("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Mon profil","Annuaire M2 DEFI", "Mon profil",$id_role) ; 

$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND ru.id_role='$id_role' AND sa.id_statut='$id_statut'
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
	$mail_pro = $ligne->mail_pro ;
	$pass = $ligne->pass ;
	$id = $ligne->id ;
	$date_inscription=$ligne->date_inscription;
	$date_maj_profil=$ligne->date_maj_profil;

## si ancien etudiant ##	
	if ($_SESSION['id_role'] == 1)
	
		{
		echo "<p> $nom $prenom <br/>";
		echo "	Année de la promotion : $annee_promo <br/>";
		echo "	Adresse mail personelle: $mail <br/>";
		echo "	Adresse mail professionnelle : $mail_pro </p>";
		echo "<p> $role<br/>$statut</p>";
	
		## en poste ##
		
					if ($_SESSION['id_statut'] == 2)
					{
					
					$req_statut2="SELECT *
							FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa
							WHERE u.id = pu.id_utilisateur
							AND u.id = eu.id_utilisateur
							AND u.id = sa.id_utilisateur
							AND p.id = pu.id_poste
							AND p.id = pde.id_poste
							AND e.id = eu.id_entreprise
							AND e.id = pde.id_entreprise
							AND e.id = ev.id_entreprise
							AND vi.id = ev.id_entreprise
							AND vi.id = vp.id_ville
							AND u.nom='$nom' AND u.prenom='$prenom'";
					
					$res_statut2 = mysql_query($req_statut2) ;
				
				while ($ligne = mysql_fetch_object($res_statut2)) {
					
				#	if (mysql_num_rows($res_statut2) > 0) {
			#		$ligne=mysql_fetch_object($res_statut2) ; 
			
						$poste = $ligne->nom_poste ;
						$nom_entreprise = $ligne->nom_entreprise ;
						$siteweb_entreprise = $ligne->siteweb_entreprise ;
						$secteur_entreprise = $ligne->secteur_entreprise ;
						$nom_ville = $ligne->nom_ville ; 
						$cp = $ligne->cp ;
						$pays = $ligne->nom_pays ;
					
					echo "
						<p>Poste : $nom_poste <br/>
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
					FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa
					WHERE u.id = eu.id_utilisateur
					WHERE u.id = sa.id_utilisateur
					AND u.id = etau.id_utilisateur
					AND e.id = eu.id_etudes
					AND eta.id = etau.id_etablissement
					AND eta.id = etav.id_etablissement
					AND v.id = vp.id_ville
					AND v.id = etav.id_ville
					AND p.id = vp.id_pays
					AND u.nom='$nom' AND u.prenom='$prenom'" ;
						
				$res_statut3 = mysql_query($req_statut3) ;
				
				while ($ligne = mysql_fetch_object($res_statut3)) { 
					
				if (mysql_num_rows($res_statut3) > 0) {
				$ligne=mysql_fetch_object($res_statut3) ; 
				
					$diplome = $ligne->diplome_etudes ;
					$nom_etablissement = $ligne->nom_etablissement ;
					$siteweb_etablissement = $ligne->siteweb_etablissement ;
					$nom_ville = $ligne->nom_ville ; 
					$cp = $ligne->cp ;
					$pays = $ligne->nom_pays ;
				
				
				echo "<p>
					Diplôme : $diplome <br/>
					Etablissement : $nom_etablissement <br/>
					Adresse web de l'établissement : $siteweb_etablissement <br/>
					$nom_ville - $cp - $pays </p>";
					
					}
		
				}
		
		## profil à remplir ou en recherche d'emploi ## --> rien à afficher
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";

		
		} 


		}
	
	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";




finhtml() ;

mysql_close() ;

?>
