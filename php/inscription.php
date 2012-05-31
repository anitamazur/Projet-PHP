<?php
	// Le fichier avec les fonctions est chargé
	require_once("outils.php");
	$connexion = connexion();
	// On démarre la session
	session_start();
		
		debuthtml ("Annuaire M2 DEFI - Inscription","Annuaire M2 DEFI","Inscription à l'annuaire");
			afficheMenu();
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
					<input type="radio" name="role" id="etudiantActuel" value="2" />
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
					</p>
					<p>
						<label for="anneePromo">Année d'obtention du M2 DEFI (pour anciens étudiants) ou année d'inscription au M2 DEFI (pour étudiants actuels)* : </label>
						<input type="text" name="anneePromo" id="anneePromo" />
					</p>
					<p>
						<label for="email">Adresse E-Mail (restera confidentiel) * : </label>
						<input type="text" id="email" name="email" />
					</p>
					<p>
						<label for="mdp">Mot de passe * : </label>
						<input type="password" name="mdp" id="mdp" />
					</p>
					<p>
						<label for="repeat_mdp">Confirmer le mot de passe * : </label>
						<input type="password" name="repeat_md" id="repeat_mdp" />
					</p>
				</fieldset>					
				<p class="submit">
					<input type="submit" name="valider" value="valider" />
				</p>
			</form>
			<?php
			//On vérifie si l'utilisateur a cliqué sur le bouton "Valider", si oui on crée une requete SQL permettant d'ajouter dans la base de données les données rentrées par l'utilisateur. Celle-ci ne sera executée seulement si les champs à remplir pour rentrer ne sont ni vides, ni au mauvais format. 
				if(isset($_POST['valider'])) {
					$email = stripslashes($_POST['email']);
					$nom = stripslashes($_POST['nom']);
					$nomPatro = stripslashes($_POST['nomPatro']);
					$prenom = stripslashes($_POST['prenom']);
					$naissance = stripslashes($_POST['naissance']);
					$anneePromo = stripslashes($_POST['anneeDiplome']);
					$mdp = stripslashes($_POST['mdp']);
					$mdpRepete = stripslashes($_POST['repeat_md']);
					$role = stripslashes($_POST['role']);
					$dn2 = mysql_num_rows(mysql_query('SELECT id FROM utilisateurs'));
                    $id = $dn2+1;
                    
					$message_ajout = "";
					if ($_POST['pass'] != $_POST['pass_confirm']) { 
         $erreur = 'Les 2 mots de passe sont différents.';
					if($email == "") {
						$message_ajout = "<p class=\"erreur\">Le champ 'E-Mail à ajouter' est vide.</p>";
					} else {
						// On vérifie si l'adresse E-mail rentrée par l'utilisateur est au bon format
						$email_ok = VerifierAdresseMail($email);
						if($nouvelle_email_ok == true) {
							$reqInscription = "INSERT INTO utilisateur (mail, mail_pro, pass, cle_activation, compte_active, nom, nom_patronymique, prenom, naissance, annee_promo, date_inscription, date_maj_profil) VALUES ('$email','', '$mdp', '', '', '$nom', '$nomPatro', '$prenom', '$naissance', '$anneePromo', now(), '')" ;
							$resAjout = mysql_query(reqInscription) ;
							$relInscription = "INSERT INTO roles_utilisateur (id_utilisateur, id_role) VALUES ('$id','$role')" ;
							$relAjout = mysql_query(relInscription) ;
							if($resAjout <> FALSE) {
								$message_ajout = "<p class=\"succes\">Profil enregistré dans la base de données.</p>" ;
							} else {
								$message_ajout = "<p class=\"erreur\">Erreur lors de l'enregistrement.</p>" ;
							}
						} elseif ($nouvelle_email_ok == false) {
							$message_ajout = "<p class=\"erreur\">L'adresse E-Mail à ajouter n'a pas le bon format.</p>";
						}
					}
			
			}
	finhtml();
			mysql_close ();
			?>
		
