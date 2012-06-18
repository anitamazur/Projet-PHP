<?php

require("fonctions.php") ;
$connexion = connexion() ;

session_start() ;

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
#$salt = "ashrihgbjnbfj";
#$pass = crypt($_SESSION['pass'], $salt);
$mail = $_SESSION['mail'] ;
$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);


debuthtml("Annuaire M2 DEFI - Administration","Annuaire M2 DEFI", "Administration",$id_role) ;

$message = "";

$res_pers = mysql_query ("SELECT id, nom, prenom, id_role FROM utilisateur, roles_utilisateur WHERE utilisateur.id = roles_utilisateur.id_utilisateur ORDER BY nom");
while($ligne = mysql_fetch_object($res_pers))
    { 	$id = $ligne->id;
    	$tab_pers[$ligne->id] = "$ligne->nom $ligne->prenom $ligne->id_role" ;
	}


if(isset($_POST['personne']))
   { $pers = $_POST['personne'] ; }
else
   { $pers = 0  ; }

   
if(isset($_POST['Inserer'])) {
		$mail = stripslashes($_POST['mail']);
		$nom = stripslashes($_POST['nom']);
		$nomPatro = stripslashes($_POST['nomPatro']);
		$prenom = stripslashes($_POST['prenom']);
		$naissance = stripslashes($_POST['naissance']);
		$anneePromo = stripslashes($_POST['anneePromo']);
		$mdp = stripslashes($_POST['mdp']);
		$mdpRepete = stripslashes($_POST['repeat_mdp']);
		$role = stripslashes($_POST['role']);
		if ($mdp != $mdpRepete) { 
			$message_ajout = "<p class=\"erreur\">Les 2 mots de passe sont diff?nts.</p>";
		}
		if($mail == "") {
			$message_ajout = "<p class=\"erreur\">Le champ 'E-Mail ?jouter' est vide.</p>";
		} 
		else {
			// On v?fie si l'adresse E-mail rentr?par l'utilisateur est au bon format
			$mail_ok = VerifierAdresseMail($mail);
			if($mail_ok == true) {
				$reqInscription = "INSERT INTO utilisateur (mail, mail_pro, pass, cle_activation, compte_active, nom, nom_patronymique, prenom, naissance, annee_promo, date_inscription, date_maj_profil) VALUES ('$mail','', ENCRYPT('$mdp', 'ashrihgbjnbfj'), '', '', '$nom', '$nomPatro', '$prenom', '$naissance', '$anneePromo', now(), now())" ;
				$resAjout = mysql_query($reqInscription) ;
				$id = mysql_insert_id();
				if($resAjout <> FALSE) {
					$message_ajout = "<p class=\"succes\">Profil enregistré dans la base de données.</p> <p>Vous pouvez vous connecter désormais en cliquant sur le point de menu <a href=\"connexion.php\">Connexion</a></p>" ;
		
					$relInscription = "INSERT INTO roles_utilisateur (id_utilisateur, id_role) VALUES ('$id','$role')" ;
					$relAjout = mysql_query($relInscription) ;
					if ($role == 1) {
						$statut = 1;
						$statutInscription = "INSERT INTO statut_ancien_etudiant (id_utilisateur, id_statut) VALUES ('$id','$statut')" ;
						$statutAjout = mysql_query($statutInscription) ;
					}
				} }
				else {
					$message_ajout = "<p class=\"erreur\">Erreur lors de l'enregistrement.</p>" ;
					}
				} 
				else{
				$message_ajout = "<p class=\"erreur\">L'adresse E-Mail à ajouter n'a pas le bon format.</p>";
				}
		}




if(isset($_POST['Supprimer'])) {
	$del_id = $id;
	$del_role = "DELETE FROM roles_utilisateur WHERE roles_utilisateur.id_utilisateur = '$del_id'";
	$del_statut = "DELETE FROM statut_ancien_etudiant WHERE statut_ancien_etudiant.id_utilisateur = '$del_id'";
	$del_utilisateur = "DELETE FROM utilisateur WHERE utilisateur.id = '$del_id'";
	
	$res_r = mysql_query ("SELECT id_role FROM utilisateur AS u, roles_utilisateurs AS ru WHERE u.id=ru.id_utilisateur AND u.id ='$del_id'");
	while($ligne = mysql_fetch_object($res_r))
    { $id_role = $ligne->id_role ;
	}

	if ($id_role == 1) {
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_statut);
		$resultat = mysql_query($del_utilisateur);
		$message .= "<p class=\"succes\">Profil supprimé de la base de données.</p>";
	}

	elseif ($id_role != 1){
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_utilisateur);
		$message .= "<p class=\"succes\">Profil supprimé de la base de données.</p>";
	}

		else {
			$message .= "<p class=\"erreur\">Erreur lors de la suppression.</p>" ;
		}
}

if ($id_role ==4)
{

if(isset($_POST['changer'])) {
	$radio_actuel = $_POST['Actuel'];
	
	if(isset($radio_actuel)){
	
		if($radio_actuel == 1)
			{
			$requete = "UPDATE roles_utilisateur AS ru, statut_ancien_etudiant AS sa SET id_role = $radio_actuel , id_statut = 1 WHERE ru.id_utilisateur = $id";
			$resultat = mysql_query($requete); 
			$message .= "<p class=\"succes\">Rôle modifié dans la base de données.</p>";}
			
		elseif($radio_actuel == 3)
		{
			$requete = "UPDATE roles_utilisateur AS ru SET id_role = $radio_actuel WHERE ru.id_utilisateur = $id";
			$resultat = mysql_query($requete); 
			$message .= "<p class=\"succes\">Rôle modifié dans la base de données.</p>";}
		
		elseif($radio_actuel == 4)
		{
			$requete = "UPDATE roles_utilisateur AS ru SET id_role = $radio_actuel WHERE ru.id_utilisateur = $id";
			$resultat = mysql_query($requete); 
			$message .= "<p class=\"succes\">Rôle modifié dans la base de données.</p>";}
	
		}
		else {
			$message .= "<p class=\"erreur\">Erreur lors de la modification du rôle.</p>" ;
		}
} }


