<!--Navbar-->
    <?php
        include ('haut.php');

        if (!(isset($_SESSION['username'])))
        {
            header('location: index.php');
        }

        //var_dump($_SESSION['idUser']);
    ?>
<!--/.Navbar-->
<div style="margin-top:0px; width: 100%; height: 65px; background-color: black;"></div>

<form method="post" class="ml-3">

                    <h3 class="h3-responsive text-center mt-3 mb-3"><i class="fa fa-plus"></i>  Ajouter un lot</h3>

                 <div class="md-form">
                    <i class="fa fa-info prefix" style="left:0px;"></i>
                    <input type="text" id="desc" class="form-control" name="desc" placeholder="Description de votre lot" autocomplete="off" required>
                    
                </div>

                <div class="md-form">
               		<i class="fa fa-eur prefix" style="left:0px;"></i>
                    <input type="number" id="prixU" class="form-control" name="prixU" placeholder="Prix Unitaire" step=".01" min="0.01" max="999.99" autocomplete="off" required>
                    
                </div>

                <div class="md-form">
                    <i class="fa fa-underline prefix" style="left:0px;"></i>
                    <input type="text" id="unite" class="form-control" name="unite" placeholder="Unité" list="unites" autocomplete="off" required>
                    <datalist id="unites">
                        <?php 
                            global $cnx;  
    
                            $req="SELECT idUnite,libelleUnite FROM unite ;";

                            $result = mysqli_query($cnx, $req) or die("La requête a échoué : ".$cnx->error);

                            if($result->num_rows<1) die("La requête ne renvoie aucun résultat");

                            while ($ligne = $result->fetch_array(MYSQLI_ASSOC)) 
                            {
                                echo "<option value=\"".$ligne['libelleUnite']."\">".$ligne['libelleUnite']."</option>";
                            }
                        ?>
                    </datalist>
                </div>

                <div class="md-form">
     				<i class="fa fa-balance-scale prefix" style="left:0px;"></i>
                    <input type="number" id="qte" class="form-control" name="qte" placeholder="Quantité" min="0" autocomplete="off" required>
                    
                </div>

                  <div class="md-form">
               		<i class="fa fa-info prefix" style="left:0px;"></i>
                    <input type="text" id="rayon" class="form-control" name="rayon" placeholder="Entrer son rayon" list="rayons" autocomplete="off" required>
                    <datalist id="rayons">
                        <?php 
                            global $cnx;  
    
                            $req="SELECT idRayon,libelleRayon FROM rayon ;";

                            $result = mysqli_query($cnx, $req) or die("La requête a échoué : ".$cnx->error);

                            if($result->num_rows<1) die("La requête ne renvoie aucun résultat");

                            while ($ligne = $result->fetch_array(MYSQLI_ASSOC)) 
                            {
                                echo "<option value=\"".$ligne['libelleRayon']."\">".$ligne['libelleRayon']."</option>";
                            }
                        ?>
                    </datalist>
                  </div>

                  <div class="md-form">
                    <i class="fa fa-info prefix" style="left:0px;"></i>
                     <input type="text" id="produit" class="form-control" name="produit" placeholder="Entrer le produit" list="produits" autocomplete="off" required>
                      <datalist id="produits">
                        <?php 
                            global $cnx;  
    
                            $req="SELECT idProduit,libelleProduit FROM produit ;";

                            $result = mysqli_query($cnx, $req) or die("La requête a échoué : ".$cnx->error);

                            if($result->num_rows<1) die("La requête ne renvoie aucun résultat");

                            while ($ligne = $result->fetch_array(MYSQLI_ASSOC)) 
                            {
                                echo "<option value=\"".$ligne['libelleProduit']."\">".$ligne['libelleProduit']."</option>";
                            }
                        ?>
                    </datalist>
                   </div>

                   <div class="md-form">
                     <i class="fa fa-info prefix" style="left:0px;"></i>
                     <input type="text" id="variete" class="form-control" name="variete" placeholder="Entrer sa variété" list="varietes" autocomplete="off" required>
                     <datalist id="varietes">
                        <?php 
                            global $cnx;  
    
                            $req="SELECT idVariete,libelleVariete FROM variete ;";

                            $result = mysqli_query($cnx, $req) or die("La requête a échoué : ".$cnx->error);

                            if($result->num_rows<1) die("La requête ne renvoie aucun résultat");

                            while ($ligne = $result->fetch_array(MYSQLI_ASSOC)) 
                            {
                                echo "<option value=\"".$ligne['libelleVariete']."\">".$ligne['libelleVariete']."</option>";
                            }
                        ?>
                    </datalist>
                </div>

                <div class="md-form">
                     <i class="fa fa-map-marker prefix"></i>
                     <input type="text" id="parcelle" class="form-control" name="parcelle" placeholder="Selectionner sa parcelle (commune / numero / mode de production)" list="parcelles" autocomplete="off" required>
                     <datalist id="parcelles">
                     <?php 
                        global $cnx;  

                        //récupération de l'id producteur
                        $txtReqIdProducteur = "SELECT idProducteur FROM producteur WHERE idUser =".$_SESSION["idUser"].";";
                        $resultatIdProducteur = mysqli_query($cnx, $txtReqIdProducteur);
                        $data = mysqli_fetch_assoc($resultatIdProducteur);
                        $idProducteur=$data['idProducteur'];

                        //var_dump($txtReqIdProducteur);
    
                        $req="SELECT idParcelle, commune, numeroParcelle, modeProduction FROM parcelles NATURAL JOIN modeProduction where idProducteur=".$idProducteur.";";

                        $result = mysqli_query($cnx, $req) or die("La requête a échoué : ".$cnx->error);

                        if($result->num_rows<1) die("La requête ne renvoie aucun résultat");

                        while ($ligne = $result->fetch_array(MYSQLI_ASSOC)) 
                        {
                            echo "<option value=\"".$ligne['commune']." / ".$ligne['numeroParcelle']."  /  ".$ligne['modeProduction']."\">".$ligne['commune']." / ".$ligne['numeroParcelle']."  /  ".$ligne['modeProduction']."</option>";
                        }
                     ?>
                     </datalist>
                </div>

                <div class="md-form">
                	 <i class="fa fa-calendar prefix" style="left:0px;"></i>
                    <input type="date" id="dateRecolte" class="form-control" name="dateRecolte" placeholder="Date de la récolte (JJ/MM/AA)" autocomplete="off" required>
                    
                </div>

                  <div class="md-form">
                  <i class="fa fa-calendar prefix" style="left:0px;"></i>
                  <input type="date" id="dateLimite" class="form-control" name="dateLimite" placeholder="Date limite de consomation (JJ/MM/AA)" autocomplete="off" required>
                    
                </div>

 				<div class="text-center">
 	                   <button class="submit_button btn btn-primary mb-4" type="submit" name="addLot" value="addLot"><i class="fa fa-plus"></i>  Ajouter le Lot</button>
                </div>
    </form>
