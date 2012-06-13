<?php 

session_start() ;

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$naissance = $_SESSION['naissance'];
$mail = $_SESSION['mail'] ;
$annee_promo = $_SESSION['annee_promo'];
$id_role = $_SESSION['id_role'];
$id_statut = $_SESSION['id_statut'];

require_once("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Recherche","Annuaire M2 DEFI", "Recherche dans l'annuaire") ;
affichetitre("Recherche sur anciens étudiants UNIQUEMENT", "3");

if (connexionUtilisateurReussie())
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
			</form>";
			
			debutmenu();
		if($id_role == 1) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"monprofil.php\">Mon profil</a></li>";
			echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"mapromo.php\">Ma promo</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
		}
		elseif($id_role == 2) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
		}
		elseif($id_role >= 3) {
			echo "<li><a href=\"accueil.php\">Accueil</a></li>";
			echo "<li><a href=\"gestionProfil.php\">Gestion de mon profil</a></li>";
			echo "<li><a href=\"administration.php\">Administration</a></li>";
			echo "<li><a href=\"lespromos.php\">Les promos</a></li>";
			echo "<li><a href=\"deconnexion.php\">Déconnexion</a></li>";
			}
			finmenu();
		}

else
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
			</form>";
afficheMenu($id_role);
		}

		
		echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";

		finhtml();

mysql_close();

?>
		
