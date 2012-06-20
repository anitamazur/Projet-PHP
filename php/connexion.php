<?php
require("fonctions.php") ;
$connexion = connexion() ;

debuthtml("Annuaire M2 DEFI - Page de connexion","Annuaire M2 DEFI", "Connexion au site","") ;
?>
            <p>L'annuaire du M2 DEFI est là pour rendre compte de la situation professionnelle des anciens étudiants. Ainsi, les enseignants, mais aussi les étudiants actuels peuvent suivre leur évolution professionnelle après l'obtention du diplôme M2 DEFI. Les données personnelles qui seront entrées dans cet annuaire ne seront pas diffusées sans accord préalable. En effet, lors de l'inscription, l'ancien étudiant peut choisir quelles informations seront diffusés publiquement et lesquelles resteront privées. Aussi, il est possible à tout moment de supprimer le profil ou de modifier le niveau de diffusion des informations du profil.</p>
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
                        <label for="format_naissance">(format : yyyy-mm-dd)</label>
                    </p>
                    <p>
                        <label for="mail">Email : </label>
                        <input type="text" id="mail" name="mail" />
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
            <p>Si vous n'avez pas d'identifiants, veuillez vous inscrire en cliquant sur <a href="inscription.php">Inscription</a></p>
            <p>Si vous rencontrez des problèmes n'hésitez pas à <a href="mailto:admin@annuairedefi.u-paris10.fr">contacter l'administrateur</a></p>

<?php
finhtml() ; 
?>
        
