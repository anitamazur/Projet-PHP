<?php
require_once("fonctions.php") ;

//code pour decrypter le mot de passe qui a ?t? crypt? ? l'inscription.


session_start() ;
$connexion = connexion() ;
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$mail = $_SESSION['mail'] ;
$salt = "ashrihgbjnbfj";
$pass = crypt($_SESSION['pass'], $salt);
$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);
$message = "";

$res_pass = mysql_query ("select pass from utilisateur where id = '$id_utilisateur'");
while ($ligne = mysql_fetch_object($res_pass)) { 
$id_pass = $ligne->pass;
$salt = "ashrihgbjnbfj";
$pass = crypt($id_pass, $salt);
}




if(isset($_POST['Supprimer'])) {
	$del_id = $id_utilisateur;
	$del_role = "DELETE FROM roles_utilisateur WHERE roles_utilisateur.id_utilisateur = $del_id";
	$del_statut = "DELETE FROM statut_ancien_etudiant WHERE statut_ancien_etudiant.id_utilisateur = $del_id";
	$del_utilisateur = "DELETE FROM utilisateur WHERE utilisateur.id = $del_id";
	
	if ($id_role == 1) {
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_statut);
		$resultat = mysql_query($del_utilisateur);
	} else {
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_utilisateur);
	}
	
	// Suivant si la suppression a ?t? un succ?s ou pas, on affiche un autre message.						
	if($resultat <> False) {
			$message .= "<p class=\"succes\">Profil supprim? de la base de donn?es.</p>";
	} else {
			$message .= "<p class=\"erreur\">Erreur lors de la suppression.</p>" ;
	}
}
 
 
 ######################## traitement pour modification ##################################
