<?php
	
session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;
$naissance = $_SESSION['naissance'] ;
	
require('fpdf.php');
require ('fonctions.php');
	
$pdf=new FPDF('P','cm','A4');
    
//Titres des colonnes
$header=array('Nom','Prenom','Année_Promo','Role');
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();
$pdf->SetFillColor(96,96,96);
$pdf->SetTextColor(255,255,255);

$connexion=connexion();
    
$query="SELECT *
FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa
WHERE u.id = ru.id_utilisateur
AND u.id = sa.id_utilisateur
AND r.id = ru.id_role
AND s.id = sa.id_statut
AND u.nom='$nom' AND u.prenom='$prenom'";
$resultat=mysql_query($query);

$pdf->SetXY(4,4);
for($i=0;$i<sizeof($header);$i++)
$pdf->cell(5,1,$header[$i],1,0,'C',1);
$pdf->SetFillColor(0xdd,0xdd,0xdd);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetXY(4,$pdf->GetY()+1);
$fond=0;

while($row=mysql_fetch_array($resultat))
{$pdf->cell(5,0.7,$row['u.nom'],1,0,'C',$fond);
$pdf->cell(5,0.7,$row['u.prenom'],1,0,'C',$fond);
$pdf->cell(5,0.7,$row['u.annee_promo'],1,0,'C',$fond);
$pdf->cell(5,0.7,$row['u.role'],1,0,'C',$fond);
$pdf->SetXY(4,$pdf->GetY()+0.7);
$fond=!$fond;
 }
$pdf->output();

    ?>