<?php

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Ma promo","Annuaire M2 DEFI", "Ma promotion") ;

		echo"<table border=\"1px\">
			<th colspan=5 >Promotion</th>
			<tr>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Contact</td>
			<td>Statut</td>
			<td>Situation actuelle</td>
			</tr>";

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
	$nom = $ligne->nom ;
	$prenom = $ligne->prenom ; 	
	$id_role = $ligne->id_role ;
	$id_statut = $ligne->id_statut ;
	$role = $ligne->nom_role ;
	$statut = $ligne->nom_statut ; 
	$annee_promo = $ligne->annee_promo ;
	$mail = $ligne->mail ;
	$pass = $ligne->pass ;
	$id = $ligne->id ;

$res_p = mysql_query("SELECT *			
					FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
					WHERE u.id = ru.id_utilisateur
					AND u.id = sa.id_utilisateur
					AND r.id = ru.id_role
					AND s.id = sa.id_statut
					AND u.annee_promo = '$annee_promo'");
					

while ($ligne = mysql_fetch_object($res_p)) {
						
						echo"<th colspan=5>$ligne->annee_promo</th>";
						echo "<tr>";
						echo "<td>$ligne->nom</td>";
						echo "<td>$ligne->prenom</td>";
						echo "<td>$ligne->mail </td>";
						echo "<td>$ligne->nom_role</td>";
							
						
						if ($id_role ==1 && $id_statut==2)
								{
								echo "<td>$ligne->nom_statut</td>";
								
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
								AND u.annee_promo='$annee_promo'";
		
								$res_statut2 = mysql_query($req_statut2) ;
								
									while ($ligne = mysql_fetch_object($res_statut2)){
								
											echo "<td>$ligne->nom_poste<br/>";
											echo"$ligne->nom_entreprise<br/>";
											echo"$ligne->siteweb_entreprise<br/>";
											echo"$ligne->secteur_entreprise<br/>";
											echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
								
								} }
								
								
							elseif ($id_role == 1 && $id_statut==3)
								{
								echo "<td>$ligne->nom_statut</td>";
								
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
								AND u.annee_promo='$annee_promo'" ;
								
								$res_statut3 = mysql_query($req_statut3) ;
								
									while ($ligne = mysql_fetch_object($res_statut3)) {
								
								echo "<td>$ligne->diplome_etudes<br/>";
								echo "$ligne->nom_etablissement<br/>";
								echo "$ligne->siteweb_etablissement<br/>";
								echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
								} }
							
							
							
							elseif ($id_role== 1 && ($id_statut==1 or $id_statut==4))
								{
								echo "<td>$ligne->nom_statut</td>";
								}
							
						if ($id_role == 2)
							{
							
							$req_statut2 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
								WHERE u.id = eu.id_utilisateur
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND u.annee_promo='$annee_promo'" ;
								
								$res_statut2 = mysql_query($req_statut2) ;
								
									while ($ligne = mysql_fetch_object($res_statut2)) {
								
								echo "<td>$ligne->diplome_etudes<br/>";
								echo "$ligne->nom_etablissement<br/>";
								echo "$ligne->siteweb_etablissement<br/>";
								echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
							} }




						
						echo "</tr>";
					 } }

	  echo "</table>";	

	  echo "<p><a href=\"pageAccueil.php\">Retour à la page d'accueil de l'annuaire</a></p>";
	  echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	  
	  finhtml();
	  
	  mysql_close();
?>