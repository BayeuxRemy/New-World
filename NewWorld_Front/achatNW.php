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

   <h3 class="h3-responsive text-center mt-3 mb-5"><i class="fa fa-shopping-cart"></i>  Achat de produits</h3>
            
<!--Création d'un menu de recherche-->
<div class="ml-5">
  <h5>Recherchez vos produits :</h5>
 <label>Trier par rayon : </label>
 <label hidden>Trier par produit :</label>
 <label>Trier par producteur : </label> 
</div>


<!--Création des cards de chaque lot existant-->
<div class="row">
<?php 
    global $cnx;

    $req ="SELECT prix, quantite, dateLimite, libelleProduit, libelleVariete, photo, libelleUnite, descVariete FROM lot INNER JOIN variete ON lot.idVariete = variete.idVariete INNER JOIN produit ON variete.idProduit = produit.idProduit INNER JOIN unite ON lot.idUnite = unite.idUnite ORDER BY dateLimite;";

    $resultat=mysqli_query($cnx, $req);

    if($resultat->num_rows>0)
    {
      while ($ligne = $resultat->fetch_array(MYSQLI_ASSOC)) 
      {
        $prix=$ligne['prix'];
        $quantite=$ligne['quantite'];
        $dlc=$ligne['dateLimite'];
        $produit=$ligne['libelleProduit'];
        $variete=$ligne['libelleVariete'];
        $image=$ligne['photo'];
        $unite=$ligne['libelleUnite'];
        $description =$ligne['descVariete'];

        echo "<div class=\"col-sm-2 mb-5\">
                <div class=\"card text-center\">
                  <div class=\"card-body\">
                    <img class=\"card-img-top\" src=\"".$image."\" alt=\"No image\" height=\"180\" width=\"286\">
                    <h5 class=\"card-title\">".$produit." ".$variete."</h5>
                    <p class=\"card-text\"> Prix : ".$prix."€/".$unite."<br /> DLC : ".$dlc."<br /><br />Il reste : ".$quantite." ".$unite."</p>
                    <a href=\"#\" class=\"btn btn-primary\"><i class=\"fa fa-shopping-cart\"></i> Ajouter au panier</a>
                </div>
              </div>
           </div>";
      }
    }
    else
    {
      $message="Aucun lot n'es disponible pour le moment. Veuillez réessayer ultérieurement.";
    }
   
    if (isset($message))
    {
      echo "<div class=\"msg\">".$message."</div>";
    }
?>
</div>

  <!--Footer-->
   
        <!--Footer links-->
              <?php include ('footerLinks.html');?>
        <!--/.Footer links-->

        <!--Copyright-->
              <?php include ('bas.html');?>
        <!--/.Copyright-->

   <!--/.Footer-->