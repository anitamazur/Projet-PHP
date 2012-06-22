<?php
require("fonctions.php") ;
$connexion = connexion() ;

session_start() ;

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
#$salt = "ashrihgbjnbfj";
#$pass = crypt($_SESSION['pass'], $salt);
#$mail = $_SESSION['mail'] ;
#$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
#$id_role = $_SESSION['id_role'] = role($id_utilisateur);
#$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);

//Requete SQL
$query = "SELECT * 
    FROM utilisateur AS u, role AS r, roles_utilisateur AS ru 
    WHERE u.id = ru.id_utilisateur
    AND r.id = ru.id_role
    AND ru.id_role = 1
    AND u.annee_promo !=0000";
        
$result = mysql_query($query) or die(mysql_error());
 
// Entêtes des colones dans le fichier Excel
$excel="";
$excel .="nom \t prenom \t année_promo \t adresse mail \t rôle \t statut \t situation actuelle \n";
 
//Les resultats de la requette
while($row = mysql_fetch_array($result)) {
        $profil_id_role = $row['id_role'];
        $profil_nom = $row['nom'];
        $profil_prenom = $row['prenom'];
    
        $excel .= "$row[nom] \t $row[prenom] \t $row[annee_promo] \t $row[mail] \t $row[nom_role] \t";
    
    if ($profil_id_role == 1)
    {
$res = mysql_query("SELECT * 
            FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
            WHERE u.id = ru.id_utilisateur
            AND u.id = sa.id_utilisateur
            AND r.id = ru.id_role
            AND s.id = sa.id_statut
            AND ru.id_role = '$profil_id_role' AND u.nom = '$profil_nom' AND u.prenom = '$profil_prenom' ");
            
            if(mysql_num_rows($res) > 0)
                                    {
            $row=mysql_fetch_array($res) ;
            
            #while($row = mysql_fetch_array($res)) {
            
                $profil_id_statut = $row['id_statut'];
            
            $excel .= "$row[nom_statut] \t";
            
                if ($profil_id_statut == 2)
                {
                
                
                $res_statut2=mysql_query("SELECT *
                FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
                WHERE u.id = pu.id_utilisateur
                AND u.id = eu.id_utilisateur
                AND u.id = sa.id_utilisateur
                AND u.id = ru.id_utilisateur
                AND r.id = ru.id_role
                AND s.id = sa.id_statut
                AND p.id = pu.id_poste
                AND p.id = pde.id_poste
                AND e.id = eu.id_entreprise
                AND e.id = pde.id_entreprise
                AND e.id = ev.id_entreprise
                AND vi.id = ev.id_entreprise
                AND vi.id = vp.id_ville
                AND sa.id_statut = '$profil_id_statut' AND ru.id_role = '$profil_id_role'
                AND u.nom = '$profil_nom' AND u.prenom = '$profil_prenom'");
                    
                    
                    if(mysql_num_rows($res_statut2) > 0)
                                    {
                    $row=mysql_fetch_array($res_statut2) ;
                    
                #   while ($row = mysql_fetch_array($res_statut2)){
                
                    $excel .= "$row[nom_poste] \t $row[nom_entreprise] \t $row[siteweb_entreprise] \t $row[secteur_entreprise] \t $row[nom_ville] $row[cp] $row[nom_pays] \n";
                            
                        }
                else {$excel .= "-\n";}
            
            
            }
            
            elseif ($profil_id_statut == 3) 
                    {       
                        $res_statut3 =mysql_query( "SELECT * 
            FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
            WHERE u.id = eu.id_utilisateur
            AND u.id = sa.id_utilisateur
            AND u.id = ru.id_utilisateur
            AND r.id = ru.id_role
            AND s.id = sa.id_statut
            AND u.id = etau.id_utilisateur
            AND e.id = eu.id_etudes
            AND eta.id = etau.id_etablissement
            AND eta.id = etav.id_etablissement
            AND v.id = vp.id_ville
            AND v.id = etav.id_ville
            AND p.id = vp.id_pays
            AND sa.id_statut = '$profil_id_statut' AND ru.id_role = '$profil_id_role'
            AND u.nom = '$profil_nom' AND u.prenom = '$profil_prenom' " );
                        
                        if(mysql_num_rows($res_statut3) > 0)
                                    {
                            $row=mysql_fetch_array($res_statut3) ;
                            
                    #while ($row = mysql_fetch_array($res_statut3)){
                        $excel .= "$row[diplome] \t $row[nom_etablissement] \t $row[siteweb_etablissement] \t $row[nom_ville] $row[cp] $row[nom_pays] \n";
                            
                            }
            else {$excel .= " -\n";}                
                            
                            }
            else
            {$excel .= "-\n";}
            
            
            }

}

 }
 
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=les_profils.xls");
print $excel;
exit;
?>