if(isset($_POST['modifier'])) {
	if ($id_role == 1) {
		$mail_modif = stripslashes($_POST['mail']);
		$nom_modif = stripslashes($_POST['nom']);
		$nomPatro_modif = stripslashes($_POST['nomPatro']);
		$prenom_modif = stripslashes($_POST['prenom']);
		$naissance_modif = stripslashes($_POST['naissance']);
		$mdp_modif = stripslashes($_POST['mdp']);
		$affichage_mail_modif = stripslashes($_POST['affichage_mail']);
		$affichage_nom_modif = stripslashes($_POST['affichage_nom']);
		$affichage_nomPatro_modif = stripslashes($_POST['affichage_nomPatro']);
		$affichage_prenom_modif = stripslashes($_POST['affichage_prenom']);
		$affichage_mdp_modif = stripslashes($_POST['affichage_mdp']);

		if ($mail_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail='$mail_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}
		## l'option d'affichage est ind?pendante.
		if ($affichage_mail_modif == 1){
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		} else {
			$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='public'WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");}
		
		if ($nom_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}

		if ($affichage_nom_modif == 1){
				$res_affich_modif = mysql_query ("UPDATE utilisateur  AS u, roles_utilisateur AS ru SET nom_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		} else {
			$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");}
		
		if ($nomPatro_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_patronymique='$nomPatro_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}

		if ($affichage_nomPatro_modif == 1){
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nomPatro_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		} else { $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nomPatro_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}
		
		if ($prenom_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom='$prenom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}
			
		if ($affichage_prenom_modif == 1){
			$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		} else {
			$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
		}
		
		if ($naissance_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET naissance='$naissance_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Date de naissance modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification de la date de naissance.</p>" ;
			}
		}
		
		if ($mdp_modif!="" && $avt_mdp_modif!="" && $confirm_mdp_modif!=""){
			if ($avt_mdp_modif == $pass){
				if ($mdp_modif == $confirm_mdp_modif) {
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru UNSET pass=ENCRYPT($mdp_modif, 'ashrihgbjnbfj') WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			// Suivant si la modification a ?t? un succ?s ou pas, on affiche un autre message.						
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Mot de passe modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification du mot de passe.</p>" ;
			}
		}
		} }
		
	
		if ($id_statut == 2){ 
			$nomEnt_modif = stripslashes($_POST['nom_ent']);
			$webEnt_modif = stripslashes($_POST['web_ent']);
			$posteEnt_modif = stripslashes($_POST['poste_ent']);
			$mailEnt_modif = stripslashes($_POST['mail_ent']);
			$secteurEnt_modif = stripslashes($_POST['secteur_ent']);
			$codePostalEnt_modif = stripslashes($_POST['code_postal_ent']);
			$villeEnt_modif = stripslashes($_POST['ville_ent']);
			$paysEnt_modif = stripslashes($_POST['pays_ent']);
			$affichage_nomEnt_modif = stripslashes($_POST['affichage_nom_ent']);
			$affichage_webEnt_modif = stripslashes($_POST['affichage_web_ent']);
			$affichage_posteEnt_modif = stripslashes($_POST['affichage_poste_ent']);
			$affichage_mailEnt_modif = stripslashes($_POST['affichage_mail_ent']);
			$affichage_secteurEnt_modif = stripslashes($_POST['affichage_secteur_ent']);
			$affichage_codePostalEnt_modif = stripslashes($_POST['affichage_code_postal_ent']);
			$affichage_villeEnt_modif = stripslashes($_POST['affichage_ville_ent']);
			$affichage_paysEnt_modif = stripslashes($_POST['affichage_pays_ent']);
			
			
			if ($nomEnt_modif!="") {
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET nom_entreprise='$nomEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_nomEnt_modif == 1) {
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET nomEntreprise_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET nomEntreprise_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
					
			if ($webEnt_modif!="") {
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET siteweb_entreprise='$webEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_webEnt_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET sitewebEntreprise_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET sitewebEntreprise_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($secteurEnt_modif!="") {
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET secteur_entreprise='$secteurEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_secteurEnt_modif == 1) {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET secteurEntreprise_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET secteurEntreprise_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($posteEnt_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, poste AS p, poste_utilisateur AS pu SET nom_poste='$posteEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = pu.id_utilisateur AND p.id = pu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_posteEnt_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, poste AS p, poste_utilisateur AS pu SET nomPoste_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = pu.id_utilisateur AND p.id = pu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, poste AS p, poste_utilisateur AS pu SET nomPoste_niveau='prublic' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = pu.id_utilisateur AND p.id = pu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			
			if ($mailEnt_modif!=""){
					$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS, statut_ancien_etudiant AS sa ru SET mail_pro='$mailEnt_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
				
			if ($affichage_mailEnt_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur, statut_ancien_etudiant AS sa AS ru SET mailPro_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur, statut_ancien_etudiant AS sa AS ru SET mailPro_niveau ='public'WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($codePostalEnt_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp ='$codePostalEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_codePostalEnt_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($villeEnt_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nom_ville ='$villeEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_villeEnt_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomVille_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomVille_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($paysEnt_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nom_pays ='$paysEnt_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_paysEnt_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomPays_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu, entreprise_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomPays_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_entreprise AND e.id = ev.id_entreprise AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
		}
			
		if ($id_statut == 3){
			$diplome_modif = stripslashes($_POST['diplome']);
			$etab_modif = stripslashes($_POST['etab']);
			$webEtab_modif = stripslashes($_POST['web_etab']);
			$codePostalEtab_modif = stripslashes($_POST['code_postal_etab']);
			$villeEtab_modif = stripslashes($_POST['ville_etab']);
			$paysEtab_modif = stripslashes($_POST['pays_etab']);
			$affichage_diplome_modif = stripslashes($_POST['affichage_diplome']);
			$affichage_etab_modif = stripslashes($_POST['affichage_etab']);
			$affichage_webEtab_modif = stripslashes($_POST['affichage_web_etab']);
			$affichage_codePostalEtab_modif = stripslashes($_POST['affichage_code_postal_etab']);
			$affichage_villeEtab_modif = stripslashes($_POST['affichage_ville_etab']);
			$affichage_paysEtab_modif = stripslashes($_POST['affichage_pays_etab']);
		
			if ($diplome_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etudes AS e, etudes_utilisateur AS eu SET diplome_etudes='$diplome_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_diplome_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etudes AS e, etudes_utilisateur AS eu SET diplomeEtudes_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etudes AS e, etudes_utilisateur AS eu SET diplomeEtudes_niveau='prublic' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($etab_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET nom_etablissement='$etab_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}

			if ($affichage_etab_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET nomEtablissement_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET nomEtablissement_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
				
			if ($webEtab_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET siteweb_etablissement='$webEtab_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
	
			if ($affichage_webEtab_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET sitewebEtablissement_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET sitewebEtablissement_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($codePostalEtab_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp ='$codePostalEtab_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_codePostalEtab_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET cp_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($villeEtab_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nom_ville ='$villeEtab_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_villeEtab_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomVille_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomVille_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
			
			if ($paysEtab_modif!=""){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nom_pays ='$paysEtab_modif' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		
			if ($affichage_paysEtab_modif == 1){
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomPays_niveau ='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			} else {
				$res_modif = mysql_query("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu, etablissement_ville AS ev, ville AS v, pays AS p, ville_pays AS vp SET nomPays_niveau ='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur AND u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND e.id = ev.id_etablissement AND v.id = vp.id_ville AND p.id = vp.id_pays AND v.id = ev.id_ville AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
			}
		}
	}
	
	if ($id_role >= 2){
		$mail_modif = stripslashes($_POST['mail']);
		$nom_modif = stripslashes($_POST['nom']);
		$prenom_modif = stripslashes($_POST['prenom']);
		$naissance_modif = stripslashes($_POST['naissance']);
		$avt_mdp_modif = $_POST['avt_mdp'];
		$mdp_modif = $_POST['mdp'];
		$confirm_mdp_modif = $_POST['confirm_mdp'];
	
		if ($mail_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail='$mail_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Adresse Email modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification de l'adresse Email.</p>" ;
			}
		}
		
		if ($nom_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Nom modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification du nom.</p>" ;
			}
		}

		if ($prenom_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom='$prenom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Pr?nom modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification du pr?nom.</p>" ;
			}
		}
		
		if ($naissance_modif!=""){
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET naissance='$naissance_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Date de naissance modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification de la date de naissance.</p>" ;
			}
		}
		
		if ($mdp_modif!="" && $avt_mdp_modif!="" && $confirm_mdp_modif!=""){
			if ($avt_mdp_modif == $pass){
				if ($mdp_modif == $confirm_mdp_modif) {
			$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru UNSET pass=ENCRYPT($mdp_modif, 'ashrihgbjnbfj') WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
			// Suivant si la modification a ?t? un succ?s ou pas, on affiche un autre message.						
			if($res_modif <> False) {
					$message .= "<p class=\"succes\">Mot de passe modifi? dans la base de donn?es.</p>";
			} else {
					$message .= "<p class=\"erreur\">Erreur lors de la modification du mot de passe.</p>" ;
			}
		}
		} }
	
	
	
	
	}

}



################################################################################################


if(isset($_POST['changeStatut'])) {
	$radio_statut = $_POST['statutActuel'];
	$requete = "UPDATE statut_ancien_etudiant SET id_statut = $radio_statut WHERE statut_ancien_etudiant.id_utilisateur = $id_utilisateur";
	$resultat = mysql_query($requete);
	// Suivant si le changement de statut a ?t? un succ?s ou pas, on affiche un autre message.	
	if($resultat <> False) {
			$message .= "<p class=\"succes\">Statut modifi? dans la base de donn?es. Veuillez recharger la page pour voir la modification de votre profil.</p>";
	} else {
			$message .= "<p class=\"erreur\">Erreur lors de la modification du statut.</p>" ;
	}
}

if(connexionUtilisateurReussie()) {
	debuthtml("Annuaire M2 DEFI - Gestion de profil","Annuaire M2 DEFI", "Gestion du profil") ;
	echo $message ;
	if ($id_role == 1) {
		affichetitre("Profil Ancien ?tudiant :","3") ;
		echo "<p>Modifiez vos donn?es en les rempla?ant dans les champs appropri?s.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Donn?es personnelles :</legend>
					<p>
						<label for=\"nom\">Nom * : </label>
						<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
						<select name=\"affichage_nom\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"nomPatro\">Nom patronymique (nom au moment de votre obtention de dipl?me M2 DEFI) : </label>
						<input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" value=\"? modifier\" />
						<select name=\"affichage_nomPatro\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"prenom\">Pr?nom * : </label>
						<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
						<select name=\"affichage_prenom\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"naissance\">Date de naissance * : </label>
						<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
						</p>
					<p>
						<label for=\"mail\">Adresse E-Mail * : </label>
						<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
						<select name=\"affichage_mail\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"avt_mdp\">Mot de passe actuel * : </label>
						<input type=\"password\" name=\"avt_mdp\" id=\"avt_mdp\" value=\"\" />
						<label for=\"mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						<label for=\"confirm_mdp\">Confirmation du nouveau mot de passe * : </label>
						<input type=\"password\" name=\"confirm_mdp\" id=\"confirm_mdp\" value=\"\" />
					</p>
				</fieldset>
					";
					
		if ($id_statut == 2) {
			echo"
				<fieldset>
					<legend>Donn?es professionnelles :</legend>
					<p>
						<label for=\"nom_ent\">Nom de l'entreprise actuelle * : </label>
						<input type=\"text\" name=\"nom_ent\" id=\"nom_ent\" value=\"donn?e ? modifier\"/>
						<select name=\"affichage_nom_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"web_ent\">Adresse web de l'entreprise actuelle : </label>
						<input type=\"text\" name=\"web_ent\" id=\"web_ent\" value=\"donn?e ? modifier\"/>
						<select name=\"affichage_web_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"poste_ent\">Votre poste dans l'entreprise * : </label>
						<input type=\"text\" id=\"poste_ent\" name=\"poste_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_poste_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"mail_ent\">Adresse E-Mail professionnelle : </label>
						<input type=\"text\" id=\"mail_ent\" name=\"mail_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_mail_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"secteur_ent\">Secteur d'activit? de l'entreprise : </label>
						<input type=\"text\" id=\"secteur_ent\" name=\"secteur_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_secteur_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"ville_ent\">Ville * : </label>
						<input type=\"text\" id=\"ville_ent\" name=\"ville_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_ville_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>											
					<p>
						<label for=\"code_postal_ent\">Code Postal * : </label>
						<input type=\"text\" id=\"code_postal_ent\" name=\"code_postal_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_code_postal_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>					
					<p>
						<label for=\"pays_ent\">Pays *: </label>
						<input type=\"text\" id=\"pays_ent\" name=\"pays_ent\" value=\"donn?e ? modifier\" />
						<select name=\"affichage_pays_ent\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
				</fieldset>
				";
		} else if ($id_statut == 3) {
			echo"
				<fieldset>
					<legend>Formation :</legend>
					<p>
						<label for=\"diplome\">Dipl?me pr?par? actuellement* : </label>
						<input type=\"text\" id=\"diplome\" name=\"diplome\" value=\"dipl?me ? modifier\" />
						<select name=\"affichage_diplome\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"etab\">?tablissement * : </label>
						<input type=\"text\" name=\"etab\" id=\"etab\" value=\"?tablissement ? modifier\" />
						<select name=\"affichage_etab\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"web_etab\">Adresse web de l'?tablissement actuel : </label>
							<input type=\"text\" name=\"web_etab\" id=\"web_etab\" value=\"donn?e ? modifier\"/>
							<select name=\"affichage_web_etab\">
								<option value=\"1\">Affichage priv?</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"ville_etab\">Ville * : </label>
							<input type=\"text\" id=\"ville_etab\" name=\"ville_etab\" value=\"donn?e ? modifier\" />
							<select name=\"affichage_ville_etab\">
								<option value=\"1\">Affichage priv?</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
					<p>
						<label for=\"code_postal_etab\">Code Postal * : </label>
						<input type=\"text\" id=\"code_postal_etab\" name=\"code_postal_etab\" value=\"code postal ? modifier\" />
						<select name=\"affichage_code_postal_etab\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>					
					<p>
						<label for=\"pays_etab\">Pays *: </label>
						<input type=\"text\" id=\"pays_etab\" name=\"pays_etab\" value=\"pays ? modifier\" />
						<select name=\"affichage_pays_etab\">
							<option value=\"1\">Affichage priv?</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
				</fieldset>
			";
		}
	} else if ($id_role == 2) {
		affichetitre("?tudiant actuel :","3") ;
		echo "<p>Modifiez vos donn?es en les rempla?ant dans les champs appropri?s.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Donn?es personnelles :</legend>
					<p>
						<label for=\"nom\">Nom * : </label>
						<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
					</p>
					<p>
						<label for=\"prenom\">Pr?nom * : </label>
						<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
					</p>
					<p>
						<label for=\"naissance\">Date de naissance * : </label>
						<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
					</p>
					<p>
						<label for=\"mail\">Adresse E-Mail * : </label>
						<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
					</p>
					<p>
						<label for=\"avt_mdp\">Mot de passe actuel * : </label>
						<input type=\"password\" name=\"avt_mdp\" id=\"avt_mdp\" value=\"\" />
						<label for=\"mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						<label for=\"confirm_mdp\">Confirmation du nouveau mot de passe * : </label>
						<input type=\"password\" name=\"confirm_mdp\" id=\"confirm_mdp\" value=\"\" />
					</p>
				</fieldset>
		";
	} else if ($id_role == 3) {
		affichetitre("Enseignant :","3") ;
		echo "<p>Modifiez vos donn?es en les rempla?ant dans les champs appropri?s.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Donn?es personnelles :</legend>
					<p>
						<label for=\"nom\">Nom * : </label>
						<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
					</p>
					<p>
						<label for=\"prenom\">Pr?nom * : </label>
						<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
					</p>
					<p>
						<label for=\"naissance\">Date de naissance * : </label>
						<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
					</p>
					<p>
						<label for=\"mail\">Adresse E-Mail * : </label>
						<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
					</p>
					<p>
						<label for=\"avt_mdp\">Ancien mot de passe * : </label>
						<input type=\"password\" name=\"avt_mdp\" id=\"avt_mdp\" value=\"\" />
						<label for=\"mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						<label for=\"confirm_mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"confirm_mdp\" id=\"confirm_mdp\" value=\"\" />
					</p>
				</fieldset>
				";
	} else if ($id_role == 4) {
		affichetitre("Administrateur :","3") ;
		echo "<p>Modifiez vos donn?es en les rempla?ant dans les champs appropri?s.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Donn?es personnelles :</legend>
					<p>
						<label for=\"nom\">Nom * : </label>
						<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
					</p>
					<p>
						<label for=\"prenom\">Pr?nom * : </label>
						<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
					</p>
					<p>
						<label for=\"naissance\">Date de naissance * : </label>
						<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
					</p>
					<p>
						<label for=\"mail\">Adresse E-Mail * : </label>
						<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
					</p>
					<p>
						<label for=\"avt_mdp\">Ancien mot de passe * : </label>
						<input type=\"password\" name=\"avt_mdp\" id=\"avt_mdp\" value=\"\" />
						<label for=\"mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						<label for=\"confirm_mdp\">Nouveau mot de passe * : </label>
						<input type=\"password\" name=\"confirm_mdp\" id=\"confirm_mdp\" value=\"\" />
					</p>
				</fieldset>
		";
	}
	echo "<p class=\"submit\">
				<input type=\"submit\" name=\"modifier\" value=\"Valider\" />
			</p>
		</form>";
		

	
	if ($id_role == 1) {
		echo "<form action=\"gestionProfil.php\" method=\"post\">
				<h2>Changement de ma situation</h2>
				<fieldset>
					<legend>Changer mon statut en : </legend>
					<p>
						<label for=\"statutActuel\">Profil ? remplir : </label>";
		if ($id_statut == 1) {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantARemplir\" checked=\"checked\" value=\"1\" />" ;
		}
		else {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantARemplir\" value=\"1\" />" ;
		}
		echo "</p>
				<p>
				<label for=\"statutActuel\">En poste : </label>";
		if ($id_statut == 2) {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantEmploi\" checked=\"checked\" value=\"2\" />" ;
		} else {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantEmploi\" value=\"2\" />" ;
		}
		echo "</p>
			<p>
			<label for=\"ancienEtudiantFormation\">En formation : </label>";
		if ($id_statut == 3) {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" checked=\"checked\" value=\"3\" />" ;
		} else {
			echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" value=\"3\" />" ;
		}
		echo "</p>
				<p>
				<label for=\"ancienEtudiantSansEmploi\">Sans emploi : </label>";
		if ($id_statut == 4) {
			echo "<input name=\"statutActuel\" type=\"radio\"  id=\"ancienEtudiantSansEmploi\" checked=\"checked\" value=\"4\" />" ;
		} else {
			echo "<input name=\"statutActuel\" type=\"radio\"  id=\"ancienEtudiantSansEmploi\" value=\"4\" />" ;
		}
		echo"
				</p>
			</fieldset>
			<p class=\"submit\">
				<input type=\"submit\" name=\"changeStatut\" value=\"Valider\" />
			</p>
		</form>";
	}
	echo "	
		<h2>Suppression de mon profil</h2>
		<form action=\"gestionProfil.php\" method=\"post\">
			<fieldset>
				<legend>Les donn?es seront perdues d?finitivement</legend>
				<p>
					<input type=\"submit\" name=\"Supprimer\" value=\"supprimer mon profil\" />
				</p>
			</fieldset>
		</form>
	</div>
	</body>
	</html>";


	if ($id_role ==1) {
	echo "
		<h2>Export de mon profil aux formats xml ou pdf</h2>
		<p>Export au format <a href=\"export_xml.php\">xml</a>.<br/>
		Export au format <a href=\"export_pdf.php\">pdf</a>.</p>";

	}

	
}
	afficheMenu($id_role);
	finhtml() ;

    
mysql_close() ;
