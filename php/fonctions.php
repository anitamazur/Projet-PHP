<?php 
function connexion()
	{
    $serveurBD = "localhost"; # ࡭odifier pour le serveur de la fac
    $nomUtilisateur = "root"; # ࡭odifier pour le serveur de la fac
    $motDePasse = ""; # ࡭odifier pour le serveur de la fac
    $baseDeDonnees = "essai_annuaire"; # BDD de test / Si BDD ok : changer par "annuaire_defi"
   
    $idConnexion = mysql_connect($serveurBD,
                                 $nomUtilisateur,
                                 $motDePasse);
                                 
    #if ($idConnexion !== FALSE) echo "Connexion au serveur reussie<br/>";
    #else echo "Echec de connexion au serveur<br/>";

    $connexionBase = mysql_select_db($baseDeDonnees);
    #if ($connexionBase) echo "Connexion a la base reussie";
    #else echo "Echec de connexion a la base"; 
	} 
	
function debuthtml($titre_head,$titre_header,$titre_contenu)
	{
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
		<title>$titre_head</title>
		<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"defi.css\" />
	</head>
	<body>
		<div id=\"header\">
			<h1>$titre_header</h1>
		</div>
		<div id=\"contenu\">
		<h2>$titre_contenu</h2>";
	}	

function finhtml()
	{
	echo "</div>
	<div>Projet de fin d'études des étudiants M2 DEFI</div>
	</body>
	</html>
	";
	}
	
function affichetitre($titre, $n)
	{
	echo "<h$n>$titre</h$n>\n" ; 
	} 
?>