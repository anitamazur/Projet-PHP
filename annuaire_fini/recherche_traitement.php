<?php
 session_start();
 
if (isset($_SESSION['nom'])) {
	$nom = $_SESSION['nom'];
	$prenom = $_SESSION['prenom'];
	$naissance = $_SESSION['naissance'];
	$mail = $_SESSION['mail'] ;
	#$annee_promo = $_SESSION['annee_promo'];
	$id_role = $_SESSION['id_role'];
	$id_statut = $_SESSION['id_statut'];
} else {
	$id_role = "";
}
 
require_once("fonctions.php");
$connexion = connexion();
 
 
##################################### Traitement de recherche par nom et prénom #########################################

 
if(isset($_POST['valider'])) {
	$cherche_nom = stripslashes($_POST['nom']);
	$cherche_prenom = stripslashes($_POST['prenom']);
    
    debuthtml("Annuaire M2 DEFI - Recherche", "Annuaire M2 DEFI", "Recherche",$id_role);
    affichetitre ("Résultat de votre recherche","2") ;
    
	$req = "SELECT * 
	FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
	WHERE u.id = ru.id_utilisateur
	AND r.id = ru.id_role AND sa.id_utilisateur = u.id AND sa.id_statut = s.id
	AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom' " ;
	
	$res = mysql_query($req) ;
	
	if(mysql_num_rows($res) > 0){
		
		$ligne=mysql_fetch_object($res) ;
		$cherche_id = $ligne->id ;
		$cherche_id_role = $ligne->id_role ;
		#$cherche_id_statut = $ligne->id_statut ;
		$cherche_role = $ligne->nom_role ;
		#$cherche_statut = $ligne->nom_statut ; 
		$cherche_annee_promo = $ligne->annee_promo ;
		$cherche_mail = $ligne->mail ;
		$cherche_mail_pro = $ligne->mail_pro ;
		$cherche_nom_niveau = $ligne->nom_niveau ;
		$cherche_prenom_niveau = $ligne->prenom_niveau ;
		$cherche_mail_niveau = $ligne->mail_niveau ;
		$cherche_mailPro_niveau = $ligne->mailPro_niveau ;
		$cherche_date_inscription=$ligne->date_inscription;
		$cherche_date_maj_profil=$ligne->date_maj_profil;

		## si l'utilisateur connecté est : enseignant ou admin ##
		if ($id_role == 3 or $id_role == 4) {   
				
			## si l'utilisateur est : ancien étudiant 
			if ($cherche_id_role == 1) { 

					affichetitre ("$cherche_nom $cherche_prenom","3");
					echo "<p>Année de la promotion : $cherche_annee_promo <br/>
					Adresse mail personelle : $cherche_mail <br/>
					Adresse mail professionnelle : $cherche_mail_pro</p>";	
					
				$res_statut = mysql_query ("SELECT * 
										FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
											WHERE u.id = ru.id_utilisateur
											AND u.id = sa.id_utilisateur
											AND r.id = ru.id_role
											AND s.id = sa.id_statut
											AND ru.id_role = '$cherche_id_role' AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom';");
				
				if(mysql_num_rows($res_statut) > 0) {
					$ligne=mysql_fetch_object($res_statut) ;
					$cherche_id_statut= $ligne->id_statut ;
					$cherche_statut= $ligne->nom_statut ;	
			
					
					echo "<p>$cherche_statut</p>";
		
					## en poste ##
					if ($cherche_id_statut == 2) {
						$req_statut2="SELECT *
								FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = pu.id_utilisateur
								AND u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND p.id = pu.id_poste
								AND p.id = pde.id_poste
								AND e.id = eu.id_entreprise
								AND e.id = pde.id_entreprise
								AND e.id = ev.id_entreprise
								AND vi.id = ev.id_entreprise
								AND vi.id = vp.id_ville
								AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom' 
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'";
						
						$res_statut2 = mysql_query($req_statut2) ;
						
						if (mysql_num_rows($res_statut2) > 0) {
							
									$ligne=mysql_fetch_object($res_statut2) ;
						#while ($ligne = mysql_fetch_object($res_statut2)){
								
								echo "$ligne->nom_poste<br/>";
								echo"$ligne->nom_entreprise<br/>";
								echo"$ligne->siteweb_entreprise<br/>";
								echo"$ligne->secteur_entreprise<br/>";
								echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays";
						}
					} elseif ($cherche_id_statut == 3) { ## en formation ##       
							$req_statut3 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom'
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'" ;
									
							$res_statut3 = mysql_query($req_statut3) ;
							
							if (mysql_num_rows($res_statut3) > 0) {
							
									$ligne=mysql_fetch_object($res_statut3) ;
							#while ($ligne = mysql_fetch_object($res_statut3)) {
													
									echo "$ligne->diplome_etudes<br/>";
									echo "$ligne->nom_etablissement<br/>";
									echo "$ligne->siteweb_etablissement<br/>";
									echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays";
							}
					} 
		
					## Profil à remplir ou recherche d'emploi ## --> rien à afficher
		
				echo "<p>Date d'inscription : $cherche_date_inscription <br/>
				Date de mise à jour du profil : $cherche_date_maj_profil</p>";  
				}
			}
	 
		} elseif ($id_role == 1 or $id_role == 2) {## si l'utilisateur connecté est : ancien étudiant ou étudiant actuel ##
			# si l'utilisateur est : ancien étudiant 
			if ($cherche_id_role == 1) {     
				## condition sur le nom et le prénom ##
				if ($cherche_nom_niveau == 'public' && $cherche_prenom_niveau == 'public') {
					affichetitre ("$cherche_nom $cherche_prenom","3");
				} else {
					affichetitre ("Ancien étudiant","3");
				}
				
				echo "Année de la promotion : $cherche_annee_promo<br/>";
			
				## condition sur le mail perso
				if ($cherche_mail_niveau == 'public') {
					echo "Adresse mail personelle : $cherche_mail <br/>";    
				} else {
					echo " ";
				}
				
		
				## condition sur le mail pro
				if ($cherche_mailPro_niveau == 'public') {
					echo "Adresse mail professionnelle : $cherche_mail_pro <br/>";
				} else {
					echo " ";
				}

				$res_statut = mysql_query ("SELECT * 
										FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa 
											WHERE u.id = ru.id_utilisateur
											AND u.id = sa.id_utilisateur
											AND r.id = ru.id_role
											AND s.id = sa.id_statut
											AND ru.id_role = '$cherche_id_role' 
											AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom';");
				
				if(mysql_num_rows($res_statut) > 0) {
					$ligne=mysql_fetch_object($res_statut) ;
					$cherche_id_statut= $ligne->id_statut ;
					$cherche_statut= $ligne->nom_statut ;
			
					echo "<p>$cherche_statut</p>";
		
					## en poste ##
					if ($cherche_id_statut == 2) {
			
						$req_statut2="SELECT *
								FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = pu.id_utilisateur
								AND u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND p.id = pu.id_poste
								AND p.id = pde.id_poste
								AND e.id = eu.id_entreprise
								AND e.id = pde.id_entreprise
								AND e.id = ev.id_entreprise
								AND vi.id = ev.id_entreprise
								AND vi.id = vp.id_ville
								AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom'
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'";
						
						$res_statut2 = mysql_query($req_statut2) ;
						
						if(mysql_num_rows($res_statut2) > 0) {
						$ligne=mysql_fetch_object($res_statut2) ;
						#while ($ligne = mysql_fetch_object($res_statut2)){
								$cherche_nomPoste_niveau=$ligne->nomPoste_niveau;
								$cherche_nomEntreprise_niveau=$ligne->nomEntreprise_niveau;
								$cherche_sitewebEntreprise_niveau=$ligne->sitewebEntreprise_niveau;
								$cherche_secteurEntreprise_niveau=$ligne->secteurEntreprise_niveau;
								$cherche_nomVille_niveau=$ligne->nomVille_niveau;
								$cherche_cp_niveau=$ligne->cp_niveau;
								$cherche_nomPays_niveau=$ligne->nomPays_niveau;
						
							## condition sur le poste
							if ($cherche_nomPoste_niveau == 'public') {
								echo "$ligne->nom_poste<br/>";
							} else {
								echo " ";
							}
									
							## condition sur le nom de l'entreprise
							if ($cherche_nomEntreprise_niveau == 'public') {
								echo "$ligne->nom_entreprise<br/>";
							} else {
								echo " ";
							}

							## condition sur le siteweb de l'entreprise
							if ($cherche_sitewebEntreprise_niveau == 'public') {
								echo "$ligne->siteweb_entreprise<br/>";
							} else {
								echo " ";
							}
									
							## condition sur le secteur de l'entreprise
							if ($cherche_secteurEntreprise_niveau == 'public') {
								echo "$ligne->secteur_entreprise<br/>";
							} else {
								echo " ";
							}
							
							## condition sur le nom de la ville de l'entreprise
							if ($cherche_nomVille_niveau == 'public') {
								echo "$ligne->nom_ville ";
							} else {
								echo " ";
							}
						
							## condition sur le code postal de l'entreprise
							if ($cherche_cp_niveau == 'public') {
								echo "$ligne->cp<br/>"; 
							} else {
								echo " ";
							}
						
							## condition sur le pays de l'entreprise
							if ($cherche_nomPays_niveau == 'public') {
								echo "$ligne->nom_pays<br/>"; 
							} else {
								echo " ";
							}
							
						}
					} elseif ($cherche_id_statut == 3) {## en formation ##
											
						$req_statut3 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND u.nom='$cherche_nom' AND u.prenom='$cherche_prenom'
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'" ;
								
						$res_statut3 = mysql_query($req_statut3) ;
						
						if(mysql_num_rows($res_statut3) > 0) {
						$ligne=mysql_fetch_object($res_statut3) ;
						#while ($ligne = mysql_fetch_object($res_statut3)) {
								$cherche_diplomeEtudes_niveau=$ligne->diplomeEtudes_niveau;
								$cherche_nomEtablissement_niveau=$ligne->nomEtablissement_niveau;
								$cherche_sitewebEtablissement_niveau=$ligne->sitewebEtablissement_niveau;
								$cherche_nomVille_niveau=$ligne->nomVille_niveau;
								$cherche_cp_niveau=$ligne->cp_niveau;
								$cherche_nomPays_niveau=$ligne->nomPays_niveau;
									
										## condition sur le diplôme
									if ($cherche_diplomeEtudes_niveau == 'public') {
										echo "$ligne->diplome_etudes<br/>";
									} else {
										echo " ";
									}
									
									## condition sur le nom de l'établissement
									if ($cherche_nomEtablissement_niveau == 'public')
									{
									echo "$ligne->nom_etablissement<br/>";
									}
									else {echo " ";}

									## condition sur le siteweb de l'établissement
									if ($cherche_sitewebEtablissement_niveau == 'public')
									{
									echo "$ligne->siteweb_etablissement<br/>";
									}
									else {echo " ";}
									
									## condition sur le nom de la ville de l'établissement
									if ($cherche_nomVille_niveau == 'public')
									{
									echo "$ligne->nom_ville ";
									}
									else {echo " ";}
								
									## condition sur le code postal de l'établissement
									if ($cherche_cp_niveau == 'public')
									{
									echo "$ligne->cp<br/>";
									}
									else {echo " ";}
								
									## condition sur le pays de l'établissement
									if ($cherche_nomPays_niveau == 'public')
									{
									echo "$ligne->nom_pays<br/>";
									}
									else {echo " ";}
									
								
								}
						}
		
					## Profil à remplir ou recherche d'emploi ## --> rien à afficher
		
				echo "<p>Date d'inscription : $cherche_date_inscription <br/>
			Date de mise à jour du profil : $cherche_date_maj_profil</p>";  
				} 
			}

	 
			
        }   
	} 
}

################################## Traitement de recherche par année de promotion ########################################  
        
        
        elseif(isset($_POST['envoyer'])) {
            $cherche_annee_promo = stripslashes($_POST['annee_promo']);
        
        debuthtml("Annuaire M2 DEFI - Recherche", "Annuaire M2 DEFI", "Recherche",$id_role);
        affichetitre ("Résultat de votre recherche","2") ;
    
        echo"<table border=\"1px\">
            <th colspan=\"6\" >Promotion</th>
            <tr>
            <td>Nom</td>
            <td>Prénom</td>
            <td>Contact</td>
            <td>Statut</td>
            <td>Situation actuelle</td>
            <td>Informations</td>
            </tr>
            <th colspan=\"6\">$cherche_annee_promo</th>
            <tr>";
            
    $res_p = mysql_query("SELECT *
							FROM utilisateur AS u, role AS r, roles_utilisateur AS ru, statut AS s, statut_ancien_etudiant AS sa
							WHERE u.id = ru.id_utilisateur
							AND u.id = sa.id_utilisateur
							AND r.id = ru.id_role
							AND s.id = sa.id_statut
							AND u.annee_promo = '$cherche_annee_promo' and ru.id_role = 1");
                    

while ($ligne = mysql_fetch_object($res_p)) {
                        $cherche_id_role=$ligne->id_role;
                        $cherche_id_statut=$ligne->id_statut;
                        $cherche_nom_niveau = $ligne->nom_niveau ;
                        $cherche_prenom_niveau = $ligne->prenom_niveau ;
                        $cherche_mail_niveau = $ligne->mail_niveau ;
                        $cherche_mailPro_niveau = $ligne->mailPro_niveau ;

## si l'utilisateur connecté est : enseignant ou admin ##                       
if ($id_role == 3 or $id_role == 4)
    {	
	
                        echo "<td>$ligne->nom</td>";
                        echo "<td>$ligne->prenom</td>";
                        echo "<td>$ligne->mail<br/>$ligne->mail_pro</td>";
                       
                       #echo "<td>$ligne->nom_role</td>";
                       
					
                        ## si ancien etudiant ##
                        if ($cherche_id_role ==1 )
                        {

                         # si en poste ##
                            if ($cherche_id_statut==2)
                                {
                               echo "<td>$ligne->nom_statut</td>";
                                
                                $req_statut2="SELECT *
								FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = pu.id_utilisateur
								AND u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND p.id = pu.id_poste
								AND p.id = pde.id_poste
								AND e.id = eu.id_entreprise
								AND e.id = pde.id_entreprise
								AND e.id = ev.id_entreprise
								AND vi.id = ev.id_entreprise
								AND vi.id = vp.id_ville
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'
                                AND u.annee_promo='$cherche_annee_promo'";
        
                                $res_statut2 = mysql_query($req_statut2) ;
                                
									if (mysql_num_rows($res_statut2) > 0) {
							
									$ligne=mysql_fetch_object($res_statut2) ;
                                 #   while ($ligne = mysql_fetch_object($res_statut2)){
											$cherche_poste = $ligne->nom_poste;
											$cherche_nom_entreprise =$ligne->nom_entreprise;
											$cherche_siteweb_entreprise = $ligne->siteweb_entreprise;
											$cherche_secteur_entreprise =$ligne->secteur_entreprise;
											$cherche_ville = $ligne->nom_ville;
											$cherche_cp =$ligne->cp;
											$cherche_pays =$ligne->nom_pays;
											
											if ($cherche_poste!="")
											{
                                            echo "<td>$cherche_poste<br/>";
											}
											if($cherche_nom_entreprise!="")
											{
                                            echo"$cherche_nom_entreprise<br/>";
											}
											if ($cherche_siteweb_entreprise!="")
											{
                                            echo"$cherche_siteweb_entreprise<br/>";
											}
											if ($cherche_secteur_entreprise!="")
											{
                                            echo"$cherche_secteur_entreprise<br/>";
											}
											if ($cherche_ville !="" or $cherche_cp!="" or $cherche_pays!="")
											{
                                            echo"$cherche_ville $cherche_cp $cherche_pays</td>";
											}
								
                                } 
								else {echo"<td> - </td>";)
								}
                                
                            ## si en formation ##   
                            elseif ($cherche_id_statut==3)
                                {
                            echo "<td>$ligne->nom_statut</td>";
							
                                $req_statut3 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'
                                AND u.annee_promo='$cherche_annee_promo'" ;
                                
                                $res_statut3 = mysql_query($req_statut3) ;
                                
							#	if (mysql_num_rows($res_statut3) > 0) {
							
							#	$ligne=mysql_fetch_object($res_statut3) ;
								
                                    while ($ligne = mysql_fetch_object($res_statut3)) {
									
								$cherche_diplome = $ligne->diplome_etudes;
								$cherche_nom_etablissement =$ligne->nom_etablissement;
								$cherche_siteweb_etablissement =$ligne->siteweb_etablissement;
								$cherche_ville = $ligne->nom_ville;
								$cherche_cp =$ligne->cp;
								$cherche_pays =$ligne->nom_pays;
								
								if ($cherche_diplome!="")
											{
                                            echo "<td>$cherche_diplome<br/>";
											}
											if($cherche_nom_etablissement!="")
											{
                                            echo"$cherche_nom_etablissement<br/>";
											}
											if ($cherche_siteweb_etablissement!="")
											{
                                            echo"$cherche_siteweb_etablissement<br/>";
											}
											if ($cherche_secteur_etablissement!="")
											{
                                            echo"$cherche_secteur_etablissement<br/>";
											}
											if ($cherche_ville !="" or $cherche_cp!="" or $cherche_pays!="")
											{
                                            echo"$cherche_ville $cherche_cp $cherche_pays</td>";
											}
                               
                                }
							else {echo"<td> - </td>";)
								}
                            
                            
                            ##si profil à remplir ou en recherche d'emploi##
                            elseif ($cherche_id_statut==1 or $cherche_id_statut ==4)
                                {
                               echo "<td>$ligne->nom_statut</td>";
                                echo "<td> - </td>";
                                }
                            } }
                            
                       
                     

if ($id_role == 1 or $id_role == 2 or connexionUtilisateurReussie() == false) 
    {

                        
                        #condition sur le nom et prénom
                        if ($cherche_nom_niveau == 'public' && $cherche_prenom_niveau == 'public')
                        {
                        echo "<td>$ligne->nom</td>";
                        echo "<td>$ligne->prenom</td>";
                        }
                        else {
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                    
                        #condition sur le mail perso
                        if ($cherche_mail_niveau == 'public')
                        {
                        echo "<td>$ligne->mail<br/>";
                        }
                        else {
                            echo "<td>-<br/>";
                        }
                        
            
                    #    echo "<td>$ligne->nom_role</td>";
					
						
						 
                        ## si ancien etudiant ##
                        if ($cherche_id_role ==1 )
                        {
						
									
                         # si en poste ##
                            if ($cherche_id_statut==2)
                                {
                                echo "<td>$ligne->nom_statut</td>";
                                
                                $req_statut2="SELECT *
								FROM utilisateur AS u, poste AS p, poste_utilisateur AS pu, poste_dans_entreprise AS pde, entreprise AS e, entreprise_utilisateur As eu, entreprise_ville AS ev, ville AS vi, pays AS pa, ville_pays AS vp AND statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = pu.id_utilisateur
								AND u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND p.id = pu.id_poste
								AND p.id = pde.id_poste
								AND e.id = eu.id_entreprise
								AND e.id = pde.id_entreprise
								AND e.id = ev.id_entreprise
								AND vi.id = ev.id_entreprise
								AND vi.id = vp.id_ville
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'
                                AND u.annee_promo='$cherche_annee_promo'";
								
								
                                $res_statut2 = mysql_query($req_statut2) ;
                                
								if (mysql_num_rows($res_statut2) > 0) {
							
									$ligne=mysql_fetch_object($res_statut2) ;
                                   
                        #           while ($ligne = mysql_fetch_object($res_statut2)){
                                   	
                                            $cherche_nomPoste_niveau=$ligne->nomPoste_niveau;
                                            $cherche_nomEntreprise_niveau=$ligne->nomEntreprise_niveau;
                                            $cherche_sitewebEntreprise_niveau=$ligne->sitewebEntreprise_niveau;
                                            $cherche_secteurEntreprise_niveau=$ligne->secteurEntreprise_niveau;
                                            $cherche_nomVille_niveau=$ligne->nomVille_niveau;
                                            $cherche_cp_niveau=$ligne->cp_niveau;
                                            $cherche_nomPays_niveau=$ligne->nomPays_niveau;
                                            
                                            #condition sur le mail pro
                                            if ($cherche_mailPro_niveau == 'public')
                                            {
                                               $cherche_mailPro = $ligne->mail_pro;
                                            }
                                            
                                            ## condition sur le poste
                                            if ($cherche_nomPoste_niveau == 'public')
                                            {
                                                $cherche_nom_poste = $ligne->nom_poste;
                                            }
                                            
                                            echo "<td>
                                                    <ul>
                                                        <li>Nom de poste : $cherche_nom_poste</li>
                                                        <li>$cherche_mailPro</li>
                                                    </ul>
                                                  </td>";
                                            
                                            ## condition sur le nom de l'entreprise
                                            if ($cherche_nomEntreprise_niveau == 'public')
                                            {
                                            echo"$ligne->nom_entreprise<br/>";
                                            }
                                            else {echo " ";}

                                            ## condition sur le siteweb de l'entreprise
                                            if ($cherche_sitewebEntreprise_niveau == 'public')
                                            {
                                            echo"$ligne->siteweb_entreprise<br/>";
                                            }
                                            else {echo " ";}
                                            
                                            ## condition sur le secteur de l'entreprise
                                            if ($cherche_secteurEntreprise_niveau == 'public')
                                            {
                                            echo"$ligne->secteur_entreprise<br/>";
                                            }
                                            else {echo " ";}
                                            
                                            ## condition sur le nom de la ville de l'entreprise
                                            if ($cherche_nomVille_niveau == 'public')
                                            {
                                            echo "$ligne->nom_ville<br/>";
                                            }
                                            else {echo " ";}
                                        
                                            ## condition sur le code postal de l'entreprise
                                            if ($cherche_cp_niveau == 'public')
                                            {
                                            echo "$ligne->cp<br/>";
                                            }
                                            else {echo " ";}
                                        
                                            ## condition sur le pays de l'entreprise
                                            if ($cherche_nomPays_niveau == 'public')
                                            {
                                            echo "$ligne->nom_pays</td>";
                                            }
                                            else {echo " ";}
                            
                                        } 
									else {echo"<td> - </td>";)	
										}
                                
                            ## si en formation ##   
                            elseif ($cherche_id_statut==3)
                                {
				echo "<td>$ligne->nom_statut</td>";
							
                                $req_statut3 = "SELECT * 
								FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav, statut_ancien_etudiant AS sa, statut AS s, roles_utilisateur AS ru, role AS r
								WHERE u.id = eu.id_utilisateur
								AND u.id = sa.id_utilisateur
								AND u.id = ru.id_utilisateur
								AND r.id = ru.id_role
								AND s.id = sa.id_statut
								AND u.id = etau.id_utilisateur
								AND e.id = eu.id_etudes
								AND eta.id = etau.id_etablissement
								AND eta.id = etav.id_etablissement
								AND v.id = vp.id_ville
								AND v.id = etav.id_ville
								AND p.id = vp.id_pays
								AND ru.id_role = '$cherche_id_role' AND sa.id_statut = '$cherche_id_statut'
                                AND u.annee_promo='$cherche_annee_promo'" ;
                                
                                $res_statut3 = mysql_query($req_statut3) ;
                                
								if (mysql_num_rows($res_statut3) > 0) {
							
									$ligne=mysql_fetch_object($res_statut3) ;
                         #            while ($ligne = mysql_fetch_object($res_statut3)) {
                                     	
                                            $cherche_diplomeEtudes_niveau=$ligne->diplomeEtudes_niveau;
                                            $cherche_nomEtablissement_niveau=$ligne->nomEtablissement_niveau;
                                            $cherche_sitewebEtablissement_niveau=$ligne->sitewebEtablissement_niveau;
                                            $cherche_nomVille_niveau=$ligne->nomVille_niveau;
                                            $cherche_cp_niveau=$ligne->cp_niveau;
                                            $cherche_nomPays_niveau=$ligne->nomPays_niveau;
                                            
                                                ## condition sur le diplôme
                                            if ($cherche_diplomeEtudes_niveau == 'public')
                                            {
                                            echo "<td>$ligne->diplome_etudes<br/>";
                                            }
                                            else {echo " ";}
                                            
                                            ## condition sur le nom de l'établissement
                                            if ($cherche_nomEtablissement_niveau == 'public')
                                            {
                                            echo "$ligne->nom_etablissement<br/>";
                                            }
                                            else {echo " ";}

                                            ## condition sur le siteweb de l'établissement
                                            if ($cherche_sitewebEtablissement_niveau == 'public')
                                            {
                                            echo "$ligne->siteweb_etablissement<br/>";
                                            }
                                            else {echo " ";}
                                            
                                            ## condition sur le nom de la ville de l'établissement
                                            if ($cherche_nomVille_niveau == 'public')
                                            {
                                            echo "$ligne->nom_ville<br/>";
                                            }
                                            else {echo " ";}
                                        
                                            ## condition sur le code postal de l'établissement
                                            if ($cherche_cp_niveau == 'public')
                                            {
                                            echo "$ligne->cp<br/>";
                                            }
                                            else {echo " ";}
                                        
                                            ## condition sur le pays de l'établissement
                                            if ($cherche_nomPays_niveau == 'public')
                                            {
                                            echo "$ligne->nom_pays</td>";
                                            }
                                            else {echo " ";}                                            
                            
                                }
							else {echo"<td> - </td>";)
								}
                            
                            
                            ##si profil à remplir ou en recherche d'emploi##
                            elseif ($cherche_id_statut==1 or $cherche_id_statut ==4)
                                {
			        echo "<td>$ligne->nom_statut</td>";
                                echo "<td> - </td>";
                                }
                            } }
                             echo "</tr>";
                       
                     } }
					 

      echo "</table>";
      

        echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
        finhtml();
        
        mysql_close();

    ?>
