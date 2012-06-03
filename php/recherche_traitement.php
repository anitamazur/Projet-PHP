<?php
 session_start();
 
 require("fonctions.php");
 $connexion = connexion();
    
	if(isset($_POST['valider'])) {
		$nom = stripslashes($_POST['nom']);
		$prenom = stripslashes($_POST['prenom']);
	
	debuthtml("Annuaire M2 DEFI - Recherche", "Annuaire M2 DEFI", "Recherche");
	affichetitre ("Résultat de votre recherche","2") ;
	
			$req = "SELECT * 
			FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
			WHERE u.id = ru.id_utilisateur
			AND u.id = sa.id_utilisateur
			AND r.id = ru.id_role
			AND s.id = sa.id_statut
			AND nom='$nom' AND prenom='$prenom' " ;

			$res = mysql_query($req) ;

			if(mysql_num_rows($res) > 0)
				{
			$ligne=mysql_fetch_object($res) ;
				$nom = $ligne->nom ;
				$prenom = $ligne->prenom ; 	
				$id_role = $ligne->id_role ;
				$id_statut = $ligne->id_statut ;
				$role = $ligne->nom_role ;
				$statut = $ligne->nom_statut ; 
				$annee_promo = $ligne->annee_promo ;
				$mail = $ligne->mail ;
				$date_inscription=$ligne->date_inscription;
				$date_maj_profil=$ligne->date_maj_profil;
			
			$prenom = ucfirst(strtolower($prenom));
			$nom = ucfirst(strtolower($nom));
			

				if ($id_role == 1 && $id_statut == 1)
		{
		
		affichetitre ("$nom $prenom","3");
		echo "<p>Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";
		
		$req_statut1="SELECT *
				FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp
				WHERE u.id = pu.id_utilisateur
				AND u.id = eu.id_utilisateur
				AND p.id = pu.id_poste
				AND p.id = pde.id_poste
				AND e.id = eu.id_entreprise
				AND e.id = pde.id_entreprise
				AND e.id = ev.id_entreprise
				AND vi.id = ev.id_entreprise
				AND vi.id = vp.id_ville
				AND pa.id = vp.id_pays
				AND nom='$nom' AND prenom='$prenom'";
		
		$res_statut1 = mysql_query($req_statut1) ;
		
		if (mysql_num_rows($res_statut1) > 0) {
				
		$ligne=mysql_fetch_object($res_statut1) ; 	
			$poste = $ligne->nom_poste ;
			$nom_entreprise = $ligne->nom_entreprise ;
			$siteweb_entreprise = $ligne->siteweb_entreprise ;
			$secteur_entreprise = $ligne->secteur_entreprise ;
			$nom_ville = $ligne->nom_ville ; 
			$cp = $ligne->cp ;
			$pays = $ligne->nom_pays ;
		
		echo "<p>$role : $statut <br/><br/>
			Poste : $nom_poste <br/>
			Entreprise : $nom_entreprise <br/>
			Adresse web de l'entreprise : $siteweb_entreprise <br/>
			Secteur de l'entreprise : $secteur_entreprise <br/>
			$nom_ville - $cp - $pays </p>";
			
			}
			
			echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		} 
		
		elseif ($id_role == 1 && $id_statut == 2) {
		
		affichetitre ("$nom $prenom","3");
		echo "<p>Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";
		
		$req_statut2 = "SELECT * 
				FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
				WHERE u.id = eu.id_utilisateur
				AND u.id = etau.id_utilisateur
				AND e.id = eu.id_etudes
				AND eta.id = etau.id_etablissement
				AND v.id = vp.id_ville
				AND v.id = etav.id_ville
				AND p.id = vp.id_pays
				AND nom='$nom' AND prenom='$prenom'" ;
				
		$res_statut2 = mysql_query($req_statut2) ;
		
		if (mysql_num_rows($res_statut2) > 0) {

		$ligne=mysql_fetch_object($res_statut2) ; 	
			$diplome = $ligne->diplome_etudes ;
			$nom_etablissement = $ligne->nom_etablissement ;
			$siteweb_etablissement = $ligne->siteweb_etablissement ;
			$nom_ville = $ligne->nom_ville ; 
			$cp = $ligne->cp ;
			$pays = $ligne->nom_pays ;
		
		
		echo "<p>$role : $statut <br/><br/>
			Diplôme : $diplome <br/>
			Etablissement : $nom_etablissement <br/>
			Adresse web de l'établissement : $siteweb_etablissement <br/>
			$nom_ville - $cp - $pays </p>";
			
			}
			
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		}
		
		elseif ($id_role == 1 && $id_statut == 3) {
		
		affichetitre ("$nom $prenom","3");
		echo "<p>Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";
		
		echo "<p>$statut</p>";
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		} 
		

	elseif ($id_role == 2)
			{ 
		
		affichetitre ("$nom $prenom","3");
		echo "<p>Année de la promotion : $annee_promo <br/>
		Adresse mail : $mail <br/></p>";
		
		$req_statut2 = "SELECT * 
				FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
				WHERE u.id = eu.id_utilisateur
				AND u.id = etau.id_utilisateur
				AND e.id = eu.id_etudes
				AND eta.id = etau.id_etablissement
				AND v.id = vp.id_ville
				AND v.id = etav.id_ville
				AND p.id = vp.id_pays
				AND nom='$nom' AND prenom='$prenom'" ;
				
		$res_statut2 = mysql_query($req_statut2) ;
		
		if (mysql_num_rows($res_statut2) > 0) {

		$ligne=mysql_fetch_object($res_statut2) ; 	
			$diplome = $ligne->diplome_etudes ;
			$nom_etablissement = $ligne->nom_etablissement ;
			$siteweb_etablissement = $ligne->siteweb_etablissement ;
			$nom_ville = $ligne->nom_ville ; 
			$cp = $ligne->cp ;
			$pays = $ligne->nom_pays ;
		
		
		echo "<p>$role<br/><br/>
			Diplôme : $diplome <br/>
			Etablissement : $nom_etablissement <br/>
			Adresse web de l'établissement : $siteweb_etablissement <br/>
			$nom_ville - $cp - $pays </p>";
			
			}
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
			}
			
			
		
		
		elseif ($id_role == 3)
		{
		affichetitre ("$nom $prenom","3");
		echo "<p>$role <br/>
		Adresse mail : $mail <br/></p>";
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		}
		
		
		elseif ($id_role == 4)
		{ 
		affichetitre ("$nom $prenom","3");
		echo "<p>$role <br/>
		Adresse mail : $mail <br/></p>";
		
		echo "<p>Date d'inscription : $date_inscription <br/>
		Date de mise à jour du profil : $date_maj_profil</p>";
		
		} 
		}
		echo "<p><a href=\"pageAccueil.php\">Retour à la page d'accueil de l'annuaire</a></p>";	
	
		} 

		elseif(isset($_POST['envoyer'])) {
		$annee_promo = stripslashes($_POST['annee_promo']);
		
		debuthtml("Annuaire M2 DEFI - Recherche", "Annuaire M2 DEFI", "Recherche");
		affichetitre ("Résultat de votre recherche","2") ;
	
		echo"<table border=\"1px\">
			<th colspan=5 >Promotion</th>
			<tr>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Contact</td>
			<td>Statut</td>
			<td>Situation actuelle</td>
			</tr>";
			
	$res_p = mysql_query("SELECT *			
					FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
					WHERE u.id = ru.id_utilisateur
					AND u.id = sa.id_utilisateur
					AND r.id = ru.id_role
					AND s.id = sa.id_statut
					AND annee_promo = '$annee_promo'");
					

while ($ligne = mysql_fetch_object($res_p)) {
						
						echo"<th colspan=5>$ligne->annee_promo</th>";
						echo "<tr>";
						echo "<td>$ligne->nom</td>";
						echo "<td>$ligne->prenom</td>";
						echo "<td>$ligne->mail </td>";
						echo "<td>$ligne->nom_role</td>";
							
						
						if ($ligne->id_role ==1 && $ligne->id_statut==1)
								{
								echo "<td>$ligne->nom_statut</td>";
								
								$req_statut1="SELECT *
								FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp
								WHERE u.id = pu.id_utilisateur
								AND u.id = eu.id_utilisateur
								AND p.id = pu.id_poste
								AND p.id = pde.id_poste
								AND e.id = eu.id_entreprise
								AND e.id = pde.id_entreprise
								AND e.id = ev.id_entreprise
								AND vi.id = ev.id_entreprise
								AND vi.id = vp.id_ville
								AND pa.id = vp.id_pays
								AND annee_promo='$annee_promo'";
		
								$res_statut1 = mysql_query($req_statut1) ;
								
									while ($ligne = mysql_fetch_object($res_statut1)){
								
											echo "<td>$ligne->nom_poste<br/>";
											echo"$ligne->nom_entreprise<br/>";
											echo"$ligne->siteweb_entreprise<br/>";
											echo"$ligne->secteur_entreprise<br/>";
											echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
								
								} }
								
								
							elseif ($ligne->id_role == 1 && $ligne->id_statut==2)
								{
								echo "<td>$ligne->nom_statut</td>";
								
								$req_statut2 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
								WHERE u.id = eu.id_utilisateur
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND annee_promo='$annee_promo'" ;
								
								$res_statut2 = mysql_query($req_statut2) ;
								
									while ($ligne = mysql_fetch_object($res_statut2)) {
								
								echo "<td>$ligne->diplome_etudes<br/>";
								echo "$ligne->nom_etablissement<br/>";
								echo "$ligne->siteweb_etablissement<br/>";
								echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
								} }
							
							
							
							elseif ($ligne->id_role== 1 && $ligne->id_statut==3)
								{
								echo "<td>$ligne->nom_statut</td>";
								}
							
						if ($ligne->id_role == 2)
							{
							
							$req_statut2 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
								WHERE u.id = eu.id_utilisateur
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND annee_promo='$annee_promo'" ;
								
								$res_statut2 = mysql_query($req_statut2) ;
								
									while ($ligne = mysql_fetch_object($res_statut2)) {
								
								echo "<td>$ligne->diplome_etudes<br/>";
								echo "$ligne->nom_etablissement<br/>";
								echo "$ligne->siteweb_etablissement<br/>";
								echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
							} }




						
						echo "</tr>";
					 } 

	  echo "</table>";	
	  echo "<p><a href=\"recherche.php\">Retour à la page de recherche de l'annuaire</a></p>";
	
	  
		}
		
		
		
		
		
		
		echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
		finhtml();
		
		mysql_close();

	?>