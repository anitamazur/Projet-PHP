<?php
require("listeFonctions.php") ;
$connexion = connexion() ;

debuthtml (Annuaire M2 DEFI - Page de connexion , Annuaire M2 DEFI, Connexion au site)
?>
			<form id="form1" action="pageAccueil.php" method="post">
				<fieldset>
					<legend>Si vous avez d�j� un compte, veuillez introduire les informations suivantes :</legend>
					<p>
						<label for="email">Adresse E-Mail : </label>
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
			<p>Si vous n'avez pas d'identifiants, veuillez vous inscrire en cliquant sur <a href="inscription.html">Inscription</a></p>
			<p>Si vous rencontrez des probl�mes n'h�sitez pas � <a href="mailto:admin@annuairedefi.u-paris10.fr">contacter l'administrateur</a></p>

<?php

finhtml ()
?>
		
