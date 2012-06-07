<?php

session_start() ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - les promos","Annuaire M2 DEFI", "Les promotions") ;

		echo"<table border=\"1px\">
			<th colspan= 7 >Promotion</th>
			<tr>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Contact</td>
			<td>Statut</td>
			<td>Situation actuelle</td>
			<td>Date d'inscription</td>
			<td>Date de mise à jour du profil</td>
			</tr>";

	$res_p = mysql_query("SELECT *			
		FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
		WHERE u.id = ru.id_utilisateur
		AND u.id = sa.id_utilisateur
		AND r.id = ru.id_role
		AND s.id = sa.id_statut");
					

	while ($ligne = mysql_fetch_object($res_p)) {
				$id_role=$ligne->id_role;
				$id_statut=$ligne->id_statut;
				$mail_pro=$ligne->mail_pro;

					echo"<th colspan=5>$ligne->annee_promo</th>";
						echo "<tr>";
						echo "<td>$ligne->nom</td>";
						echo "<td>$ligne->prenom</td>";
						echo "<td>$ligne->mail<br/>";
						if ($mail_pro !="")
						{
						echo "$mail_pro</td>";
						}
						else { echo "_";}
						echo "<td>$ligne->nom_role</td>";
							
						## si ancien etudiant ##
						if ($id_role ==1 )
						{
						 # si en poste ##
							if ($id_statut==2)
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
								AND pa.id = vp.id_pays";
		
								$res_statut2 = mysql_query($req_statut2) ;
								
									while ($ligne = mysql_fetch_object($res_statut2)){
									
											echo "<td>$ligne->nom_poste<br/>";
											echo"$ligne->nom_entreprise<br/>";
											echo"$ligne->siteweb_entreprise<br/>";
											echo"$ligne->secteur_entreprise<br/>";
											echo "$ligne->nom_ville<br/>";
											echo "$ligne->cp<br/>";
											echo "$ligne->nom_pays</td>";
											
										} }
								
							## si en formation ##	
							elseif ($id_statut==3)
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
								AND p.id = vp.id_pays" ;
								
								$res_statut3 = mysql_query($req_statut3) ;
								
									while ($ligne = mysql_fetch_object($res_statut3)) {
											
											echo "<td>$ligne->diplome_etudes<br/>";
											echo "$ligne->nom_etablissement<br/>";
											echo "$ligne->siteweb_etablissement<br/>";
											echo "$ligne->nom_ville<br/>";
											echo "$ligne->cp<br/>";
											echo "$ligne->nom_pays</td>";
									} }
							
							
							##si profil ? remplir ou en recherche d'emploi##
							elseif ($id_statut==1 or $id_statut ==4)
								{
								echo "<td>$ligne->nom_statut</td>";
								echo "<td> - </td>";
								}
							}
						
						echo "</tr>";
					 }

	  echo "</table>";	

	debutmenu();
	echo "<li><a href=\"pageAccueil.php\">Accueil</a></li>";
	finmenu();
	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	  
	  
	  finhtml();
	  
	  mysql_close();
?>