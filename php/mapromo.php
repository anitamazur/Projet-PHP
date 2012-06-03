<?php

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Ma promo","Annuaire M2 DEFI", "Ma promotion") ;

		echo"<table border=\"1px\">
			<th>Promotion</th>
			<tr>
			<td>Nom Prénom</td>
			<td>Contact</td>
			<td>Statut</td>
			<td>Situation actuelle</td>
			<td>Date d'inscription</td>
			<td>Date de mise à jour du profil</td>
			</tr>";

$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND nom='$nom' AND prenom='$prenom' " ;

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




while ($ligne = mysql_fetch_object($res)) {
						echo"<th>$annee_promo</th>";
						echo "<tr>";
						echo "<td>$nom</td>";
						echo "<td>$prenom</td>";
						echo "<td>$mail</td>";
						echo "<td>$nom_role</td>";
						if ($id_role ==1)
							{
							echo "<td>$nom_statut</td>";
							if ($id_statut==1)
								{
								
								$req_statut1="SELECT *
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
								AND annee_promo='$annee_promo'";
		
								$res_statut1 = mysql_query($req_statut1) ;
								
									if (mysql_num_rows($res_statut1) > 0) {
											
									$ligne=mysql_fetch_object($res_statut1) ; 	
										$poste = $ligne->nom_poste ;
										$nom_entreprise = $ligne->nom_entreprise ;
										$siteweb_entreprise = $ligne->siteweb_entreprise ;
										$secteur_entreprise = $ligne->secteur_entreprise ;
										$nom_ville = $ligne->nom_ville ; 
										$cp = $ligne->cp ;
										$pays = $ligne->nom_pays ;
								
								echo "<td>$nom_poste";
								echo"$nom_entreprise";
								echo"$siteweb_entreprise";
								echo"$secteur_entreprise";
								echo"$nom_ville $cp $nom_pays</td>";
								
								}
							elseif ($id_statut==2)
								{
								
								$req_statut2 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
								WHERE u.id = eu.id_utilisateur
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND nom='$nom' AND prenom='$prenom'" ;
								
								$res_statut2 = mysql_query($req_statut2) ;
								
									if (mysql_num_rows($res_statut2) > 0) {

									$ligne=mysql_fetch_object($res_statut2) ; 	
										$diplome = $ligne->diplome_etudes ;
										$nom_etablissement = $ligne->nom_etablissement ;
										$siteweb_etablissement = $ligne->siteweb_etablissement ;
										$nom_ville = $ligne->nom_ville ; 
										$cp = $ligne->cp ;
										$pays = $ligne->nom_pays ;
								
								
								echo "<td>$diplome_etudes";
								echo "$nom_etablissement";
								echo "$siteweb_etabllissement";
								echo"$nom_ville $cp $nom_pays</td>";
								}
							elseif ($id_statut==3)
								{
								echo "<td>-</td>";
								}
							}
						if ($id_role == 2)
							{
							
							$req_statut2 = "SELECT * 
											FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
											WHERE u.id = eu.id_utilisateur
											AND u.id = etau.id_utilisateur
											AND e.id = eu.id_etudes
											AND eta.id = etau.id_etablissement
											AND v.id = vp.id_ville
											AND v.id = etav.id_ville
											AND p.id = vp.id_pays
											AND nom='$nom' AND prenom='$prenom'" ;
											
											$res_statut2 = mysql_query($req_statut2) ;
											
												if (mysql_num_rows($res_statut2) > 0) {

												$ligne=mysql_fetch_object($res_statut2) ; 	
													$diplome = $ligne->diplome_etudes ;
													$nom_etablissement = $ligne->nom_etablissement ;
													$siteweb_etablissement = $ligne->siteweb_etablissement ;
													$nom_ville = $ligne->nom_ville ; 
													$cp = $ligne->cp ;
													$pays = $ligne->nom_pays ;
							
								echo "<td>$diplome_etudes";
								echo "$nom_etablissement";
								echo "$siteweb_etabllissement";
								echo"$nom_ville $cp $nom_pays</td>";
							} }
						
						echo "<td>$date_inscription<td>";
						echo "<td>$date_maj_profil<td>";
						echo "</tr>";
					 } } } }

	  echo "</table>";	

	  echo "<p>Si vous rencontrez des probl?mes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	  
	  finhtml();
	  
	  mysql_close();
?>