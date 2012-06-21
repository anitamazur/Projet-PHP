<?php

session_start() ;
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$mail = $_SESSION['mail'] ;
$annee_promo = $_SESSION['annee_promo'];
$id_role = $_SESSION['id_role'];
$id_statut = $_SESSION['id_statut'];

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Ma promo","Annuaire M2 DEFI", "Ma promotion",$id_role) ;

echo"<table border=\"1px\">
<th colspan=\"6\">Promotion</th>
<tr>
<td>Nom</td>
<td>Prénom</td>
<td>Contact</td>
<td>Statut</td>
<td>Situation actuelle</td>
<td>Email Pro</td>
</tr>
<th colspan=\"6\">$annee_promo</th>
<tr>
";

$req = "SELECT *
FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa
WHERE u.id = ru.id_utilisateur
AND u.id = sa.id_utilisateur
AND r.id = ru.id_role
AND s.id = sa.id_statut
AND u.nom='$nom' AND u.prenom='$prenom' " ;

$res = mysql_query($req) ;

							while ($ligne = mysql_fetch_object($res))
							{
							$promo_annee_promo = $ligne->annee_promo ;

							$res_p = mysql_query("SELECT *
							FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa
							WHERE u.id = ru.id_utilisateur
							AND u.id = sa.id_utilisateur
							AND r.id = ru.id_role
							AND s.id = sa.id_statut
							AND u.annee_promo = '$promo_annee_promo'");


							while ($ligne = mysql_fetch_object($res_p)) {
							$promo_nom_niveau = $ligne->nom_niveau ;
							$promo_prenom_niveau = $ligne->prenom_niveau ;
							$promo_mail_niveau = $ligne->mail_niveau ;
							$promo_mailPro_niveau = $ligne->mailPro_niveau ;
							$promo_id_role = $ligne->id_role;
							$promo_id_statut = $ligne->id_statut;

										if ($_SESSION['id_role'] == 1)
										{
										#condition sur le nom et prénom
										if ($promo_nom_niveau == 'public' && $promo_prenom_niveau == 'public')
										{
										echo "<td>$ligne->nom</td>";
										echo "<td>$ligne->prenom</td>";
										}
										else { echo "<td>-</td> <td>-</td> ";}

										#condition sur le mail perso
										if ($promo_mail_niveau == 'public')
										{
										echo "<td>$ligne->mail</td>";
										}
										else { echo "<td>-</td> ";}

									
									#	echo "<td>$ligne->nom_role</td>";

									echo "<td>$ligne->nom_statut</td>";
									
										## si ancien etudiant ##
										if ($promo_id_role ==1 )
										{
										# si en poste ##
										if ($promo_id_statut==2)
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
										AND u.annee_promo='$promo_annee_promo' AND ru.id_role = 1 AND sa.id_statut = 2";

										$res_statut2 = mysql_query($req_statut2) ;

										while ($ligne = mysql_fetch_object($res_statut2)){
										$promo_nomPoste_niveau=$ligne->nomPoste_niveau;
										$promo_nomEntreprise_niveau=$ligne->nomEntreprise_niveau;
										$promo_sitewebEntreprise_niveau=$ligne->sitewebEntreprise_niveau;
										$promo_secteurEntreprise_niveau=$ligne->secteurEntreprise_niveau;
										$promo_nomVille_niveau=$ligne->nomVille_niveau;
										$promo_cp_niveau=$ligne->cp_niveau;
										$promo_nomPays_niveau=$ligne->nomPays_niveau;

										## condition sur le poste
										if ($promo_nomPoste_niveau == 'public')
										{
										echo "<td>$ligne->nom_poste<br/>";
										}
										else {echo " <td> - <br/>";}

										## condition sur le nom de l'entreprise
										if ($promo_nomEntreprise_niveau == 'public')
										{
										echo"$ligne->nom_entreprise<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le siteweb de l'entreprise
										if ($promo_sitewebEntreprise_niveau == 'public')
										{
										echo"$ligne->siteweb_entreprise<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le secteur de l'entreprise
										if ($promo_secteurEntreprise_niveau == 'public')
										{
										echo"$ligne->secteur_entreprise<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le nom de la ville de l'entreprise
										if ($promo_nomVille_niveau == 'public')
										{
										echo "$ligne->nom_ville<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le code postal de l'entreprise
										if ($promo_cp_niveau == 'public')
										{
										echo "$ligne->cp<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le pays de l'entreprise
										if ($promo_nomPays_niveau == 'public')
										{
										echo "$ligne->nom_pays</td>";
										}
										else {echo " - </td> ";}

										} }

										## si en formation ##
										elseif ($promo_id_statut==3)
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
										AND u.annee_promo='$promo_annee_promo' AND ru.id_role = 1 AND sa.id_statut = 3" ;

										$res_statut3 = mysql_query($req_statut3) ;

										while ($ligne = mysql_fetch_object($res_statut3)) {
										$promo_diplomeEtudes_niveau=$ligne->diplomeEtudes_niveau;
										$promo_nomEtablissement_niveau=$ligne->nomEtablissement_niveau;
										$promo_sitewebEtablissement_niveau=$ligne->sitewebEtablissement_niveau;
										$promo_nomVille_niveau=$ligne->nomVille_niveau;
										$promo_cp_niveau=$ligne->cp_niveau;
										$promo_nomPays_niveau=$ligne->nomPays_niveau;

										## condition sur le diplome
										if ($promo_diplomeEtudes_niveau == 'public')
										{
										echo "<td>$ligne->diplome_etudes<br/>";
										}
										else {echo "<td> - <br/> ";}

										## condition sur le nom de l'etablissement
										if ($promo_nomEtablissement_niveau == 'public')
										{
										echo "$ligne->nom_etablissement<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le siteweb de l'etablissement
										if ($promo_sitewebEtablissement_niveau == 'public')
										{
										echo "$ligne->siteweb_etablissement<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le nom de la ville de l'etablissement
										if ($promo_nomVille_niveau == 'public')
										{
										echo "$ligne->nom_ville<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le code postal de l'?tablissement
										if ($promo_cp_niveau == 'public')
										{
										echo "$ligne->cp<br/>";
										}
										else {echo " - <br/> ";}

										## condition sur le pays de l'etablissement
										if ($promo_nomPays_niveau == 'public')
										{
										echo "$ligne->nom_pays</td>";
										}
										else {echo " - </td> ";}	

										} }


										##si profil ? remplir ou en recherche d'emploi##
										elseif ($promo_id_statut==1 or $promo_id_statut ==4)
										{
										echo "<td> - </td>";
										}
							}
	#condition sur le mail pro
				if ($promo_mailPro_niveau == 'public')
					{
				echo "<td>$ligne->mail_pro</td>";
					}
					else { echo "<td>-</td> ";}

echo "</tr>";
}
} }

echo "</table>";	

echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";


# afficheMenu($id_role);
finhtml();

mysql_close();
?>