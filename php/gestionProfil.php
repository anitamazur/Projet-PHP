<?php
require_once("fonctions.php") ;

//code pour decrypter le mot de passe qui a été crypté à l'inscription.


session_start() ;
$connexion = connexion() ;
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$salt = "ashrihgbjnbfj";
$pass = crypt($_SESSION['pass'], $salt);
$mail = $_SESSION['mail'] ;
$id_utilisateur = $_SESSION['id_utilisateur'] = getID($nom, $prenom, $mail);
$id_role = $_SESSION['id_role'] = role($id_utilisateur);
$id_statut = $_SESSION['id_statut'] = statut($id_utilisateur);
$message = "";

if(isset($_POST['Supprimer'])) {
	$del_id = $id_utilisateur;
	$del_role = "DELETE FROM roles_utilisateur WHERE roles_utilisateur.id_utilisateur = $del_id";
	$del_statut = "DELETE FROM statut_ancien_etudiant WHERE statut_ancien_etudiant.id_utilisateur = $del_id";
	$del_utilisateur = "DELETE FROM utilisateur WHERE utilisateur.id = $del_id";
	
	if ($id_role == 1) {
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_statut);
		$resultat = mysql_query($del_utilisateur);
	}
	
	else {
		$resultat = mysql_query($del_role);
		$resultat = mysql_query($del_utilisateur);
	}
	
	
	
			// Suivant si la suppression a été un succès ou pas, on affiche un autre message.						
			if($resultat <> False) {
					$message .= "<p class=\"succes\">Profil supprimé de la base de données.</p>";
				} else {
					$message .= "<p class=\"erreur\">Erreur lors de la suppression.</p>" ;
				}
}




