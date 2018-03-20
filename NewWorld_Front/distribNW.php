<!--Navbar-->
    <?php include ('haut.php');?>
<!--/.Navbar-->
<?php
 if(isset($_POST['addLot']))
 {
//On verifie que le formulaire a ete envoye
    if(isset($_POST['prixU'], $_POST['unite'], $_POST['qte'], $_POST['rayon'], $_POST['produit'], $_POST['variete'], $_POST['parcelle'], $_POST['dateRecolte'], $_POST['dateLimite'])){
    
                // echappement des variables pour pouvoir les mettre dans une requette SQL
                $prixUnitaire = $cnx->escape_string($_POST['prixU']);
                $uniteMesure = $cnx->escape_string($_POST['unite']);
                $quantite = $cnx->escape_string($_POST['qte']);
                $rayon = $cnx->escape_string($_POST['rayon']);
                $produit = $cnx->escape_string($_POST['produit']);
                $variete = $cnx->escape_string($_POST['variete']);
                $parcelle = $cnx->escape_string($_POST['parcelle']);
                $dateRecolte = $cnx->escape_string($_POST['dateRecolte']);
                $dateLimite = $cnx->escape_string($_POST['dateLimite']);

                 //faire la requete qui cherche le prochain identifiant pour le Lot
                 $txtReqIdentifiant="SELECT ifnull(max(idLots),1000)+1 FROM Lots;";
                 $resultatId=mysql_query($txtReqIdentifiant);
                 $tabInfo=mysql_fetch_array($resultatId);
                 $prochainIdentifiant=$tabInfo[0];

                 //faire la requete qui recupère l'id de la parcelle 
                 $txtReqIdParcelle ="SELECT idParcelle FROM Parcelles WHERE libelleParcelle='".$parcelle."';";
                 $idParcelle = mysql_query($txtReqIdParcelle);

                 //faire la requete qui recupère l'id de la produit 
                 $txtReqIdProduit ="SELECT idProduit FROM Produits WHERE nomProduit='".$produit."';";
                 $idProduit = mysql_query($txtReqIdProduit);

                 //faire la requete qui recupère l'id de la variete 
                 $txtReqIdVariete ="SELECT idVariete FROM Varietes WHERE libelleVariete='".$variete."';";
                 $idVariete = mysql_query($txtReqIdVariete);

                 //faire la requete qui recupère l'id de la Unite 
                 $txtReqIdUnite ="SELECT idUnite FROM Unite WHERE labelUnite='".$uniteMesure."';";
                 $idUnite = mysql_query($txtReqIdUnite);

                 //préparation de la requête d'ajout d'un lot
                  $ReqAddLot = 'INSERT INTO Lots VALUES ('.$prochainIdentifiant.',"'.$quantite.'", "'.$dateRecolte.'", "'.$dateLimite.'","'.$idParcelle.'","'.$idProduit.'","'.$idVariete.'","'.$idUnite.'");';

    }
}        
?>

 <div style="margin-top:0px; width: 100%; height: 65px; background-color: black;"></div>
 <div class="text-center">

                    <h3 class="h3-responsive"><i class="fa fa-plus"></i>  Ajouter un lot</h3>
                	<br><br><br>
                 
                <div class="md-form">
               		<i class="fa fa-eur prefix" style="left:0px;"></i>
                    <input type="number" id="prixU" class="form-control" name="prixU" placeholder="Prix Unitaire" step=".01" required>
                    
                </div>

                <div class="md-form">
                    
                    <input type="text" id="unite" class="form-control" name="unite" placeholder="Unité" required>
                    
                </div>

                <div class="md-form">
     				<i class="fa fa-balance-scale prefix" style="left:0px;"></i>
                    <input type="number" id="qte" class="form-control" name="qte" placeholder="Quantité" required>
                    
                </div>

                  <div class="md-form">
               		<i class="fa fa-info prefix" style="left:0px;"></i>
                    <input type="text" id="rayon" class="form-control" name="rayon" placeholder="Entrer son rayon" required>
                  </div>

                  <div class="md-form">
                    <i class="fa fa-info prefix" style="left:0px;"></i>
                     <input type="text" id="produit" class="form-control" name="produit" placeholder="Entrer son produit" required>
                   </div>

                   <div class="md-form">
                     <i class="fa fa-info prefix" style="left:0px;"></i>
                     <input type="text" id="variete" class="form-control" name="variete" placeholder="Entrer sa variété" required>
                    
                </div>

                <div class="md-from">
                     <input type="text" id="parcelle" class="form-control" name="parcelle" placeholder="Entrer sa parcelle" liste="listParcele" required>
                    <datalist name="listParcelle"></datalist>
                </div>

                <div class="md-form">
                	 <i class="fa fa-calendar prefix" style="left:0px;"></i>
                    <input type="date" id="dateRecolte" class="form-control" name="dateRecolte" placeholder="Date de la récolte" required>
                    
                </div>

                  <div class="md-form">
                  <i class="fa fa-calendar prefix" style="left:0px;"></i>
                  <input type="date" id="dateLimite" class="form-control" name="dateLimite" placeholder="Date limite de consomation" required>
                    
                </div>

 				<div class="text-center">
 	                   <button class="submit_button btn btn-primary" type="submit" name="addLot" value="addLot">Ajouter le Lot</button>
    <!--Footer-->
   
        <!--Footer links-->
              <?php include ('footerLinks.html');?>
        <!--/.Footer links-->

        <!--Copyright-->
              <?php include ('bas.html');?>
        <!--/.Copyright-->

   <!--/.Footer-->