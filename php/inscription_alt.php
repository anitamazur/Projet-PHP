<?php
    // Le fichier avec les fonctions est chargé
    // On démarre la session
    session_start();
    require_once("fonctions.php");
    $connexion = connexion();
    $message_ajout = "";
	//On vérifie si l'utilisateur a cliqué sur le bouton "Valider", si oui on crée une requete SQL permettant d'ajouter dans la base de données les données rentrées par l'utilisateur. Celle-ci ne sera executée seulement si les champs à remplir pour rentrer ne sont ni vides, ni au mauvais format. 
	if(isset($_POST['valider'])) {
		$mail = stripslashes($_POST['mail']);
		$affichage_mail = stripslashes($_POST['affichage_mail']);
		$nom = stripslashes($_POST['nom']);
		$affichage_nom = stripslashes($_POST['affichage_nom']);
		$nomPatro = stripslashes($_POST['nomPatro']);
		$affichage_nomPatro = stripslashes($_POST['affichage_nomPatro']);
		$prenom = stripslashes($_POST['prenom']);
		$affichage_prenom = stripslashes($_POST['affichage_prenom']);
		$naissance = stripslashes($_POST['naissance']);
		$affichage_naissance = stripslashes($_POST['affichage_naissance']);
		$anneePromo = stripslashes($_POST['anneePromo']);
		$mdp = stripslashes($_POST['mdp']);
		$mdpRepete = stripslashes($_POST['repeat_mdp']);
		$role = stripslashes($_POST['role']);
		if ($mdp != $mdpRepete) { 
			$message_ajout = "<p class=\"erreur\">Les 2 mots de passe sont différents.</p>";
		}
		if($mail == "") {
			$message_ajout = "<p class=\"erreur\">Le champ 'E-Mail à ajouter' est vide.</p>";
		} else {
			// On vérifie si l'adresse E-mail rentrée par l'utilisateur est au bon format
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
			
			## je ne comprend pas les requêtes suivantes puisque par défaut le niveau est privé
			## je pense que les étudiants actuels devraient aussi définir leurs options d'affichage
						$res_an = mysql_query("INSERT INTO utilisateur (nom_niveau) VALUES ('prive')");
						$res_anp = mysql_query("INSERT INTO utilisateur (nomPatro_niveau) VALUES ('prive')");
						$res_p = mysql_query("INSERT INTO utilisateur (prenom_niveau) VALUES ('prive')");
						$res_na = mysql_query("INSERT INTO utilisateur (naissance_niveau) VALUES ('prive')");
						$res_m = mysql_query("INSERT INTO utilisateur (mail_niveau) VALUES ('prive')");
						$res_mp = mysql_query("INSERT INTO utilisateur (mailPro_niveau) VALUES ('prive')");
					}			
					
				} else {
					$message_ajout = "<p class=\"erreur\">Erreur lors de l'enregistrement.</p>" ;
				}
			} elseif ($mail_ok == false) {
				$message_ajout = "<p class=\"erreur\">L'adresse E-Mail à ajouter n'a pas le bon format.</p>";
			}
		}

	}
    
    debuthtml ("Annuaire M2 DEFI - Inscription","Annuaire M2 DEFI","Inscription à l'annuaire");
    echo $message_ajout ;
 ?>
            <p>* : champs obligatoires</p>
            <form id="inscription" action="inscription.php" method="post">
                <fieldset>
                    <legend>Inscription en tant que :</legend>
                    <p>
                    <label for="ancienEtudiant">Ancien étudiant * : </label>
                    <input name="role" type="radio" id="ancienEtudiant" value="1" />
                    </p>
                    <p>
                    <label for="etudiantActuel">Étudiant actuel * : </label>
                    <input name="role" type="radio" id="etudiantActuel" value="2" />
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Données personnelles :</legend>
                    <p>
                        <label for="nom">Nom * : </label>
                        <input type="text" id="nom" name="nom" />
                    </p>
                    <p>
                        <label for="nomPatro">Nom patronymique (nom au moment de votre obtention de diplôme M2 DEFI) : </label>
                        <input type="text" id="nomPatro" name="nomPatro" />
                    </p>
                    <p>
                        <label for="prenom">Prénom * : </label>
                        <input type="text" name="prenom" id="prenom" />
                    </p>
                    <p>
                        <label for="naissance">Date de naissance * : </label>
                        <input type="text" id="naissance" name="naissance" />
                        (format : yyyy-mm-dd)
                    </p>
                    <p>
                        <label for="anneePromo">Année d'obtention du M2 DEFI (pour anciens étudiants) ou année d'inscription au M2 DEFI (pour étudiants actuels)* : </label>
                        <input type="text" name="anneePromo" id="anneePromo" />
                        </p>
                    <p>
                        <label for="mail">Adresse E-Mail (restera confidentiel) * : </label>
                        <input type="text" id="mail" name="mail" />               
                    </p>
                    <p>
                        <label for="mdp">Mot de passe * : </label>
                        <input type="password" name="mdp" id="mdp" />
                    </p>
                    <p>
                        <label for="repeat_mdp">Confirmer le mot de passe * : </label>
                        <input type="password" name="repeat_mdp" id="repeat_mdp" />
                    </p>
                </fieldset>                 
                <p class="submit">
                    <input type="submit" name="valider" value="valider" />
                </p>
            </form>
            <?php
    finhtml();
            mysql_close ();
?>