//affichage d'une page d'accueil personnalisée selon le rôle
if(connexionUtilisateurReussie()) {
	debuthtml("Annuaire M2 DEFI - Accueil","Annuaire M2 DEFI", "Gestion du profil") ;
	echo $message ;
	if ($id_role == 1) {
		affichetitre("Profil Ancien étudiant :","3") ;
		echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Données personnelles :</legend>
						<p>
							<label for=\"nom\">Nom * : </label>
							<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
							<select name=\"affichage_nom\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"nomPatro\">Nom patronymique (nom au moment de votre obtention de diplôme M2 DEFI) : </label>
							<input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" value=\"nom à modifier\" />
							<select name=\"affichage_nomPatro\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"prenom\">Prénom * : </label>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
							<select name=\"affichage_prenom\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"naissance\">Date de naissance * : </label>
							<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
							<select name=\"affichage_naissance\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"email\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"email\" name=\"email\" value=\"$mail\" />
							<select name=\"affichage_email\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
					";
					
					if ($id_statut == 2) {
						echo"
					<fieldset>
						<legend>Données professionnelles :</legend>
						<p>
							<label for=\"nom_ent\">Nom de l'entreprise actuelle * : </label>
							<input type=\"text\" name=\"nom_ent\" id=\"nom_ent\" value=\"donnée à modifier\"/>
							<select name=\"affichage_nom_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
							<p>
							<label for=\"web_ent\">Adresse web de l'entreprise actuelle : </label>
							<input type=\"text\" name=\"web_ent\" id=\"web_ent\" value=\"donnée à modifier\"/>
							<select name=\"affichage_web_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"poste_ent\">Votre poste dans l'entreprise * : </label>
							<input type=\"text\" id=\"poste_ent\" name=\"poste_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_poste_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"email_ent\">Adresse E-Mail professionnelle : </label>
							<input type=\"text\" id=\"email_ent\" name=\"email_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_email_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"secteur_ent\">Secteur d'activité de l'entreprise : </label>
							<input type=\"text\" id=\"secteur_ent\" name=\"secteur_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_secteur_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>					
						<p>
							<label for=\"code_postal_ent\">Code Postal * : </label>
							<input type=\"text\" id=\"code_postal_ent\" name=\"code_postal_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_code_postal_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>					
						<p>
							<label for=\"pays_ent\">Pays *: </label>
							<input type=\"text\" id=\"pays_ent\" name=\"pays_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_pays_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
								<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
								<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
								<option value=\"5\">Affichage public</option>
							</select>
						</p>
					</fieldset>		
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
				</form>
				<form action=\"changementSituation.php\" method=\"post\">
					<h2>Changement de ma situation</h2>
					<fieldset>
						<legend>Changer mon statut en : </legend>
						<p>
							<label for=\"statutActuel\">En poste : </label>
							<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" checked=\"checked\" value=\"3\" />
						</p>
						<p>
							<label for=\"ancienEtudiantFormation\">En formation : </label>
							<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" value=\"1\" />
						</p>
						<p>
							<label for=\"ancienEtudiantSansEmploi\">Sans emploi : </label>
							<input type=\"radio\" name=\"statutActuel\" id=\"ancienEtudiantSansEmploi\" value=\"2\" />
						</p>
					</fieldset>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
					</form>
				";
				}
				else if ($id_statut == 3) {
						echo"
				<fieldset>
					<legend>Formation :</legend>
					<p>
						<label for=\"diplome\">Diplôme préparé actuellement* : </label>
						<input type=\"text\" id=\"diplome\" name=\"diplome\" value=\"diplôme à modifier\" />
						<select name=\"affichage_diplome\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
							<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
							<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
							<option value=\"5\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"etab\">Établissement * : </label>
						<input type=\"text\" name=\"etab\" id=\"etab\" value=\"établissement à modifier\" />
						<select name=\"affichage_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
							<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
							<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
							<option value=\"5\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"recherche\">Thème de recherche : </label>
						<input type=\"text\" id=\"recherche\" name=\"recherche\" value=\"thème à modifier\" />
						<select name=\"affichage_recherche\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
							<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
							<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
							<option value=\"5\">Affichage public</option>
						</select>
					</p>				
					<p>
						<label for=\"code_postal_etab\">Code Postal * : </label>
						<input type=\"text\" id=\"code_postal_etab\" name=\"code_postal_etab\" value=\"code postal à modifier\" />
						<select name=\"affichage_code_postal_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
							<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
							<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
							<option value=\"5\">Affichage public</option>
						</select>
					</p>					
					<p>
						<label for=\"pays_etab\">Pays *: </label>
						<input type=\"text\" id=\"pays_etab\" name=\"pays_etab\" value=\"pays à modifier\" />
						<select name=\"affichage_pays_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage pour anciens étudiants uniquement</option>
							<option value=\"3\">Affichage pour étudiants actuels uniquement</option>
							<option value=\"4\">Affichage pour anciens étudiants et étudiants actuels</option>
							<option value=\"5\">Affichage public</option>
						</select>
					</p>
				</fieldset>		
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
				</form>
				<form action=\"changementSituation.php\" method=\"post\">
					<h2>Changement de ma situation</h2>
					<fieldset>
						<legend>Changer mon statut en : </legend>
						<p>
							<label for=\"statutActuel\">En poste : </label>
							<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" checked=\"checked\" value=\"3\" />
						</p>
						<p>
							<label for=\"ancienEtudiantFormation\">En formation : </label>
							<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" value=\"1\" />
						</p>
						<p>
							<label for=\"ancienEtudiantSansEmploi\">Sans emploi : </label>
							<input type=\"radio\" name=\"statutActuel\" id=\"ancienEtudiantSansEmploi\" value=\"2\" />
						</p>
					</fieldset>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
					</form>
				";
				}
			}
			else if ($id_role == 2) {
		affichetitre("Étudiant actuel :","3") ;
		echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Données personnelles :</legend>
						<p>
							<label for=\"nom\">Nom * : </label>
							<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
						</p>
						<p>
							<label for=\"nomPatro\">Nom patronymique (nom au moment de votre obtention de diplôme M2 DEFI) : </label>
							<input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" value=\"nom à modifier\" />
						</p>
						<p>
							<label for=\"prenom\">Prénom * : </label>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
						</p>
						<p>
							<label for=\"naissance\">Date de naissance * : </label>
							<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
						</p>
						<p>
							<label for=\"email\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"email\" name=\"email\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
					</form>
				";
				}
				if ($id_role == 3) {
		affichetitre("Enseignant :","3") ;
		echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Données personnelles :</legend>
						<p>
							<label for=\"nom\">Nom * : </label>
							<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
						</p>
						<p>
							<label for=\"prenom\">Prénom * : </label>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
						</p>
						<p>
							<label for=\"naissance\">Date de naissance * : </label>
							<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
						</p>
						<p>
							<label for=\"email\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"email\" name=\"email\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
					</form>
				";
				}
				if ($id_role == 4) {
		affichetitre("Administrateur :","3") ;
		echo "<p>Modifiez vos données en les remplaçant dans les champs appropriés.</p>" ;
		echo "<form id=\"form1\" action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Données personnelles :</legend>
						<p>
							<label for=\"nom\">Nom * : </label>
							<input type=\"text\" id=\"nom\" name=\"nom\" value=\"$nom\" />
						</p>
						<p>
							<label for=\"prenom\">Prénom * : </label>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
						</p>
						<p>
							<label for=\"naissance\">Date de naissance * : </label>
							<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
						</p>
						<p>
							<label for=\"email\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"email\" name=\"email\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
					</form>
				";
				}
	echo "
			<h2>Suppression de mon profil</h2>
			<form action=\"gestionProfil.php\" method=\"post\">
				<fieldset>
					<legend>Les données seront perdues définitivement</legend>
					<p>
						<input type=\"submit\" name=\"Supprimer\" value=\"supprimer mon profil\" />
					</p>
				</fieldset>
			</form>
		</div>
	</body>
</html>";

	afficheMenu($id_role);
	finhtml() ;
}
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
