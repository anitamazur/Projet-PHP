<?php

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Mon profil","Annuaire M2 DEFI", "Mon profil") ;


$req = "SELECT * from utilisateur where nom='$nom' AND prenom='$prenom' " ;

$res = mysql_query($req) ;

if(mysql_num_rows($res) > 0)
{
$ligne=mysql_fetch_object($res) ;
$_SESSION['nom'] = $ligne->nom ;
$_SESSION['prenom'] = $ligne->prenom ;
$id_utilisateur = $ligne->id ;

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
	AND u.id='$id_utilisateur'";

$res_profil = mysql_query($req_profil) ;

while ($ligne = mysql_fetch_object($res_profil)) {
						
						echo "".$ligne->nom."".$ligne->prenom."";
						echo "".$ligne->mail."";
						echo "".$ligne->role."";
						if ($role =1)
							{
							echo "".$ligne->statut."";
							
							if ($statut=1)
								{
								echo"".$ligne->annee_promo."";
								echo "".$ligne->diplome_etudes."</br>
								".$ligne->nom_etablissement" </br>".$ligne->siteweb_etabllissement." ".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays."";
								
								}
							elseif ($statut=2)
								{
								echo"".$ligne->annee_promo."";
								echo "".$ligne->nom_poste."</br>
								".$ligne->nom_entreprise" </br>".$ligne->siteweb_entreprise." ".$ligne->secteur_entreprise." ".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays."";
								
								}
							elseif ($statut=3)
								{
								echo"".$ligne->annee_promo."";
								echo "".$ligne->statut."";
								}
							echo "
								<p><a href=\"pageAccueil.php\">Accueil</a></p>  
								<p><a href=\"mapromo.php\">Ma promo</a></p>
								<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
								<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
								<p><a href=\"deconnexion.php\">Déconnexion</a></p>";	
								
							}
						if ($role = 2)
							{
							echo"".$ligne->annee_promo."";
							echo "".$ligne->diplome_etudes."</br>
								".$ligne->nom_etablissement" </br> ".$ligne->siteweb_etabllissement." ".$ligne->nom_ville." ".$ligne->cp." ".$ligne->nom_pays."";
							
							echo "
								<p><a href=\"pageAccueil.php\">Accueil</a></p>  
								<p><a href=\"mapromo.php\">Ma promo</a></p>
								<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
								<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
								<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
							
							}
							
						else {
							echo "
							<p><a href=\"pageAccueil.php\">Accueil</a></p>  
							<a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
							<p><a href=\"Gestiondeprofil.php\">Gestion de mon profil</a></p>
							<p><a href=\"Administration.php\">Administration</a></p>
							<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
						
						}
						
						echo "".$ligne->date_inscription.""
						echo "".$ligne->date_maj_profil.""
					
					}


	  echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	  
	  finhtml();
	  
	  mysql_close();
?>