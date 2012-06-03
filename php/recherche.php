<?php 

session_start() ;
$nom = $_SESSION['nom'] ;
$prenom = $_SESSION['prenom'] ;

require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Recherche","Annuaire M2 DEFI", "Recherche dans l'annuaire") ;


if ($_SESSION['nom'] == true && $_SESSION['prenom'] == true)
		{
		affichetitre("Recherche par nom et prénom dans l'annuaire","3");
		echo"<form id=\"form1\" action=\"recherche_traitement.php\" method=\"post\">
				<fieldset>
					<legend>Entrez le nom, prénom de la personne recherchée :</legend>
					<p>
						<label for=\"nom\">Nom : </label>
						<input type=\"text\" id=\"nom\" name=\"nom\" />
					</p>
					<p>
						<label for=\"prenom\">Prénom : </label>
						<input type=\"text\" name=\"prenom\" id=\"prenom\" />
					</p>
					<p class=\"submit\">
						<input type=\"submit\" name=\"valider\" value=\"Valider\" />
					</p>
				</fieldset>
			</form>";
			
			affichetitre("Recherche par promotion dans l'annuaire","3");
			echo"<form id=\"form1\" action=\"recherche_traitement.php\" method=\"post\">
				<fieldset>
					<legend>Entrez l'année de la promotion recherchée :</legend>
					<p>
						<label for=\"annee_promo\">Année de la promotion: </label>
						<input type=\"text\" id=\"annee_promo\" name=\"annee_promo\" />
					</p>
					<p class=\"submit\">
						<input type=\"submit\" name=\"envoyer\" value=\"Valider\" />
					</p>
				</fieldset>
			</form>
			<p><a href=\"pageAccueil.php\">Retour à la page d'accueil de l'annuaire</a></p>";	
		}

elseif ($_SESSION['nom'] == false && $_SESSION['prenom'] == false)
{
		affichetitre("Recherche par promotion dans l'annuaire","3");
			echo"<form id=\"form1\" action=\"recherche_traitement.php\" method=\"post\">
				<fieldset>
					<legend>Entrez l'année de la promotion recherchée :</legend>
					<p>
						<label for=\"annee_promo\">Année de la promotion: </label>
						<input type=\"text\" id=\"annee_promo\" name=\"annee_promo\" />
					</p>
					<p class=\"submit\">
						<input type=\"submit\" name=\"envoyer\" value=\"Valider\" />
					</p>
				</fieldset>
			</form>
			<p><a href=\"connexion.php\">Retour à la page de connexion de l'annuaire</a></p>
			<p><a href=\"inscription.php\">Retour à la page d'inscription de l'annuaire</a></p>";	
		}

		
		echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";

		finhtml();

mysql_close();

?>
		
