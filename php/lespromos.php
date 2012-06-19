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

$res_annee = mysql_query ("select annee_promo from utilisateur");
while ($ligne = mysql_fetch_object($res_annee)) {			
	$annee_promo = $ligne->annee_promo;

	if ($annee_promo !=""){
		echo"<th colspan=7>$annee_promo</th>";
		}
		else { echo "<th  colspan=7> - </th>"; }
	
	
	$res_p = mysql_query("SELECT *			
		FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
		WHERE u.id = ru.id_utilisateur
		AND u.id = sa.id_utilisateur
		AND r.id = ru.id_role
		AND s.id = sa.id_statut
		AND ru.id_role = 1 or ru.id_role = 2 AND annee_promo = '$annee_promo'");
					

	while ($ligne = mysql_fetch_object($res_p)) {
				$id_role=$ligne->id_role;
				$id_statut=$ligne->id_statut;
				$mail=$ligne->mail;
				$mail_pro=$ligne->mail_pro;
				$nom = $ligne->nom;
				$prenom = $ligne->prenom;
				$role = $ligne->nom_role;
				$statut = $ligne->nom_statut;

				
						echo "<tr>";
				if ($nom !=""){
						echo "<td>$nom</td>";
				}
				else { echo "<td> - </td>"; }
				if ($prenom !=""){
						echo "<td>$prenom</td>";
				}
				else { echo "<td> - </td>"; }
				if ($mail !="")
						{
						echo "<td>$mail<br/>";
						}
				if ($mail_pro !="")
						{
				echo "$mail_pro</td>";
						}
				else { echo "_</td>";}
				
				echo "<td>$role</td>";

							
						## si ancien etudiant ##
						if ($id_role ==1 )
						{
						 # si en poste ##
							if ($id_statut==2)
								{
							
								echo "<td>$statut</td>";
							
								
								
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
											$poste = $ligne->nom_poste;
											$nom_ent = $ligne->nom_entreprise;
											$web_ent = $ligne->siteweb_entreprise;
											$secteur_ent = $ligne->secteur_entreprise;
											$ville = $ligne->nom_ville;
											$cp = $ligne->cp;
											$pays = $ligne->nom_pays;
									
							if ($poste!=""){
								echo "<td>$poste<br/>";
								}
								else { echo "<td>-<br/>";}
							if ($nom_ent!=""){
								echo "$nom_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($web_ent!=""){
								echo "$web_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($secteur_ent!=""){
								echo "$secteur_ent<br/>";
								}
								else { echo "-<br/>";}
							if ($ville!=""){
								echo "$ville<br/>";
								}
								else { echo "-<br/>";}
							if ($cp!=""){
								echo "$cp<br/>";
								}
								else { echo "- <br/>";}
								
							if ($pays!=""){
								echo "$pays</td>";
								}
								else { echo "-</td>";}			
									
									
									
										
										} }
								
							## si en formation ##	
							elseif ($id_statut==3)
								{
								echo "<td>$statut</td>";
								
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
										$diplome = $ligne->diplome;
											$nom_etab = $ligne->nom_etablissement;
											$web_etab = $ligne->siteweb_etablissement;
											$ville = $ligne->nom_ville;
											$cp = $ligne->cp;
											$pays = $ligne->nom_pays;
									
							if ($poste!=""){
								echo "<td>$diplome<br/>";
								}
								else { echo "<td>-<br/>";}
							if ($nom_etab!=""){
								echo "$nom_etab<br/>";
								}
								else { echo "-<br/>";}
							if ($web_etab!=""){
								echo "$web_etab<br/>";
								}
								else { echo "-<br/>";}
							if ($ville!=""){
								echo "$ville<br/>";
								}
								else { echo "-<br/>";}
							if ($cp!=""){
								echo "$cp<br/>";
								}
								else { echo "- <br/>";}
								
							if ($pays!=""){
								echo "$pays</td>";
								}
								else { echo "-</td>";}	
									} }
							
							
							##si profil ? remplir ou en recherche d'emploi##
							elseif ($id_statut==1 or $id_statut ==4)
								{
								echo "<td>$statut</td>";
								echo "<td> - </td>";
								}
							}
						echo "<td>$ligne->date_inscription</td>";
						echo "<td>$ligne->date_maj_profil</td>";
						echo "</tr>";
					 }}

	  echo "</table>";	

	debutmenu();
	echo "<li><a href=\"pageAccueil.php\">Accueil</a></li>";
	finmenu();
	
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	  
	  
	  finhtml();
	  
	  mysql_close();
?>