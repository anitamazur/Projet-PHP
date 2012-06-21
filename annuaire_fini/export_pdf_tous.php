<?php

require('fpdf.php');
session_start() ;
 
#$nom = $_SESSION['nom'];
#$prenom = $_SESSION['prenom'];
 
 
class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('upx.png',10,6,30);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(30,10,'Mon profil',1,0,'C');
    // Saut de ligne
    $this->Ln(20);
}
 
// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
 
}
}
 
    $serveurBD = "localhost"; # mdifier pour le serveur de la fac
    $nomUtilisateur = "defi_annuaire"; # modifier pour le serveur de la fac
    $motDePasse = "annuaire2defi"; # modifier pour le serveur de la fac
    $baseDeDonnees = "defi_annuaire"; # BDD de test / Si BDD ok : changer par "annuaire_defi" 
 
    $idConnexion = mysql_connect($serveurBD,
                                 $nomUtilisateur,
                                 $motDePasse);
 
    #if ($idConnexion !== FALSE) echo "Connexion au serveur reussie<br/>";
    #else echo "Echec de connexion au serveur<br/>";
 
    $connexionBase = mysql_select_db($baseDeDonnees);
 
$resultat=mysql_query ("SELECT *
FROM utilisateur AS u, role AS r, roles_utilisateur AS ru
WHERE u.id = ru.id_utilisateur
AND r.id = ru.id_role 
AND ru.id_role = 1
AND u.nom!='mazur' AND u.nom!='admin' AND u.prenom !='anita' AND u.prenom !='admin'");
 
## mise en place de la condition "AND u.nom!='mazur' AND u.nom!='admin' AND u.prenom !='anita' AND u.prenom !='admin'" pour ne pas fausser les résultats 

// Instanciation de la classe dérivée
 
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
 
while($row=mysql_fetch_assoc($resultat))
{
 
 $pdf->cell(0,10,'UTILISATEUR :',0,1);
$pdf->cell(0,10,$row["nom"],0,1);
$pdf->cell(0,10,$row["prenom"],0,1);
$pdf->cell(0,10,$row["annee_promo"],0,1);
$pdf->cell(0,10,$row["nom_role"],0,1);

if ($row["id_role"]== 1)
 {$res = mysql_query("SELECT * 
                                    FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
                                        WHERE u.id = ru.id_utilisateur
                                        AND u.id = sa.id_utilisateur
                                        AND r.id = ru.id_role
                                        AND s.id = sa.id_statut
                                        AND ru.id_role = '$row[id_role]' AND u.nom = '$row[nom]' AND u.prenom = '$row[prenom]'");
                        
                        while ($row = mysql_fetch_assoc($res)) 
                        {
    
        ## en poste ##
        
                    if ($row["id_statut"]== 2)
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
                            AND sa.statut = '$row[id_statut]' AND ru.id_role = '$row[id_role]' AND u.nom = '$row[nom]' AND u.prenom = '$row[prenom]' ";
                    
                    $res_statut2 = mysql_query($req_statut2) ;
                    
                 
							
                   while($row=mysql_fetch_assoc($res_statut2))
                                {
                                 
                        $pdf->cell(0,10,$row["nom_poste"],0,1);
                        $pdf->cell(0,10,$row["nom_entreprise "],0,1);
                        $pdf->cell(0,10,$row["siteweb_entreprise"],0,1);
                        $pdf->cell(0,10,$row["secteur_entreprise"],0,1);
                        $pdf->cell(0,10,$row["nom_ville"],0,1);
                        $pdf->cell(0,10,$row["cp"],0,1);
                        $pdf->cell(0,10,$row["nom_pays"],0,1);
                    
                    
                        
                        }
                    
                    } 
                    
        ## en formation ##
        
                elseif ($row["id_statut"] == 3) 
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
                        AND sa.id_statut = '$row[id_statut]' AND ru.id_role = '$row[id_role]' AND u.nom = '$row[nom]' AND u.prenom = '$row[prenom]'" ;
                        
                $res_statut3 = mysql_query($req_statut3) ;
            
			
                   while($row=mysql_fetch_assoc($res_statut3))
                               {
                                 
                        $pdf->cell(0,10,$row["diplome_etudes"],0,1);
                        $pdf->cell(0,10,$row["nom_etablissement "],0,1);
                        $pdf->cell(0,10,$row["siteweb_etablissement"],0,1);
                        $pdf->cell(0,10,$row["nom_ville"],0,1);
                        $pdf->cell(0,10,$row["cp"],0,1);
                        $pdf->cell(0,10,$row["nom_pays"],0,1);
                        
                
                    
                    }


                }
 }} }
 
$pdf->Output();
?>