echo "

	<h2>Export de l'annuaire complet</h2>
	<fieldset>
	<legend>Exporter au format</legend>
	<p><a href=\"export_xml_tous.php\">XML</a></p>
	<p><a href=\"export_pdf_tous.php\">PDF</a></p>
	</fieldset>";
	

echo " <h2>Création d'un profil</h2> 
<form id=\"inscription\" action=\"administration.php\" method=\"post\">
                <fieldset>
                    <legend>Insérer les données suivantes :</legend>
                    <p>
                    <label for=\"ancienEtudiant\">Ancien étudiant  : </label>
                    <input name=\"role\" type=\"radio\" id=\"ancienEtudiant\" value=\"1\" />
                    </p>
                    <p>
                    <label for=\"etudiantActuel\">étudiant actuel  : </label>
                    <input name=\"role\" type=\"radio\" id=\"etudiantActuel\" value=\"2\" />
                    </p>
					<p>
                    <label for=\"enseignant\">Enseignant  : </label>
                    <input name=\"role\" type=\"radio\" id=\"enseignant\" value=\"3\" />
                    </p>
                    <p>
                    <label for=\"administrateur\">Administrateur  : </label>
                    <input name=\"role\" type=\"radio\" id=\"administrateur\" value=\"4\" />
                    </p>
               
                    <label for=\"donneesPerso\"><strong>Données personnelles</strong></label>
                    <p>
                        <label for=\"nom\">Nom : </label>
                        <input type=\"text\" id=\"nom\" name=\"nom\" />
                         </p>
                    <p>
                        <label for=\"nomPatro\">Nom patronymique : </label>
                        <input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" />
                        </p>
                    <p>
                        <label for=\"prenom\">Prénom : </label>
                        <input type=\"text\" name=\"prenom\" id=\"prenom\" />
                        </p>
                    <p>
                        <label for=\"naissance\">Date de naissance : </label>
                        <input type=\"text\" id=\"naissance\" name=\"naissance\" />
                        <label for=\"format_naissance\">(format : yyyy-mm-dd)</label>
                    </p>
					
                    <p>
                        <label for=\"anneePromo\">Année d'obtention du M2 DEFI (pour anciens étudiants) ou année d'inscription au M2 DEFI (pour étudiants actuels): </label>
                        <input type=\"text\" name=\"anneePromo\" id=\"anneePromo\" />
						<label for=\"info\">uniquement pour étudiant actuel ou ancien étudiant </label>
                        </p>
                    <p>
                        <label for=\"mail\">Adresse E-Mail : </label>
                        <input type=\"text\" id=\"mail\" name=\"mail\" />
                         </p>
                    <p>
                        <label for=\"mdp\">Mot de passe  : </label>
                        <input type=\"password\" name=\"mdp\" id=\"mdp\" />
                    </p>
                    <p>
                        <label for=\"repeat_mdp\">Confirmer le mot de passe  : </label>
                        <input type=\"password\" name=\"repeat_mdp\" id=\"repeat_mdp\" />
                    </p>
					
					<p>
                    <input type=\"submit\" name=\"Inserer\" value=\"Inserer\" />
                </p>
                </fieldset>                 
                
            </form>";
	

echo "<h2>Suppression de profil</h2>
	<form action=\"administration.php\" method=\"post\">
		<fieldset>
			<legend>Les données seront perdues définitivement</legend>
			<label for=\"explication\"> 1 : ancien étudiant _ 2 : étudiant actuel _ 3 : enseignant _ 4 : administrateur </label>
			<p>"; menuderoulant("personne", $tab_pers); echo"</p>
			<p>
				<input type=\"submit\" name=\"Supprimer\" value=\"supprimer le profil\" />
			</p>
		</fieldset>
	</form>";
	

if ($id_role == 4){

echo "<form action=\"administration.php\" method=\"post\">
						<h2>Changement de la situation</h2>
						<fieldset>
							<legend>Changer le rôle de : </legend>
								<label for=\"explication\"> 1 : ancien étudiant _ 2 : étudiant actuel _ 3 : enseignant _ 4 : administrateur </label>
							<p>"; menuderoulant("personne", $tab_pers); echo"</p>

					
							<p> <label for=\"titre\"><strong>Changement de rôle : </strong></label>
							
								<label for=\"Actuel\">Ancien étudiant</label>
								<input name=\"Actuel\" type=\"radio\" id=\"ancienEtudiant\" checked=\"checked\" value=\"5\" />
								
								<label for=\"Actuel\">Enseignant</label>
								<input name=\"Actuel\" type=\"radio\" id=\"Enseignant\" value=\"6\" />
								
								<label for=\"Actuel\">Administrateur</label>
								<input name=\"Actuel\" type=\"radio\" id=\"administrateur\" value=\"7\" />
							</p>
							
							<p>
							<input type=\"submit\" name=\"changer\" value=\"Modifier\" />
						</p>
						
						</fieldset>
						
						</form>";


	}				
						


debutmenu();
	echo "<li><a href=\"pageAccueil.php\">Accueil</a></li>";
	finmenu();
	
	
finhtml();

mysql_close();

?>