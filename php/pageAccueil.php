<?php
require_once("fonctions.php") ;

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'] ;
$naissance = $_POST['naissance'] ;
$mail = $_POST['mail'] ;
//code pour decrypter le mot de passe qui a été crypté à l'inscription.
$salt = "ashrihgbjnbfj";
$pass = crypt($_POST['mdp'], $salt);

session_start() ;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;
$_SESSION['naissance'] = $naissance;
$_SESSION['pass'] = $pass;
$_SESSION['mail'] = $mail;

$connexion = connexion() ; 

//affichage d'une page d'accueil personnalisée selon le rôle
if(connexionUtilisateurReussie()) {
    debuthtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Accueil") ;
    affichetitre("Vos informations personnelles :","3") ;
    $id_utilisateur = getID($nom, $prenom, $mail);
    $id_role = role($id_utilisateur);
    $id_statut = statut($id_utilisateur);
    if ($id_role == 1) {
        $req = "SELECT * 
            FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
            WHERE u.id = ru.id_utilisateur
            AND u.id = sa.id_utilisateur
            AND r.id = ru.id_role
            AND s.id = sa.id_statut
            AND u.nom='$nom' AND u.prenom='$prenom' AND u.naissance='$naissance'" ;
        $res = mysql_query($req) ;
        $ligne=mysql_fetch_object($res) ;
        $nom = $_SESSION['nom'] = ucfirst(strtolower($ligne->nom)) ;
        $nomPatro = $_SESSION['nom_patronymique'] = $ligne->nom_patronymique ;
        $prenom = $_SESSION['prenom'] = ucfirst(strtolower($ligne->prenom)) ;
        $id_role = $_SESSION['id_role'] = $ligne->id_role ;
        $id_statut = $_SESSION['id_statut'] = $ligne->id_statut ;
        $role = $_SESSION['nom_role'] = $ligne->nom_role ;
        $mail_pro = $_SESSION['mail_pro'] = $ligne->mail_pro ;
        $statut = $_SESSION['nom_statut'] = $ligne->nom_statut ; 
        $annee_promo = $_SESSION['annee_promo'] = $ligne->annee_promo ;
        $mail = $_SESSION['mail'] = $ligne->mail ;
        $date_inscription = $_SESSION['date_inscription'] = date($ligne->date_inscription) ;
        $date_inscription_plus_un_an = strtotime(date("Y-m-d", strtotime(date($ligne->date_inscription))) . " +12 month");
        $date_inscription_plus_un_an = date("Y-m-d",$date_inscription_plus_un_an);
        $date_maj_profil = $_SESSION['date_maj_profil'] = date($ligne->date_maj_profil) ;

        echo "<p>$nom $prenom</p>
        <p><strong>$role</strong> : $statut</p>
        <p><strong>Année de la promotion</strong> : $annee_promo</p>
        <p><strong>Adresse mail</strong> : $mail </p>
        <p><strong>Date d'inscription</strong> : $date_inscription </p>
        <p><strong>Date de mise à jour du profil</strong> : $date_maj_profil </p>
        <br/>"; 
        //Si l'utilisateur a le statut "profil à remplir" (id1) on affiche un message qu'il doit remplir son profil.
        if ($id_statut == 1) {
            echo "<p>Veuillez remplir votre profil en cliquant sur l'onglet <a href=\"gestionProfil.php\">Gestion de mon profil</a>.</p>";
        }
        //Calcul our savoir si les informations sont obsolètes ou non
        elseif (($id_statut != 1) && ($date_maj_profil > $date_inscription_plus_un_an)) {
            echo "<p>Veuillez mettre à jour votre profil en cliquant sur l'onglet <a href=\"gestionProfil.php\">Gestion de mon profil</a>.</p>";
        } 
    }
    elseif ($id_role == 2)
    {
        $req = "SELECT * 
            FROM utilisateur AS u, role AS r, roles_utilisateur AS ru 
            WHERE u.id = ru.id_utilisateur
            AND r.id = ru.id_role
            AND u.nom='$nom' AND u.prenom='$prenom' AND u.naissance='$naissance'" ;
        $res = mysql_query($req) ;
        $ligne=mysql_fetch_object($res) ;
        $nom = ucfirst(strtolower($ligne->nom)) ;
        $prenom = ucfirst(strtolower($ligne->prenom)) ;     
        $role = $ligne->nom_role ;
        $annee_promo = $ligne->annee_promo ;
        $mail = $ligne->mail ;
        $date_inscription = date($ligne->date_inscription) ;
        $date_maj_profil = date($ligne->date_maj_profil) ;
        echo "<p>$nom $prenom</p>
        <p><strong>$role</strong></p>
        <p><strong>Année de la promotion</strong> : $annee_promo</p>
        <p><strong>Adresse mail</strong> : $mail </p>
        <p><strong>Date d'inscription</strong> : $date_inscription </p>
        <p><strong>Date de mise à jour du profil</strong> : $date_maj_profil </p>
        <br/>";
    }
    
    
    elseif ($id_role == 3 or $id_role == 4)
    {
        $req = "SELECT * 
            FROM utilisateur AS u, role AS r, roles_utilisateur AS ru 
            WHERE u.id = ru.id_utilisateur
            AND r.id = ru.id_role
            AND u.nom='$nom' AND u.prenom='$prenom' AND u.naissance='$naissance'" ;
        $res = mysql_query($req) ;
        $ligne=mysql_fetch_object($res) ;
        $nom = ucfirst(strtolower($ligne->nom)) ;
        $prenom = ucfirst(strtolower($ligne->prenom)) ;
        $role = $ligne->nom_role ;
        $mail = $ligne->mail ;
        $date_inscription = date($ligne->date_inscription) ;
        $date_maj_profil = date($ligne->date_maj_profil) ;
        echo "<p>$nom $prenom</p>
        <p><strong>$role</strong></p>
        <p><strong>Adresse mail</strong> : $mail </p>
        <p><strong>Date d'inscription</strong> : $date_inscription </p>
        <p><strong>Date de mise à jour du profil</strong> : $date_maj_profil </p>
        <br/>";
    }

    
    echo "<p>Si vous rencontrez des problémes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
    afficheMenu($id_role);
    finhtml() ;
    }
  
else {
    echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
    echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
    }
    
mysql_close() ;
?>
