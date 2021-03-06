<?php
function connexion()
{
    $serveurBD = "localhost"; # mdifier pour le serveur de la fac
    $nomUtilisateur = "root"; # modifier pour le serveur de la fac
    $motDePasse = "123456"; # modifier pour le serveur de la fac
    $baseDeDonnees = "defi_annuaire"; # BDD de test / Si BDD ok : changer par "annuaire_defi"
   
    $idConnexion = mysql_connect($serveurBD,
                                 $nomUtilisateur,
                                 $motDePasse);
                                 
#    if ($idConnexion) {
# echo "Connexion au serveur reussie<br/>";
#} else {
# echo "Echec de connexion au serveur<br/>";
#}

    $connexionBase = mysql_select_db($baseDeDonnees);
    mysql_query("SET NAMES UTF8");
#    if ($connexionBase) {
#        echo "Connexion a la base reussie";
#    } else {
#        echo "Echec de connexion a la base";
#    }
}

//fonction qui affiche plusieurs types de menus selon son rôle
function afficheMenu($role) {
    echo "<div id=\"menu\">";
    echo "<h2 class=\"menu_title\">Menu</h2>";
    echo "<ul id=\"menu_liens\">";
    if(connexionUtilisateurReussie()) {
        if($role == 1) {
            echo "<li><a href=\"monprofil.php\">Mon profil</a></li>";
            echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
            echo "<li><a href=\"mapromo.php\">Ma promo</a></li>";
            echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
            echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
        }
        elseif($role == 2) {
            echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
            echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
            echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
        }
        elseif($role >= 3) {
            echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
            echo "<li><a href=\"administration.php\">Administration</a></li>";
            echo "<li><a href=\"lespromos.php\">Les promos</a></li>";
            echo "<li><a href=\"recherche.php\">Recherche dans l'annuaire</a></li>";
            echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
        }
    } else {
        echo "<li><a href=\"connexion.php\">Connexion</a></li>";
        echo "<li><a href=\"recherche.php\">Recherche</a></li>";
    }
    echo "</ul>";
    echo "</div>";
}

function debuthtml($titre_head,$titre_header,$titre_contenu, $role)
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
</div>";
afficheMenu($role);
echo "<div id=\"contenu\">
<h2>$titre_contenu</h2>";
}   

function finhtml()
{
echo "</div>
<div id=\"footer\">Projet de fin d'études des étudiants M2 DEFI</div>
</body>
</html>
";
}

function affichetitre($titre, $n)
{
echo "<h$n>$titre</h$n>\n" ;
}

//fonction permettant de vérifier si l'utilisateur est bien connecté. Si la requête SQL avec le nom, prenom et mot de passe retourne quelque chose, alors l'utlisateur a donnée les bons identifiants.
function connexionUtilisateurReussie() {
    if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['pass']) && isset($_SESSION['mail'])) {
        $req = "SELECT id FROM utilisateur WHERE mail='".$_SESSION['mail']."' AND nom='".$_SESSION['nom']."' AND prenom='".$_SESSION['prenom']."' AND pass='".$_SESSION['pass']."'" ;
        $res = mysql_query($req) ; 
        if ($res) {
            if(mysql_num_rows($res) > 0) {
                return True;
            } else {
                return False;
            }
        } else {
            return False;
        }
    } else {
        return False;
    }
}

//fonction qui permet de l'id d'un utilisateur connecté
function getID($nom, $prenom, $mail) {
    $mail = mysql_real_escape_string($mail);
    $req = "SELECT id from utilisateur where nom='$nom' AND prenom='$prenom' AND mail='$mail' " ;
    $res = mysql_query($req) ;
    if(mysql_num_rows($res) > 0) {
        $ligne = mysql_fetch_object($res) ;
        $id_utilisateur = $ligne->id;
        return $id_utilisateur ;
    } else {
        return False;
    }
}

// fonction permettant de connaître l'id du rôle de l'utilisateur connecté
function role($id_utilisateur) {
    $requete = "SELECT id_role FROM roles_utilisateur WHERE id_utilisateur = ".$id_utilisateur ;
    $res = mysql_query($requete) ;
    $ligne = mysql_fetch_object($res) ;
    $role = $ligne->id_role;
return $role ;
}

// fonction permettant de connaître le statut d'un ancien étudiant connecté
function statut($id_utilisateur) {
    if (role($id_utilisateur) == 1) {
        $requete = "SELECT id_statut FROM statut_ancien_etudiant WHERE id_utilisateur = ".$id_utilisateur ;
        $res = mysql_query($requete) ;
        $ligne = mysql_fetch_object($res) ;
        $statut = $ligne->id_statut;
        return $statut ;
}
}




function menuderoulant($nom, $tab)
{
echo "<select name=\"$nom\">\n" ;
echo "<option value=\"$indice\" selected>nom_prénom_n° rôle</option>";
foreach($tab as $cle=>$val)
{
echo "<option value=\"$cle\">$val </option>\n" ;
}
echo "</select>\n" ;
}


//fonction qui permet de vérifier la syntaxe d'une adresse E-Mail
function VerifierAdresseMail($adresse) {
$Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
if(preg_match($Syntaxe,$adresse)) {
return true;
} else {
return false;
}
}
