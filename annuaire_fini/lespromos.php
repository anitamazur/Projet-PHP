<?php

session_start() ;

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
#$salt = "ashrihgbjnbfj";
#$pass = crypt($_SESSION['pass'], $salt);
$mail = $_SESSION['mail'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - les promos","Annuaire M2 DEFI", "Les promotions",$id_role) ;

		echo"<table border=\"1px\">
			<th colspan= 8> Les Promotions</th>
			<tr>
			<td>Promo</td>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Contact</td>
			<td>Statut</td>
			<td>Situation actuelle</td>
			<td>Date d'inscription</td>
			<td>Date de mise à jour du profil</td>
			</tr>";
	
	$res_p = mysql_query("SELECT *			
		FROM utilisateur AS u, role AS r, roles_utilisateur AS ru 
		WHERE u.id = ru.id_utilisateur
		AND r.id = ru.id_role
		AND ru.id_role = 1 or ru.id_role = 2
		AND u.nom!='mazur' AND u.nom!='admin' AND u.prenom !='anita' AND u.prenom !='admin'");
	
## mise en place de la condition "AND u.nom!='mazur' AND u.nom!='admin' AND u.prenom !='anita' AND u.prenom !='admin'" pour ne pas fausser les résultats	

	while ($ligne = mysql_fetch_object($res_p)) {
				$promo_annee_promo=$ligne->annee_promo;
				$promo_id_role=$ligne->id_role;
				$promo_id_utilisateur = $ligne->id;
				$promo_mail=$ligne->mail;
				$promo_mail_pro=$ligne->mail_pro;
				$promo_nom = $ligne->nom;
				$promo_prenom = $ligne->prenom;
				$promo_role = $ligne->nom_role;
				$promo_date_inscription = $ligne->date_inscription;
				$promo_date_maj_profil = $ligne->date_maj_profil;

				
						echo "<tr>";
						
				
				echo"<td>$promo_annee_promo</td>";
				echo "<td>$promo_nom</td>";
				echo "<td>$promo_prenom</td>";
				
				if ($promo_mail !="")
						{
						echo "<td>$promo_mail<br/>";
						}
				if ($promo_mail_pro !="")
						{
				echo "$promo_mail_pro</td>";
						}
				else { echo "_</td>";}
				
			#	echo "<td>$promo_role</td>";
				
							
						## si ancien etudiant ##
						if ($promo_id_role ==1 )
						{
						$res_statut= mysql_query ("SELECT *			
										FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
										WHERE u.id = ru.id_utilisateur
										AND u.id = sa.id_utilisateur
										AND r.id = ru.id_role
										AND s.id = sa.id_statut
										AND ru.id_role = 1 AND u.id ='$promo_id_utilisateur'");
							
							if(mysql_num_rows($res_statut) > 0)
									#while ($ligne = mysql_fetch_object($res_statut2))
									{
									$ligne=mysql_fetch_object($res_statut) ;
									
									$promo_id_statut=$ligne->id_statut;
										$promo_statut = $ligne->nom_statut;		
										echo "<td>$promo_statut</td>";
						 # si en poste ##
							if ($promo_id_statut==2)
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
									AND sa.id_statut = 2 AND ru.id_role =1 AND u.id ='$promo_id_utilisateur'";
		
								$res_statut2 = mysql_query($req_statut2) ;
								
								if(mysql_num_rows($res_statut2) > 0)
									#while ($ligne = mysql_fetch_object($res_statut2))
									{		
											$ligne=mysql_fetch_object($res_statut2) ;
											
											$promo_poste = $ligne->nom_poste;
											$promo_nom_ent = $ligne->nom_entreprise;
											$promo_web_ent = $ligne->siteweb_entreprise;
											$promo_secteur_ent = $ligne->secteur_entreprise;
											$promo_ville = $ligne->nom_ville;
											$promo_cp = $ligne->cp;
											$promo_pays = $ligne->nom_pays;
									
							if ($promo_poste!=""){
								echo "<td>$promo_poste<br/>";
								}
								else { echo "<td>-<br/>";}
							if ($promo_nom_ent!=""){
								echo "$promo_nom_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_web_ent!=""){
								echo "$promo_web_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_secteur_ent!=""){
								echo "$promo_secteur_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_ville!=""){
								echo "$promo_ville<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_cp!=""){
								echo "$promo_cp<br/>";
								}
								else { echo "- <br/>";}
								
							if ($promo_pays!=""){
								echo "$promo_pays</td>";
								}
								else { echo "-</td>";}			
									
									
									
										
										} }
								
							## si en formation ##	
							elseif ($promo_id_statut==3)
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
								AND sa.id_statut = 3 AND ru.id_role = 1 AND u.id ='$promo_id_utilisateur'" ;
								
								$res_statut3 = mysql_query($req_statut3) ;
								
								if(mysql_num_rows($res_statut3) > 0)
									#while ($ligne = mysql_fetch_object($res_statut3)) 
									{
										$ligne=mysql_fetch_object($res_statut3) ;
									
										$promo_diplome = $ligne->diplome;
											$promo_nom_etab = $ligne->nom_etablissement;
											$promo_web_etab = $ligne->siteweb_etablissement;
											$promo_ville = $ligne->nom_ville;
											$promo_cp = $ligne->cp;
											$promo_pays = $ligne->nom_pays;
									
							if ($promo_diplome!=""){
								echo "<td>$promo_diplome<br/>";
								}
								else { echo "<td>-<br/>";}
							if ($promo_nom_etab!=""){
								echo "$promo_nom_etab<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_web_etab!=""){
								echo "$promo_web_etab<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_ville!=""){
								echo "$promo_ville<br/>";
								}
								else { echo "-<br/>";}
							if ($promo_cp!=""){
								echo "$promo_cp<br/>";
								}
								else { echo "- <br/>";}
								
							if ($promo_pays!=""){
								echo "$promo_pays</td>";
								}
								else { echo "-</td>";}	
									} }
							
							
							##si profil ? remplir ou en recherche d'emploi##
							elseif ($promo_id_statut==1 or $promo_id_statut ==4)
								{
								echo "<td>$promo_statut</td>";
								echo "<td> - </td>";
								}
							} }
						else { echo "<td> - </td><td> - </td>"; }						
						
						echo "<td>$promo_date_inscription</td>";
						echo "<td>$promo_date_maj_profil</td>";
						echo "</tr>";
					 }

	  echo "</table>";	
	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	  
	  
	  finhtml();
	  
	  mysql_close();
?>