<?php
ob_end_clean();
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
    #$this->Image('logo.png',10,6,30);
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
 
$serveurBD = "localhost"; 
    $nomUtilisateur = "root"; 
    $motDePasse = "123456"; 
    $baseDeDonnees = "annuaire_defi"; 
 
    $idConnexion = mysql_connect($serveurBD,
                                 $nomUtilisateur,
                                 $motDePasse);
 
    #if ($idConnexion !== FALSE) echo "Connexion au serveur reussie<br/>";
    #else echo "Echec de connexion au serveur<br/>";
 
    $connexionBase = mysql_select_db($baseDeDonnees);
 
$resultat=mysql_query ("SELECT *
FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa
WHERE u.id = ru.id_utilisateur
AND u.id = sa.id_utilisateur
AND r.id = ru.id_role
AND s.id = sa.id_statut
");
 
 #AND u.nom='$nom' AND u.prenom='$prenom'
 
 
// Instanciation de la classe dérivée
 
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
 
while($row=mysql_fetch_assoc($resultat))
{
 
$pdf->cell(0,10,$row["nom"],0,1);
$pdf->cell(0,10,$row["prenom"],0,1);
$pdf->cell(0,10,$row["annee_promo"],0,1);
$pdf->cell(0,10,$row["nom_role"],0,1);
}
 
 
$pdf->Output();
?>