<?php
session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;
$naissance = $_SESSION['naissance'] ;
$mail = $_SESSION['mail'] ;
$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);


require_once("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Export xml","Annuaire M2 DEFI", "Export XML") ; 


$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut" ;

$res = mysql_query($req) ;

$xml = '<?xml version="1.0" encoding="utf-8"?>'.'<profil>';
		while ($row = mysql_fetch_array($res)) {
			$xml .= '<personne>';
			$xml .= '<nom>'.$row['nom'].'</nom>';
			$xml .= '<prenom>'.$row['prenom'].'</prenom>';
			$xml .= '<role>'.$row['nom_role'].'</role>';
			
			
			if ($row['id_role'] == 1 && $row['id_statut'] == 2)
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
				AND pa.id = vp.id_pays";
		
		$res_statut2 = mysql_query($req_statut2) ;
		
		
		while ($row = mysql_fetch_array($req_statut2)) {
			$xml .= '<annee_promo>'.$row['annee_promo'].'</annee_promo>';
			$xml .= '<en_poste>';
			$xml .= '<nom_poste>'.$row['nom_poste'].'</nom_poste>';
			$xml .= '<nom_entreprise>'.$row['nom_entreprise'].'</nom_entreprise>';
			$xml .= '<siteweb_entreprise>'.$row['siteweb_entreprise'].'</siteweb_entreprise>';
			$xml .= '<secteur_entreprise>'.$row['secteur_entreprise'].'</secteur_entreprise>';
			$xml .= '<nom_ville>'.$row['nom_ville'].'</nom_ville>';
			$xml .= '<cp>'.$row['cp'].'</cp>';
			$xml .= '<nom_pays>'.$row['nom_pays'].'</nom_pays>';	
			$xml .= '</en_poste>';	
			
			}
		} 
		
		elseif ($row['id_role'] == 1 && $row['id_statut'] == 3) {
		
		$req_statut3 = "SELECT * 
				FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
				WHERE u.id = eu.id_utilisateur
				AND u.id = etau.id_utilisateur
				AND e.id = eu.id_etudes
				AND eta.id = etau.id_etablissement
				AND eta.id = etav.id_etablissement
				AND v.id = vp.id_ville
				AND v.id = etav.id_ville
				AND p.id = vp.id_pays " ;
				
		$res_statut3 = mysql_query($req_statut3) ;
		
		while ($row = mysql_fetch_array($req_statut3)) {
			$xml .= '<annee_promo>'.$row['annee_promo'].'</annee_promo>';
			$xml .= '<en_formation>';
			$xml .= '<diplome_etudes>'.$row['diplome_etudes'].'</diplome_etudes>';
			$xml .= '<nom_etablissement>'.$row['nom_etablissement'].'</nom_etablissement>';
			$xml .= '<siteweb_etablissement>'.$row['siteweb_etablissement'].'</siteweb_etablissement>';
			$xml .= '<nom_ville>'.$row['nom_ville'].'</nom_ville>';
			$xml .= '<cp>'.$row['cp'].'</cp>';
			$xml .= '<nom_pays>'.$row['nom_pays'].'</nom_pays>';	
			$xml .= '</en_formation>';
			}
		}
		
		elseif ($id_role == 1 &&  ( $id_statut == 1 or $id_statut == 4)) {
			$xml .= '<nom_statut>'.$row['nom_statut'].'</nom_statut>';
		
		} 
		


			$xml .= '</personne>';
		}
		$xml .= '</profil>';
		
		$fp = fopen("profils.xml", 'w+');
		fputs($fp, $xml);
		fclose($fp);
		
		echo 'Export XML effectu� !<br><a href="profils.xml">Voir le fichier</a>';
	
		finhtml();
		mysql_close();
?>