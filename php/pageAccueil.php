<?php
require("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$pass = $_POST['mdp'] ;

$connexion = connexion() ;




		$champs_vides = array() ;
		$mauvais_format = array() ;
														
		#on teste la valeur des variables transmises par le formulaire
		if($_SESSION['nom'] == "") {
			$champs_vides[] = "Nom" ;
		} else {
			if(preg_match('/[^A-Za-z \'-]/', $_SESSION['nom'])) {
				$mauvais_format[] = "Nom" ;
			}
		}
		if($_SESSION['prenom'] == "") {
			$champs_vides[] = "Prénom" ;
		} else {
			if(preg_match('/[^A-Za-z \'-]/', $_SESSION['prenom'])) {
				$mauvais_format[] = "Prénom" ;
			}
		}
			if($_SESSION['naissance'] == "") {
			$champs_vides[] = "Date de naissance" ;
		} else {
			if(!preg_match('/[^A-Za-z \'-]/', $naissance)) {
				$mauvais_format[] = "Date de naissance" ;
			}
		}
		
		#si les tableaux $champs_vides et $mauvais_format sont vides on affiche un message de bienvenue
		if(count($champs_vides) > 0 || count($mauvais_format) > 0 ) {
			#test des champs vides
			if(count($champs_vides) == 0 ) {
				$message = "" ; 
			} else {
				$n = count($champs_vides) ;
				if($n > 1) {
					$message = "<p class=\"erreur\">Vous devez remplir les champs : " ; 
				} else {
					$message = "<p class=\"erreur\">Vous devez remplir le champ " ;
				}
				for($i=0; $i<$n; $i++) {
					$champ = $champs_vides[$i] ; 
					if($i == 0) {
						$message .= "$champ</p>" ;
					} elseif($i == $n-1) {
						$message .= " et $champ</p>" ; 
					} else {
						$message .= ",  $champ</p>" ;
					}
				}
			}

			#test des champs mal remplis
			if(count($mauvais_format) == 0 ) {
				$fin_message = "" ; 
			} else {
				$n = count($mauvais_format);
				if($n > 1) {
					$message .= "<p class=\"erreur\">Les champs " ;
					$fin_message = " n'ont pas été saisis correctement.</p>" ;
				} else {
					$message .= "<p class=\"erreur\">Le champ " ;
					$fin_message = " n'a pas été saisi correctement.</p>" ;
				}
				for($i=0; $i<$n; $i++){
					$champ = $mauvais_format[$i] ; 
					if($i == 0) {
						$message .= "$champ" ;
					} elseif($i == $n-1) {
						$message .= " et $champ" ;
					} else {
						$message .= ",  $champ" ;
					}
				}
			}
			$message .= $fin_message ;
		}
	}

$req = "select * from utilisateur where nom='$nom' AND prenom='$prenom' AND naisance='$naissance' AND pass='$pass'" ;
$res = mysql_query($req) ;

$ligne=mysql_fetch_object($res) ;
	$id = $ligne->id ;
	$nom = $ligne->nom ;
	$prenom = $ligne->prenom ;


$req_b = "select role,id_role,u.id from role AS r,role_utilisateur AS ru, utilisateur AS u where r.id=ru.id_role and u.id=ru.id_utilisateur and id_utilisateur='$id'" ; 

$res_b = mysql_query($req_b) ;
$ligne=mysql_fetch_object($res_b) ;
	$id_utilisateur = $ligne->id_utilisateur;
	$id_role = $ligne->id_role;
	$role = $ligne->role;

$req_c = "select statut,id_statut, u.id from statut AS s, statut_utilisateur AS su, utilisateur AS u where s.id=su.id_statut and u.id=su.id_utilisateur and id_utilisateur='$id'" ;

if(mysql_num_rows($res) > 0)
	{
	session_start() ;
	$ligne=mysql_fetch_object($res) ;
	$_SESSION['nom'] = $ligne->nom ;
	$_SESSION['prenom'] = $ligne->prenom ; 

	$prenom = ucfirst(strtolower($_SESSION['prenom']));
	$nom = ucfirst(strtolower($_SESSION['nom']));

	debutpagehtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
	
			
		if ($id_role = 1)
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
			}
		if ($id_role = 2)
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
			<p><a href=\"mapromo.html\">Ma promo</a></p>
			<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
			<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
			<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($id_role = 3)
		{
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
		<p><a href=\"administration.html\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}
		if ($id_role = 4)
		{ 
		echo "
		<p><a href=\"accueil.html\"Accueil</a></p>
		<p><a href=\"monprofil.html\"Mon profil</a></p> 
		<p><a href=\"recherche.php\">Recherche dans l'annuaire</a></p>
		<p><a href=\"Gestiondeprofil.html\">Gestion de mon profil</a></p>
		<p><a href=\"administration.html\">Administration</a></p>
		<p><a href=\"deconnexion.php\">Déconnexion</a></p>";
		}

	endpagehtml() ;
	echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
	
	}
  
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	}
	if (isset($message)) {
		echo $message;
		echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
?>
