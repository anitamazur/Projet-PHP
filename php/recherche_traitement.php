<?php
 session_start();
 
 require("fonctions.php");
 $connexion = connexion();
 
## Traitement de recherche par nom et prénom ##

 
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
            AND u.nom='$nom' AND u.prenom='$prenom' " ;

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
                $mail_pro = $ligne->mail_pro ;
                $date_inscription=$ligne->date_inscription;
                $date_maj_profil=$ligne->date_maj_profil;
            
            $prenom = ucfirst(strtolower($prenom));
            $nom = ucfirst(strtolower($nom));

            
## si l'utilisateur est : ancien étudiant 
    if ($id_role == 1)
    {
        affichetitre ("$nom $prenom","3");
        echo "<p>Année de la promotion : $annee_promo <br/>
        Adresse mail personelle : $mail <br/>
        Adresse mail professionnelle : $mail_pro</p>";
        echo "<p>$statut</p>"
    
                ## en poste ##
                if ($id_statut == 2)
                {
        
                    $req_statut2="SELECT *
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
                            AND u.nom='$nom' AND u.prenom='$prenom'";
                    
                    $res_statut2 = mysql_query($req_statut2) ;
                    
                    while ($ligne = mysql_fetch_object($res_statut2)){
                            
                            echo "$ligne->nom_poste<br/>";
                            echo"$ligne->nom_entreprise<br/>";
                            echo"$ligne->siteweb_entreprise<br/>";
                            echo"$ligne->secteur_entreprise<br/>";
                            echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays";
                        
                        }
                } 
    
                ## en formation ##
                elseif ($id_statut == 3) 
                    {       
                        $req_statut3 = "SELECT * 
                                FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
                                WHERE u.id = eu.id_utilisateur
                                AND u.id = etau.id_utilisateur
                                AND e.id = eu.id_etudes
                                AND eta.id = etau.id_etablissement
                                AND eta.id = etav.id_etablissement
                                AND v.id = vp.id_ville
                                AND v.id = etav.id_ville
                                AND p.id = vp.id_pays
                                AND u.nom='$nom' AND u.prenom='$prenom'" ;
                                
                        $res_statut3 = mysql_query($req_statut3) ;
                        
                        while ($ligne = mysql_fetch_object($res_statut3)) {
                                                
                                echo "$ligne->diplome_etudes<br/>";
                                echo "$ligne->nom_etablissement<br/>";
                                echo "$ligne->siteweb_etablissement<br/>";
                                echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays";
                            
                            }
                }
    
                ## Profil à remplir ou recherche d'emploi ## --> rien à afficher
    
        echo "<p>Date d'inscription : $date_inscription <br/>
        Date de mise à jour du profil : $date_maj_profil</p>";  
}

 ## si etudiant actuel ##
    elseif ($id_role == 2)
            { 
        
        affichetitre ("$nom $prenom","3");
        echo "<p>$role<br/>
        Année de la promotion : $annee_promo <br/>
        Adresse mail : $mail <br/></p>";
        
    #   $req_statut2 = "SELECT * 
    #           FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
    #           WHERE u.id = eu.id_utilisateur
    #           AND u.id = etau.id_utilisateur
    #           AND e.id = eu.id_etudes
    #           AND eta.id = etau.id_etablissement
    #           AND eta.id = etav.id_etablissement
    #           AND v.id = vp.id_ville
    #           AND v.id = etav.id_ville
    #           AND p.id = vp.id_pays
    #           AND u.nom='$nom' AND u.prenom='$prenom'" ;
        
    #   $res_statut2 = mysql_query($req_statut2) ;
                                
    #       while ($ligne = mysql_fetch_object($res_statut2)) {
                                
    #           echo "<td>$ligne->diplome_etudes<br/>";
    #           echo "$ligne->nom_etablissement<br/>";
    #           echo "$ligne->siteweb_etablissement<br/>";
    #           echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
        
        
    #   echo "<p>$role<br/><br/>
    #       Diplôme : $diplome <br/>
    #       Etablissement : $nom_etablissement <br/>
    #       Adresse web de l'établissement : $siteweb_etablissement <br/>
    #       $nom_ville - $cp - $pays </p>";
            
    #       }
        echo "<p>Date d'inscription : $date_inscription <br/>
        Date de mise à jour du profil : $date_maj_profil</p>";
            }
            
            
        
        
        elseif ($id_role == 3 or $id_role == 4)
        {
        affichetitre ("$nom $prenom","3");
        echo "<p>$role <br/>
        Adresse mail : $mail</p>";
        
        echo "<p>Date d'inscription : $date_inscription <br/>
        Date de mise à jour du profil : $date_maj_profil</p>";
        }
        
        }
        echo "<p><a href=\"pageAccueil.php\">Retour à la page d'accueil de l'annuaire</a></p>"; 
    
        } 


