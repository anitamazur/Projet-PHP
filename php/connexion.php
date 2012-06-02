<?php
require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Page de connexion","Annuaire M2 DEFI", "Connexion au site") ;
?>
			<form id="form1" action="pageAccueil.php" method="post">
				<fieldset>
					<legend>Si vous avez déjà un compte, veuillez introduire les informations suivantes :</legend>
					<p>
						<label for="nom">Nom : </label>
						<input type="text" id="nom" name="nom" />
					</p>
					<p>
						<label for="prenom">Prénom : </label>
						<input type="text" id="prenom" name="prenom" />
					</p>
					<p>
						<label for="naissance">Date de naissance : </label>
						<input type="text" id="naissance" name="naissance" />
						 (format : yyyy-mm-dd)
					</p>
					<p>
						<label for="email">Email : </label>
						<input type="text" id="email" name="email" />
					</p>
					<p>
						<label for="mdp">Mot de passe : </label>
						<input type="password" name="mdp" id="mdp" />
					</p>
					<p class="submit">
						<input type="submit" name="valider" value="Valider" />
					</p>
				</fieldset>
			</form>
			
			
			<p>Cliquer <a href="recherche.php">ici</a> pour faire une recherche dans l'annuaire</p>
		
			
			<p>Si vous n'avez pas d'identifiants, veuillez vous inscrire en cliquant sur <a href="inscription.php">Inscription</a></p>
			<p>Si vous rencontrez des problèmes n'hésitez pas à <a href="mailto:admin@annuairedefi.u-paris10.fr">contacter l'administrateur</a></p>

<?php
finhtml() ; 
?>
		
