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

$req_anneepromo = "SELECT * from utilisateurwhere nom='$nom' AND prenom='$prenom' " ;

$res_anneepromo = mysql_query($req_anneepromo) ;

if(mysql_num_rows($res_anneepromo) > 0)
{
$ligne=mysql_fetch_object($res) ;
$_SESSION['nom'] = $ligne->nom ;
$_SESSION['prenom'] = $ligne->prenom ;
$annee_promo = $ligne->annee_promo ;

$req_promo = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp,etudes AS et, etudes_utilisateur AS etu, etablissement AS eta, etablissement_utilisateur AS etau
	WHERE u.id = ru.id_utilisateur
	AND u.id = sa.id_utilisateur
	AND r.id = ru.id_role
	AND s.id = sa.id_statut
	AND u.id = pu.id_utilisateur
	AND u.id = eu.id_utilisateur
	AND u.id = etu.id_utilisateur
	AND u.id = etau.id_utilisateur
	AND vi.id = vp.id_ville
	AND pa.id = vp.id_pays
	AND e.id = eu.id_entreprise
	AND e.id = pde.id_entreprise
	AND e.id = ev.id_entreprise
	AND vi.id = ev.id_entreprise
	AND et.id = etu.id_etudes
	AND eta.id = etau.id_etablissement
	AND v.id = etav.id_ville
	AND vi.id = vp.id_ville
	AND pa.id = vp.id_pays
	AND annee_promo='$annee_promo' ORDER BY nom";

$res_promo = mysql_query($req_promo) ;

while ($ligne = mysql_fetch_object($res_promo)) {
						echo"<th>".$ligne->annee_promo."</th>";
						echo "<tr>";
						echo "<td>".$ligne->nom."</td>";
						echo "<td>".$ligne->prenom."</td>";
						echo "<td>".$ligne->mail."</td>";
						echo "<td>".$ligne->nom_role."</td>";
						if ($id_role =1)
							{
							echo "<td>".$ligne->nom_statut."</td>";
							if ($id_statut=1)
								{
								echo "<td>".$ligne->diplome_etudes."";
								echo "".$ligne->nom_etablissement."";
								echo "".$ligne->siteweb_etabllissement."";
								echo"".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays." </td>";
								}
							elseif ($id_statut=2)
								{
								echo "<td>".$ligne->nom_poste."";
								echo"".$ligne->nom_entreprise."";
								echo"".$ligne->siteweb_entreprise."";
								echo"".$ligne->secteur_entreprise."";
								echo"".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays." </td>";
								}
							elseif ($id_statut=3)
								{
								echo "<td>-</td>";
								}
							}
						if ($id_role = 2)
							{
								echo "<td>".$ligne->diplome_etudes."";
								echo "".$ligne->nom_etablissement."";
								echo "".$ligne->siteweb_etabllissement."";
								echo"".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays." </td>";
							}
						
						echo "<td>".$ligne->date_inscription."<td>";
						echo "<td>".$ligne->date_maj_profil."<td>";
						echo "</tr>";
					} }

	  echo "</table>";	

	  echo "<p>Si vous rencontrez des probl�mes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	  
	  finhtml();
	  
	  mysql_close();
?>