## Traitement de recherche par année de promotion ##        
        
        
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
                    AND u.annee_promo = '$annee_promo'");
                    

while ($ligne = mysql_fetch_object($res_p)) {
                        $id_role=$ligne->id_role;
                        $id_statut=$ligne->id_statut;
                        
                        echo"<th colspan=5>$ligne->annee_promo</th>";
                        echo "<tr>";
                        echo "<td>$ligne->nom</td>";
                        echo "<td>$ligne->prenom</td>";
                        echo "<td>$ligne->mail<br/>";
                        echo "$ligne->mail_pro</td>";
                        echo "<td>$ligne->nom_role</td>";
                            
                        ## si ancien etudiant ##
                        if ($id_role ==1 )
                        {
                         # si en poste ##
                            if ($id_statut==2)
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
                                AND u.annee_promo='$annee_promo'";
        
                                $res_statut1 = mysql_query($req_statut1) ;
                                
                                    while ($ligne = mysql_fetch_object($res_statut1)){
                                
                                            echo "<td>$ligne->nom_poste<br/>";
                                            echo"$ligne->nom_entreprise<br/>";
                                            echo"$ligne->siteweb_entreprise<br/>";
                                            echo"$ligne->secteur_entreprise<br/>";
                                            echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
                                
                                } }
                                
                            ## si en formation ##   
                            elseif ($id_statut==3)
                                {
                                echo "<td>$ligne->nom_statut</td>";
                                
                                $req_statut2 = "SELECT * 
                                FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
                                WHERE u.id = eu.id_utilisateur
                                AND u.id = etau.id_utilisateur
                                AND e.id = eu.id_etudes
                                AND eta.id = etau.id_etablissement
                                AND eta.id = etav.id_etablissement
                                AND v.id = vp.id_ville
                                AND v.id = etav.id_ville
                                AND p.id = vp.id_pays
                                AND u.annee_promo='$annee_promo'" ;
                                
                                $res_statut2 = mysql_query($req_statut2) ;
                                
                                    while ($ligne = mysql_fetch_object($res_statut2)) {
                                
                                echo "<td>$ligne->diplome_etudes<br/>";
                                echo "$ligne->nom_etablissement<br/>";
                                echo "$ligne->siteweb_etablissement<br/>";
                                echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
                                } }
                            
                            
                            ##si profil à remplir ou en recherche d'emploi##
                            elseif ($id_statut==1 or $id_statut ==4)
                                {
                                echo "<td>$ligne->nom_statut</td>";
                                echo "<td> - </td>";
                                }
                            }
                            
                        ## si étudiant actuel ##    
                        elseif ($id_role == 2)
                                {
                                echo "<td>$ligne->nom_statut</td>";
                                echo "<td> - </td>";
                            #   $req_statut2 = "SELECT * 
                            #   FROM utilisateur AS u, etudes AS e, etudes_utilisateur AS eu, etablissement AS eta, etablissement_utilisateur AS etau, ville AS v, pays AS p, ville_pays AS vp, etablissement_ville AS etav
                            #   WHERE u.id = eu.id_utilisateur
                            #   AND u.id = etau.id_utilisateur
                            #   AND e.id = eu.id_etudes
                            #   AND eta.id = etau.id_etablissement
                            #   AND v.id = vp.id_ville
                            #   AND v.id = etav.id_ville
                            #   AND p.id = vp.id_pays
                            #   AND u.annee_promo='$annee_promo'" ;
                                
                            #   $res_statut2 = mysql_query($req_statut2) ;
                                
                            #       while ($ligne = mysql_fetch_object($res_statut2)) {
                                
                            #   echo "<td>$ligne->diplome_etudes<br/>";
                            #   echo "$ligne->nom_etablissement<br/>";
                            #   echo "$ligne->siteweb_etablissement<br/>";
                            #   echo"$ligne->nom_ville $ligne->cp $ligne->nom_pays</td>";
                            #   } 
                                        
                                }




                        
                        echo "</tr>";
                     } 

      echo "</table>";  
      echo "<p><a href=\"recherche.php\">Retour à la page de recherche de l'annuaire</a></p>";
    
      
        }
        
        
        
        
        
        
        echo "<p>Si vous rencontrez des problèmes n'hésitez pas à <a href=\"mailto:admin@annuairedefi.u-paris10.fr\">contacter l'administrateur</a></p>";
        finhtml();
        
        mysql_close();

    ?>