<?php
 if(isset($_POST['addLot']))
 {
//On verifie que le formulaire a ete envoye
    if(isset($_POST['prixU'], $_POST['unite'], $_POST['qte'], $_POST['rayon'], $_POST['produit'], $_POST['variete'], $_POST['parcelle'], $_POST['dateRecolte'], $_POST['dateLimite']))
    {
    
                // echappement des variables pour pouvoir les mettre dans une requette SQL
                $description = $cnx->escape_string($_POST['desc']);
                $prixUnitaire = $cnx->escape_string($_POST['prixU']);
                $uniteMesure = $cnx->escape_string($_POST['unite']);
                $quantite = $cnx->escape_string($_POST['qte']);
                $rayon = $cnx->escape_string($_POST['rayon']);
                $produit = $cnx->escape_string($_POST['produit']);
                $variete = $cnx->escape_string($_POST['variete']);
                $parcelle = $cnx->escape_string($_POST['parcelle']);
                $dateRecolte = $cnx->escape_string($_POST['dateRecolte']);
                $dateLimite = $cnx->escape_string($_POST['dateLimite']);

                global $cnx;
                 //faire la requete qui cherche le prochain identifiant pour le Lot
                 $txtReqIdentifiant="SELECT ifnull(max(idLot),1000)+1 as nextId FROM lot;";
                 $resultatId=mysqli_query($cnx, $txtReqIdentifiant);
                 $data=mysqli_fetch_assoc($resultatId);
                 $prochainIdentifiant=$data['nextId'];

                 //faire la requete qui recupère l'id de la parcelle 
                 $infoParcelle = explode(" / ",$parcelle);
                 $txtReqIdParcelle ="SELECT idParcelle FROM parcelles WHERE commune='".$infoParcelle[0]."' AND numeroParcelle=".$infoParcelle[1].";";
                 $resultatIdParcelle = mysqli_query($cnx, $txtReqIdParcelle);
                 $data=mysqli_fetch_assoc($resultatIdParcelle);
                 $idParcelle=$data['idParcelle'];


                //var_dump($txtReqIdParcelle);
                //echo "<br>";

                 //faire la requete qui recupère l'id de la produit 
                 $txtReqIdProduit ="SELECT idProduit FROM produit WHERE libelleProduit='".$produit."';";
                 $resultatIdProduit = mysqli_query($cnx, $txtReqIdProduit);
                 $data=mysqli_fetch_assoc($resultatIdProduit);
                 $idProduit=$data['idProduit'];

                //var_dump($txtReqIdProduit);
                // echo "<br>";

                 //faire la requete qui recupère l'id de la variete 
                 $txtReqIdVariete ="SELECT idVariete FROM variete WHERE libelleVariete='".$variete."';";
                 $resultatIdVariete = mysqli_query($cnx, $txtReqIdVariete);
                 $data=mysqli_fetch_assoc($resultatIdVariete);
                 $idVariete=$data['idVariete'];

                //var_dump($txtReqIdVariete);
                // echo "<br>";

                 //faire la requete qui recupère l'id de la Unite 
                 $txtReqIdUnite ="SELECT idUnite FROM unite WHERE libelleUnite='".$uniteMesure."';";
                 $resultatIdUnite = mysqli_query($cnx, $txtReqIdUnite);
                 $data=mysqli_fetch_assoc($resultatIdUnite);
                 $idUnite=$data['idUnite'];

                //var_dump($txtReqIdUnite);
                // echo "<br>";

                 //faire la requête qui récupère l'id du producteur selon l'id user de session
                 $txtReqIdProducteur = "SELECT idProducteur FROM producteur WHERE idUser =".$_SESSION["idUser"].";";
                 $resultatIdProducteur = mysqli_query($cnx, $txtReqIdProducteur);
                 $data = mysqli_fetch_assoc($resultatIdProducteur);
                 $idProducteur=$data['idProducteur'];

                //var_dump($txtReqIdProducteur);
                // echo "<br>";

                 //préparation de la requête d'ajout d'un lot
                  $ReqAddLot = 'INSERT INTO lot VALUES ('.$prochainIdentifiant.',"'.$description.'","'.$prixUnitaire.'","'.$quantite.'","'.$dateLimite.'","'.$dateRecolte.'",'.$idUnite.','.$idVariete.','.$idProducteur.','.$idParcelle.');';

                  //var_dump($ReqAddLot);

                if($cnx->query($ReqAddLot))
                {  
                    $message ="Votre lot de ".$quantite ." ".$uniteMesure." de ".$produit." ".$variete." à bien été enregistré à ".$prixUnitaire."€/".$uniteMesure.".";
                }
                else
                {
                    $message = "Une erreur est survenue lors de l'inscription du lot.";
                }
    }
    else 
    {
        $message = "Veuillez bien remplir tous les champs avant de valider votre formulaire d'ajout d'un lot.";
    }

    if (isset($message))
    {
        echo "<div class=\"msg\">".$message."</div>";
    }
}        
?>

    <!--Footer-->
   
        <!--Footer links-->
              <?php include ('footerLinks.html');?>
        <!--/.Footer links-->

        <!--Copyright-->
              <?php include ('bas.html');?>
        <!--/.Copyright-->

   <!--/.Footer-->