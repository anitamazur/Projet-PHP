<?php
require("fonctions.php") ;
$connexion = connexion() ;

session_start() ;

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
#$salt = "ashrihgbjnbfj";
#$pass = crypt($_SESSION['pass'], $salt);
$mail = $_SESSION['mail'] ;
$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);

//Requete SQL
$query = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru 
	WHERE u.id = ru.id_utilisateur
	AND r.id = ru.id_role
	AND u.id = '$id_utilisateur'";
	
$result = mysql_query($query) or die(mysql_error());
 
// Ent�tes des colones dans le fichier Excel
$excel="";
$excel .="nom \t prenom \t ann�e_promo \t adresse mail \t r�le \t statut \t situation actuelle \n";
 
//Les resultats de la requette
while($row = mysql_fetch_array($result)) {
		$id_role = $row['id_role'];
	
        $excel .= "$row[nom] \t $row[prenom] \t $row[annee_promo] \t $row[mail] \t $row[nom_role] \n";
	
	if ($id_role == 1)
	{
$res = mysql_query("SELECT * 
			FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
			WHERE u.id = ru.id_utilisateur
			AND u.id = sa.id_utilisateur
			AND r.id = ru.id_role
			AND s.id = sa.id_statut
			AND u.id = '$id_utilisateur'
			AND ru.id_role = '$id_role' AND u.id = '$id_utilisateur'");
			
			while($row = mysql_fetch_array($result)) {
				$id_statut = $row['id_statut'];
			
			$excel .= "$row[nom_statut] \t";
			
				if ($id_statut == 2)
				{
				
				
				$res_statut2=mysql_query("SELECT *
							FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa
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
							AND u.id = sa.id_utilisateur
							AND u.id = '$id_utilisateur'
							AND sa.id_statut = '$id_statut' AND ru.id_role = '$id_role' AND u.id = '$id_utilisateur'");
					
					
					
					while ($row = mysql_fetch_object($res_statut2)){
					$excel .= "$row[nom_poste] \t $row[nom_entreprise] \t $row[siteweb_entreprise] \t $row[secteur_entreprise] \t $row[nom_ville] $row[cp] $row[nom_pays] \n";
							
						}
			
			
			
			}
			
			elseif ($id_statut == 3) 
					{		
						$res_statut3 =mysql_query( "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav AND statut_ancien_etudiant AS sa
								WHERE u.id = eu.id_utilisateur
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND u.id = sa.id_utilisateur
								AND u.id = '$id_utilisateur'
								AND sa.id_statut = '$id_statut' AND ru.id_role = '$id_role' AND u.id = '$id_utilisateur'" );
						
						while ($row = mysql_fetch_object($res_statut3)) {
						$excel .= "$row[diplome] \t $row[nom_etablissement] \t $row[siteweb_etablissement] \t $row[nom_ville] $row[cp] $row[nom_pays] \n";
							
							}}
			else
			{$excel .= "-\n";}
			
			
			}
		
	
	
} }
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=mon_profil.xls");
print $excel;
exit;
?>