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
 
 
 ######################## traitement pour modification ##################################
if(isset($_POST['modifier'])) {
	if ($id_role == 1) {
			$mail_modif = stripslashes($_POST['mail']);
			$nom_modif = stripslashes($_POST['nom']);
			$nomPatro_modif = stripslashes($_POST['nomPatro']);
			$prenom_modif = stripslashes($_POST['prenom']);
			$naissance_modif = stripslashes($_POST['naissance']);
			$mdp_modif = stripslashes($_POST['mdp']);
			$affichage_mail_modif = stripslashes($_POST['affichage_mail']);
			$affichage_nom_modif = stripslashes($_POST['affichage_nom']);
			$affichage_nomPatro_modif = stripslashes($_POST['affichage_nomPatro']);
			$affichage_prenom_modif = stripslashes($_POST['affichage_prenom']);
			$affichage_mdp_modif = stripslashes($_POST['affichage_mdp']);

			if ($mail_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail='$mail_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			## l'option d'affichage est indépendante.
			if ($affichage_mail_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			else { $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail_niveau ='public'WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($nom_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
	
			if ($affichage_nom_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur  AS u, roles_utilisateur AS ru SET nom_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			else { $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($nomPatro_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_patronymique='$nomPatro_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
	
			if ($affichage_nomPatro_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nomPatro_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			else { $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nomPatro_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($prenom_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom='$prenom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
				
			if ($affichage_prenom_modif == 1){
					$res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom_niveau ='prive' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			else { $res_affich_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom_niveau ='public' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($naissance_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET naissance='$naissance_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($mdp_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET pass='$mdp_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
	
				if ($id_statut == 2){ }
	
	if ($id_role >= 2){
			$mail_modif = stripslashes($_POST['mail']);
			$nom_modif = stripslashes($_POST['nom']);
			$nomPatro_modif = stripslashes($_POST['nomPatro']);
			$prenom_modif = stripslashes($_POST['prenom']);
			$naissance_modif = stripslashes($_POST['naissance']);
			$mdp_modif = stripslashes($_POST['mdp']);
	
			if ($mail_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET mail='$mail_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($nom_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom='$nom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
	
			if ($nomPatro_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET nom_patronymique='$nomPatro_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
	
			if ($prenom_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET prenom='$prenom_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($naissance_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET naissance='$naissance_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			
			if ($mdp_modif!=""){
				$res_modif = mysql_query ("UPDATE utilisateur AS u, roles_utilisateur AS ru SET pass='$mdp_modif' WHERE u.id = ru.id_utilisateur AND id_role = '$id_role'");}
			}
			
			

	}
	// Suivant si la modification a été un succès ou pas, on affiche un autre message.						
	if($resultat <> False) {
			$message .= "<p class=\"succes\">Profil modifié dans la base de données.</p>";
		} else {
			$message .= "<p class=\"erreur\">Erreur lors de la suppression.</p>" ;
		}
}

################################################################################################


if(isset($_POST['changeStatut'])) {
	$radio_statut = $_POST['statutActuel'];
	$requete = "UPDATE statut_ancien_etudiant SET id_statut = $radio_statut WHERE statut_ancien_etudiant.id_utilisateur = $id_utilisateur";
	$resultat = mysql_query($requete);
	// Suivant si le changement de statut a été un succès ou pas, on affiche un autre message.	
	if($resultat <> False) {
			$message .= "<p class=\"succes\">Statut modifié dans la base de données. Veuillez recharger la page pour voir la modification de votre profil.</p>";
		} else {
			$message .= "<p class=\"erreur\">Erreur lors de la modification du statut.</p>" ;
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
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"nomPatro\">Nom patronymique (nom au moment de votre obtention de diplôme M2 DEFI) : </label>
							<input type=\"text\" id=\"nomPatro\" name=\"nomPatro\" value=\"nom à modifier\" />
							<select name=\"affichage_nomPatro\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"prenom\">Prénom * : </label>
							<input type=\"text\" name=\"prenom\" id=\"prenom\" value=\"$prenom\" />
							<select name=\"affichage_prenom\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"naissance\">Date de naissance * : </label>
							<input type=\"text\" id=\"naissance\" name=\"naissance\" value=\"$naissance\" />
							</p>
						<p>
							<label for=\"mail\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
							<select name=\"affichage_mail\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
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
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
							<p>
							<label for=\"web_ent\">Adresse web de l'entreprise actuelle : </label>
							<input type=\"text\" name=\"web_ent\" id=\"web_ent\" value=\"donnée à modifier\"/>
							<select name=\"affichage_web_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"poste_ent\">Votre poste dans l'entreprise * : </label>
							<input type=\"text\" id=\"poste_ent\" name=\"poste_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_poste_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"mail_ent\">Adresse E-Mail professionnelle : </label>
							<input type=\"text\" id=\"mail_ent\" name=\"mail_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_mail_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"secteur_ent\">Secteur d'activité de l'entreprise : </label>
							<input type=\"text\" id=\"secteur_ent\" name=\"secteur_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_secteur_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
						<p>
							<label for=\"code_postal_ent\">Ville * : </label>
							<input type=\"text\" id=\"ville_ent\" name=\"ville_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_ville_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>											
						<p>
							<label for=\"code_postal_ent\">Code Postal * : </label>
							<input type=\"text\" id=\"code_postal_ent\" name=\"code_postal_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_code_postal_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>					
						<p>
							<label for=\"pays_ent\">Pays *: </label>
							<input type=\"text\" id=\"pays_ent\" name=\"pays_ent\" value=\"donnée à modifier\" />
							<select name=\"affichage_pays_ent\">
								<option value=\"1\">Affichage privé</option>
								<option value=\"2\">Affichage public</option>
							</select>
						</p>
					</fieldset>
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
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"etab\">Établissement * : </label>
						<input type=\"text\" name=\"etab\" id=\"etab\" value=\"établissement à modifier\" />
						<select name=\"affichage_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
					<p>
						<label for=\"code_postal_etab\">Code Postal * : </label>
						<input type=\"text\" id=\"code_postal_etab\" name=\"code_postal_etab\" value=\"code postal à modifier\" />
						<select name=\"affichage_code_postal_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>					
					<p>
						<label for=\"pays_etab\">Pays *: </label>
						<input type=\"text\" id=\"pays_etab\" name=\"pays_etab\" value=\"pays à modifier\" />
						<select name=\"affichage_pays_etab\">
							<option value=\"1\">Affichage privé</option>
							<option value=\"2\">Affichage public</option>
						</select>
					</p>
				</fieldset>
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
							<label for=\"mail\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
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
							<label for=\"mail\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
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
							<label for=\"mail\">Adresse E-Mail * : </label>
							<input type=\"text\" id=\"mail\" name=\"mail\" value=\"$mail\" />
						</p>
						<p>
							<label for=\"mdp\">Nouveau mot de passe * : </label>
							<input type=\"password\" name=\"mdp\" id=\"mdp\" value=\"\" />
						</p>
					</fieldset>
				";
				}
			echo "<p class=\"submit\">
						<input type=\"submit\" name=\"modifier\" value=\"Valider\" />
					</p>
				</form>";
			if ($id_role == 1) {
				echo "<form action=\"gestionProfil.php\" method=\"post\">
						<h2>Changement de ma situation</h2>
						<fieldset>
							<legend>Changer mon statut en : </legend>
							<p>
								<label for=\"statutActuel\">Profil à remplir : </label>";
								if ($id_statut == 1) {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantARemplir\" checked=\"checked\" value=\"1\" />" ;
								}
								else {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantARemplir\" value=\"1\" />" ;
								}
							echo "</p>
							<p>
								<label for=\"statutActuel\">En poste : </label>";
								if ($id_statut == 2) {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantEmploi\" checked=\"checked\" value=\"2\" />" ;
								}
								else {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantEmploi\" value=\"2\" />" ;
								}
							echo "</p>
							<p>
								<label for=\"ancienEtudiantFormation\">En formation : </label>";
								if ($id_statut == 3) {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" checked=\"checked\" value=\"3\" />" ;
								}
								else {
									echo "<input name=\"statutActuel\" type=\"radio\" id=\"ancienEtudiantFormation\" value=\"3\" />" ;
								}
							echo "</p>
							<p>
								<label for=\"ancienEtudiantSansEmploi\">Sans emploi : </label>";
								if ($id_statut == 4) {
									echo "<input name=\"statutActuel\" type=\"radio\"  id=\"ancienEtudiantSansEmploi\" checked=\"checked\" value=\"4\" />" ;
								}
								else {
									echo "<input name=\"statutActuel\" type=\"radio\"  id=\"ancienEtudiantSansEmploi\" value=\"4\" />" ;
								}
							echo"
							</p>
						</fieldset>
						<p class=\"submit\">
							<input type=\"submit\" name=\"changeStatut\" value=\"Valider\" />
						</p>
						</form>";
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

echo "

	<h2>Export de mon profil aux formats xml ou pdf</h2>
	<p>Export au format <a href=\"export_xml.php\">xml</a>.<br/>
	Export au format <a href=\"export_pdf.php\">pdf</a>.</p>
	"

	afficheMenu($id_role);
	finhtml() ;
}
else {
	echo "<p class=\"erreur\">Erreur à l'identification</p>" ;
	echo "<p>Retournez à la <a href=\"connexion.php\">page de connexion</a>.</p>";
	}
    
mysql_close() ;
