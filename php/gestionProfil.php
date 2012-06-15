<?php
require_once("fonctions.php") ;

//code pour decrypter le mot de passe qui a été crypté à l'inscription.


session_start() ;
$connexion = connexion() ;
$id_utilisateur = $_SESSION['id_utilisateur'];
$nom = $_SESSION['nom'];
$nomPatro = $_SESSION['nom_patronymique'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$mail = $_SESSION['mail'] ;
$annee_promo = $_SESSION['annee_promo'];
$id_role = $_SESSION['id_role'];
$id_statut = $_SESSION['id_statut'];
$role = $_SESSION['nom_role'] ;
$statut = $_SESSION['nom_statut'] ; 
$date_inscription = $_SESSION['date_inscription'] ;
$date_maj_profil = $_SESSION['date_maj_profil'] ;
$mail_pro = $_SESSION['mail_pro'];
$message = "";

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
    
    // Suivant si la suppression a été un succès ou pas, on affiche un autre message.                       
    if($resultat) {
            $message .= "<p class=\"succes\">Profil supprimé de la base de données.</p>";
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
        ## l'option d'affichage est indépendante.
        if ($affichage_mail_modif == 1){
                $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        } else {
            $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='public'WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        }
        
        if ($nom_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        }

        if ($affichage_nom_modif == 1){
                $res_affich_modif = mysql_query ("UPDATE utilisateur  AS u, roles_utilisateur AS ru SET nom_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        } else {
            $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        }
        
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
        }
        
        if ($mdp_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET pass=ENCRYPT($mdp_modif, 'ashrihgbjnbfj') WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
        }
    
        if ($id_statut == 2){ 
            
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
            AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $res_statut2 = mysql_query($req_statut2) ;
            $posteEnt = $ligne->nom_poste;
            $nomEnt = $ligne->nom_entreprise;
            $webEnt = $ligne->siteweb_entreprise;
            $secteurEnt = $ligne->secteur_entreprise;
            $villeEnt = $ligne->nom_ville;
            $codePostalEnt = $ligne->cp ;
            $paysEnt = $ligne->nom_pays;
            
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
            
            
            $req_diplome = "SELECT diplome_etudes FROM utilisateur AS u, etudes AS 
            e, etudes_utilisateur AS eu WHERE u.id = eu.id_utilisateur 
            AND e.id = eu.id_etudes AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement = "SELECT etab.id, nom_etablissement FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_web_etablissement = "SELECT siteweb_etablissement FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_ville = "SELECT v.id, v.nom_ville FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_cp = "SELECT cp FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_pays = "SELECT cp FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            
            
            $res_diplome = mysql_query($req_diplome) ;
            $ligne=mysql_fetch_object($res_diplome) ;
            $diplome = $ligne->diplome_etudes;
            
            
            $res_etablissement = mysql_query($req_etablissement) ;
            $ligne=mysql_fetch_object($res_etablissement) ;
            $etab = $ligne->nom_etablissement ;
            $id_etab = $ligne->id ;
            
            $res_web_etablissement = mysql_query($req_web_etablissement) ;
            $ligne=mysql_fetch_object($res_web_etablissement) ;
            $web_etab = $ligne->siteweb_etablissement ;
            
            $res_etablissement_ville = mysql_query($req_etablissement_ville) ;
            $ligne=mysql_fetch_object($res_etablissement_ville) ;
            $ville_etab = $ligne->nom_ville ;
            $id_ville = $ligne->id ;
            
            $res_etablissement_cp = mysql_query($req_etablissement_cp) ;
            $ligne=mysql_fetch_object($res_etablissement_cp) ;
            $code_postal_etab = $ligne->cp;
            
            $req_etablissement_pays = "SELECT nom_pays FROM ville AS v, pays, ville_pays AS vp WHERE vp.id_ville = v.id AND vp.id_pays = pays.id AND v.id = $id_ville";
            $res_etablissement_pays = mysql_query($req_etablissement_pays) ;
            $ligne=mysql_fetch_object($res_etablissement_pays) ;
            $pays_etab = $ligne->nom_pays;
                          

            
            if (mysql_num_rows($res_diplome) == 0) {
                $res_modif = mysql_query ("INSERT INTO 
                etudes (diplome_etudes, diplomeEtudes_niveau) VALUES 
                ('$diplome_modif', $affichage_diplome_modif)");
                $id_etudes = mysql_insert_id();
                $rel_etudes = mysql_query ("INSERT INTO 
                etudes_utilisateur (id_utilisateur, id_etudes) VALUES 
                ($id_utilisateur, $id_etudes)");
                
            } elseif ($diplome_modif != $diplome) {
                $res_modif = mysql_query ("UPDATE etudes, 
                etudes_utilisateur SET diplome_etudes = '$diplome_modif' WHERE etudes_utilisateur.id_utilisateur  = $id_utilisateur AND etudes.id = etudes_utilisateur.id_etudes");
                
            }

            if ($affichage_diplome_modif == 1){
                    $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etudes AS e, etudes_utilisateur AS eu SET diplomeEtudes_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            } else {
                $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etudes AS e, etudes_utilisateur AS eu SET diplomeEtudes_niveau='prublic' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_poste AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            }






            
            if (mysql_num_rows($res_etablissement) == 0) {
                $res_modif = mysql_query ("INSERT INTO etablissement (nom_etablissement, siteweb_etablissement, nomEtablissement_niveau, sitewebEtablissement_niveau) VALUES ( 'Universite Paris 1', NULL, 'prive', 'prive')");
                $id_etab = mysql_insert_id();
                $rel_etab = mysql_query ("INSERT INTO `annuaire_defi`.`etablissement_utilisateur` (id_utilisateur , id_etablissement) VALUES ($id_utilisateur,$id_etab)");
                
            } elseif ($etab_modif != $etab) {
                $res_modif = mysql_query ("UPDATE etablissement SET nom_etablissement = '$etab_modif' WHERE etablissement.id =$id_etab");
                
            }

            if ($affichage_etab_modif == 1){
                    $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET nomEtablissement_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            } else {
                $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, entreprise AS e, entreprise_utilisateur AS eu SET nomEtablissement_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            }
                
                
                
                
            if (mysql_num_rows($res_web_etablissement) == 0) {
                if (mysql_num_rows($res_etablissement) == 0) {
                    $res_modif = mysql_query ("INSERT INTO etablissement (nom_etablissement, siteweb_etablissement, nomEtablissement_niveau, sitewebEtablissement_niveau) VALUES ('', '$webEtab_modif', 'prive', 'prive');");
                    $id_etab = mysql_insert_id();
                    $rel_etab = mysql_query ("INSERT INTO `annuaire_defi`.`etablissement_utilisateur` (id_utilisateur , id_etablissement) VALUES ($id_utilisateur,$id_etab)");
                }
                
            } elseif ($webEtab_modif != $web_etab) {
                $res_modif = mysql_query ("UPDATE etablissement SET siteweb_etablissement = '$webEtab_modif' WHERE etablissement.id = $id_etab");
                
            }
                
                  
            if ($affichage_webEtab_modif == 1){
                    $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET sitewebEtablissement_niveau='prive' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            } else {
                $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru, statut_ancien_etudiant AS sa, etablissement AS e, etablissement_utilisateur AS eu SET sitewebEtablissement_niveau='public' WHERE u.id = ru.id_utilisateur AND u.id = sa.id_utilisateur u.id = eu.id_utilisateur AND e.id = eu.id_etablissement AND id_role = '$id_role' AND id_statut ='$id_statut' AND u.id = '$id_utilisateur'");
            }
            
            
            
            
            
            if (mysql_num_rows($res_etablissement_cp) == 0) {
                if (mysql_num_rows($req_etablissement_ville) == 0) {
                    $res_modif = mysql_query ("INSERT INTO ville (nom_ville, cp, nomVille_niveau, cp_niveau) VALUES ('', $codePostalEtab_modif, 'prive', 'prive')");
                    $id_ville = mysql_insert_id();
                    if (mysql_num_rows($res_etablissement) != 0) { 
                        $rel_ville = mysql_query ("INSERT INTO etablissement_ville (id_ville, id_etablissement) VALUES ($id_ville, $id_etab)");
                    }
                }
                
            } elseif ($codePostalEtab_modif != $code_postal_etab) {
                $res_modif = mysql_query ("UPDATE ville SET cp = $codePostalEtab_modif WHERE ville.id = $id_ville");
                if (mysql_num_rows($req_etablissement_ville) == 0) { 
                        $rel_ville = mysql_query ("INSERT INTO etablissement_ville (id_ville, id_etablissement) VALUES ($id_ville, $id_etab)");
                    }
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
            
            
            $req_diplome = "SELECT diplome_etudes FROM utilisateur AS u, etudes AS 
            e, etudes_utilisateur AS eu WHERE u.id = eu.id_utilisateur 
            AND e.id = eu.id_etudes AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement = "SELECT etab.id, nom_etablissement FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_web_etablissement = "SELECT siteweb_etablissement FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_ville = "SELECT v.id, v.nom_ville FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_cp = "SELECT cp FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            $req_etablissement_pays = "SELECT cp FROM utilisateur AS u, etablissement AS 
            etab, etablissement_utilisateur AS etabu, ville AS v, etablissement_ville AS etab_ville WHERE u.id = etabu.id_utilisateur 
            AND etab.id = etabu.id_etablissement AND v.id = etab_ville.id_etablissement AND etab.id = etab_ville.id_etablissement AND u.nom='$nom' AND u.prenom='$prenom'";
            
            
            
            $res_diplome = mysql_query($req_diplome) ;
            $ligne=mysql_fetch_object($res_diplome) ;
            $diplome = $ligne->diplome_etudes;
            
            
            
            
            $res_etablissement = mysql_query($req_etablissement) ;
            $ligne=mysql_fetch_object($res_etablissement) ;
            $etab = $ligne->nom_etablissement ;
            $id_etab = $ligne->id ;
            
            $res_web_etablissement = mysql_query($req_web_etablissement) ;
            $ligne=mysql_fetch_object($res_web_etablissement) ;
            $web_etab = $ligne->siteweb_etablissement ;
            
            $res_etablissement_ville = mysql_query($req_etablissement_ville) ;
            $ligne=mysql_fetch_object($res_etablissement_ville) ;
            $ville_etab = $ligne->nom_ville ;
            $id_ville = $ligne->id ;
            
            $res_etablissement_cp = mysql_query($req_etablissement_cp) ;
            $ligne=mysql_fetch_object($res_etablissement_cp) ;
            $code_postal_etab = $ligne->cp;
            
            $req_etablissement_pays = "SELECT nom_pays FROM ville AS v, pays, ville_pays AS vp WHERE vp.id_ville = v.id AND vp.id_pays = pays.id AND v.id = $id_ville";
            $res_etablissement_pays = mysql_query($req_etablissement_pays) ;
            $ligne=mysql_fetch_object($res_etablissement_pays) ;
            $pays_etab = $ligne->nom_pays;
        }
    }
    
    if ($id_role >= 2){
        $mail_modif = stripslashes($_POST['mail']);
        $nom_modif = stripslashes($_POST['nom']);
        $prenom_modif = stripslashes($_POST['prenom']);
        $naissance_modif = stripslashes($_POST['naissance']);
        $mdp_modif = $_POST['mdp'];
        
 
        if ($mail_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail='$mail_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
            if($res_modif) {
                    $message .= "<p class=\"succes\">Adresse Email modifié dans la base de données.</p>";
            } else {
                    $message .= "<p class=\"erreur\">Erreur lors de la modification de l'adresse Email.</p>" ;
            }
        }
        
        if ($nom_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
            if($res_modif) {
                    $message .= "<p class=\"succes\">Nom modifié dans la base de données.</p>";
            } else {
                    $message .= "<p class=\"erreur\">Erreur lors de la modification du nom.</p>" ;
            }
        }

        if ($prenom_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom='$prenom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
            if($res_modif) {
                    $message .= "<p class=\"succes\">Prénom modifié dans la base de données.</p>";
            } else {
                    $message .= "<p class=\"erreur\">Erreur lors de la modification du prénom.</p>" ;
            }
        }
        
        if ($naissance_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET naissance='$naissance_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
            if($res_modif) {
                    $message .= "<p class=\"succes\">Date de naissance modifié dans la base de données.</p>";
            } else {
                    $message .= "<p class=\"erreur\">Erreur lors de la modification de la date de naissance.</p>" ;
            }
        }
        
        if ($mdp_modif!=""){
            $res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET pass=ENCRYPT($mdp_modif, 'ashrihgbjnbfj') WHERE u.id = ru.id_utilisateur AND id_role = '$id_role' AND u.id = '$id_utilisateur'");
            // Suivant si la modification a été un succès ou pas, on affiche un autre message.                      
            if($res_modif) {
                    $message .= "<p class=\"succes\">Mot de passe modifié dans la base de données.</p>";
            } else {
                    $message .= "<p class=\"erreur\">Erreur lors de la modification du mot de passe.</p>" ;
            }
        }
    }

}



################################################################################################


if(isset($_POST['changeStatut'])) {
    $id_statut = $_SESSION['id_statut'] = $radio_statut = $_POST['statutActuel'];
    $requete = "UPDATE statut_ancien_etudiant SET id_statut = $radio_statut WHERE statut_ancien_etudiant.id_utilisateur = $id_utilisateur";
    $resultat = mysql_query($requete);
    // Suivant si le changement de statut a été un succès ou pas, on affiche un autre message.  
    if($resultat) {
            $message .= "<p class=\"succes\">Statut modifié dans la base de données.</p>";
    } else {
            $message .= "<p class=\"erreur\">Erreur lors de la modification du statut.</p>" ;
    }
}

//affichage d'une page d'accueil personnalisée selon le rôle
if(connexionUtilisateurReussie()) {
    debuthtml("Annuaire M2 DEFI - Gestion de profil","Annuaire M2 DEFI", "Gestion du profil") ;
    echo $message ;
    if ($id_role == 1) {
        affichetitre("Profil Ancien étudiant :","3") ;
        echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
        echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
                <fieldset>
                    <legend>Données personnelles :</legend>
                    <p>
                        <label for=\"nom\">Nom * : </label>
                        <input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
                        <select name=\"affichage_nom\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"nomPatro\">Nom patronymique (nom au moment de votre obtention de diplôme M2 DEFI) : </label>
                        <input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" value=\"$nomPatro\" />
                        <select name=\"affichage_nomPatro\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"prenom\">Prénom * : </label>
                        <input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
                        <select name=\"affichage_prenom\">
                            <option value=\"1\">Affichage privé</option>
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
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"mdp\">Nouveau mot de passe * : </label>
                        <input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
                    </p>
                </fieldset>
                    ";
                    
        if ($id_statut == 2) {
            
           echo"
                <fieldset>
                    <legend>Données professionnelles :</legend>
                    <p>
                        <label for=\"nom_ent\">Nom de l'entreprise actuelle * : </label>
                        <input type=\"text\" name=\"nom_ent\" id=\"nom_ent\" value=\"$nomEnt\"/>
                        <select name=\"affichage_nom_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"web_ent\">Adresse web de l'entreprise actuelle : </label>
                        <input type=\"text\" name=\"web_ent\" id=\"web_ent\" value=\"$webEnt\"/>
                        <select name=\"affichage_web_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"poste_ent\">Votre poste dans l'entreprise * : </label>
                        <input type=\"text\" id=\"poste_ent\" name=\"poste_ent\" value=\"$posteEnt\" />
                        <select name=\"affichage_poste_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"mail_ent\">Adresse E-Mail professionnelle : </label>
                        <input type=\"text\" id=\"mail_ent\" name=\"mail_ent\" value=\"$mail_pro\" />
                        <select name=\"affichage_mail_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"secteur_ent\">Secteur d'activité de l'entreprise : </label>
                        <input type=\"text\" id=\"secteur_ent\" name=\"secteur_ent\" value=\"$secteurEnt\" />
                        <select name=\"affichage_secteur_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"ville_ent\">Ville * : </label>
                        <input type=\"text\" id=\"ville_ent\" name=\"ville_ent\" value=\"$villeEnt\" />
                        <select name=\"affichage_ville_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>                                            
                    <p>
                        <label for=\"code_postal_ent\">Code Postal * : </label>
                        <input type=\"text\" id=\"code_postal_ent\" name=\"code_postal_ent\" value=\"$codePostalEnt\" />
                        <select name=\"affichage_code_postal_ent\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>                    
                    <p>
                        <label for=\"pays_ent\">Pays *: </label>
                        <input type=\"text\" id=\"pays_ent\" name=\"pays_ent\" value=\"$paysEnt\" />
                        <select name=\"affichage_pays_ent\">
                            <option value=\"1\">Affichage privé</option>
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
                        <label for=\"diplome\">Diplôme préparé actuellement* : </label>
                        <input type=\"text\" id=\"diplome\" name=\"diplome\" value=\"$diplome\" />
                        <select name=\"affichage_diplome\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"etab\">Établissement * : </label>
                        <input type=\"text\" name=\"etab\" id=\"etab\" value=\"$etab\" />
                        <select name=\"affichage_etab\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                    <p>
                        <label for=\"web_etab\">Adresse web de l'établissement actuel : </label>
                            <input type=\"text\" name=\"web_etab\" id=\"web_etab\" value=\"$web_etab\"/>
                            <select name=\"affichage_web_etab\">
                                <option value=\"1\">Affichage privé</option>
                                <option value=\"2\">Affichage public</option>
                            </select>
                        </p>
                        <p>
                            <label for=\"ville_etab\">Ville * : </label>
                            <input type=\"text\" id=\"ville_etab\" name=\"ville_etab\" value=\"$ville_etab\" />
                            <select name=\"affichage_ville_etab\">
                                <option value=\"1\">Affichage privé</option>
                                <option value=\"2\">Affichage public</option>
                            </select>
                        </p>
                    <p>
                        <label for=\"code_postal_etab\">Code Postal * : </label>
                        <input type=\"text\" id=\"code_postal_etab\" name=\"code_postal_etab\" value=\"$code_postal_etab\" />
                        <select name=\"affichage_code_postal_etab\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>                    
                    <p>
                        <label for=\"pays_etab\">Pays *: </label>
                        <input type=\"text\" id=\"pays_etab\" name=\"pays_etab\" value=\"$pays_etab\" />
                        <select name=\"affichage_pays_etab\">
                            <option value=\"1\">Affichage privé</option>
                            <option value=\"2\">Affichage public</option>
                        </select>
                    </p>
                </fieldset>
            ";
        }
    } else if ($id_role == 2) {
        affichetitre("Étudiant actuel :","3") ;
        echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
        echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
                <fieldset>
                    <legend>Données personnelles :</legend>
                    <p>
                        <label for=\"nom\">Nom * : </label>
                        <input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
                    </p>
                    <p>
                        <label for=\"prenom\">Prénom * : </label>
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
                        <label for=\"mdp\">Nouveau mot de passe * : </label>
                        <input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
                    </p>
                </fieldset>
        ";
    } else if ($id_role == 3) {
        affichetitre("Enseignant :","3") ;
        echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
        echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
                <fieldset>
                    <legend>Données personnelles :</legend>
                    <p>
                        <label for=\"nom\">Nom * : </label>
                        <input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
                    </p>
                    <p>
                        <label for=\"prenom\">Prénom * : </label>
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
                        <label for=\"mdp\">Nouveau mot de passe * : </label>
                        <input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
                    </p>
                </fieldset>
                ";
    } else if ($id_role == 4) {
        affichetitre("Administrateur :","3") ;
        echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
        echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
                <fieldset>
                    <legend>Données personnelles :</legend>
                    <p>
                        <label for=\"nom\">Nom * : </label>
                        <input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
                    </p>
                    <p>
                        <label for=\"prenom\">Prénom * : </label>
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
                        <label for=\"mdp\">Nouveau mot de passe * : </label>
                        <input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
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
                        <label for=\"statutActuel\">Profil à remplir : </label>";
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
                <legend>Les données seront perdues définitivement</legend>
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

    afficheMenu($id_role);
    finhtml() ;
}
else {
    echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
    echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
    }
    
mysql_close() ;
