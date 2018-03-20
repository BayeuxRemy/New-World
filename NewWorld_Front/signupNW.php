<?php include ('haut.php');?>

<form action="" method="post">
<?php
 if(isset($_POST['signup']))
 {
//On verifie que le formulaire a ete envoye
    if(isset($_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['password'], $_POST['password2'], $_POST['email'], $_POST['tel'], $_POST['typeUser'], $_POST['rue'], $_POST['codePostal'], $_POST['ville'])){
    
    // Vérification de l'identité des pwd
    if($_POST['password']==$_POST['password2']) {
        // vérification de la longueur du mot de passe
        if(strlen($_POST['password'])>=6) {
                // echappement des variables pour pouvoir les mettre dans une requette SQL
                $username = $cnx->escape_string($_POST['identifiant']);
                $password = $cnx->escape_string($_POST['password']);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $email = $cnx->escape_string($_POST['email']);
                $tel = $cnx->escape_string($_POST['tel']);
                $typeUser = $cnx->escape_string($_POST['typeUser']);
                $nom = $cnx->escape_string($_POST['nom']);
                $prenom = $cnx->escape_string($_POST['prenom']);
                $rue = $cnx->escape_string($_POST['rue']);
                $codePostal = $cnx->escape_string($_POST['codePostal']);
                $ville = $cnx->escape_string($_POST['ville']);

                 //faire la requete qui cherche le prochain identifiant pour l'utilisateur
                 $txtReqIdentifiant="SELECT ifnull(max(idUser),1000)+1 FROM User;";
                 $resultatId=mysql_query($txtReqIdentifiant);
                 $tabInfo=mysql_fetch_array($resultatId);
                 $prochainIdentifiant=$tabInfo[0];

                // vérification de l'absence d'utilisateur inscrit sous ce pseudo
                $result = $cnx->query('SELECT idUser from User where username="'.$username.'";');
                if ($result->num_rows < 1) {

                    $resultat = $cnx->query('SELECT idUser from User where email="'.$email.'";');
                    if ($resultat->num_rows < 1) {

                        $resul = $cnx->query('SELECT idUser from User where tel="'.$tel.'";');
                        if ($resul->num_rows < 1) {

                            // enregistrement des informations
                            $R = 'INSERT INTO User VALUES ('.$prochainIdentifiant.',"'.$username.'", "'.$password.'", "'.$email.'",now(),"'.$typeUser.'",NULL,NULL,"'.$nom.'","'.$prenom.'","'.$tel.'",NULL,NULL,NULL,"'.$rue.'","'.$codePostal.'","'.$ville.'",0,0);';
                         if($cnx->query($R))
                         {
                    
                            echo '<div>Vous avez été inscrit.<br> Vous pouvez vous connecter.<br></div>';
                            //header('Location: index.php');
                         }
                         else {
                    
                            $message = "Une erreur est survenue lors de l'inscription.";
                         }
                        }
                        else {
                    
                            $message = "Numéro de téléphonne déjà utilisé.<br>Veuillez en saisir un autre.";
                        }
                    }        
                    else {
                
                        $message = 'Email déjà utilisé.<br>Veuillez en saisir une autre.';
                    }
                }
                else {
            
                    $message = 'Identifiant déjà assigné.<br> Veuillez en saisir un autre.';
                }
        }
        else {
    
            $message = 'Le mot de passe que vous avez entré <br> contient moins de 6 caractères.';
        }
    }
    else {

        $message = 'Les mots de passe que vous avez entré <br> ne sont pas identiques.';
    }
}
else {
    $message = 'Erreur de saisie!';
}
}
    //On affiche un message s'il y a lieu
    if(isset($message))
    {
            echo '<div>'.$message.'</div>';
    }
?>
                <div class="text-center">
                <div style="margin-top:0px; width: 100%; height: 65px; background-color: black;"></div>
                    <h3 class="h3-responsive"><i class="fa fa-user-plus"></i> Inscription</h3>
                <br><br><br>
                    <!--
                        wsl_render_auth_widget
                        WordPress Social Login 2.3.0.
                        http://wordpress.org/plugins/wordpress-social-login/
                    -->
                    <style type="text/css">
                    .wp-social-login-connect-with{}.wp-social-login-provider-list{}.wp-social-login-provider-list a{}.wp-social-login-provider-list img{}.wsl_connect_with_provider{}
                    </style>
                </div>
                <!-- fin du textcenter-->
                <p class="status"></p>
                <input type="hidden" id="signonsecurity" name="signonsecurity" value="256874042c" /><input type="hidden" name="_wp_http_referer" value="/" />
                <div class="md-form">
                    <i class="fa fa-user prefix"></i>
                    <input type="text" id="signonname" class="form-control" name="nom" placeholder="Votre nom" required>
                    <label for="signonname"></label>
                </div>
                <div class="md-form">
                    <i class="fa fa-user prefix"></i>
                    <input type="text" id="signonpname" class="form-control" name="prenom" placeholder="Votre prénom" required>
                    <label for="signonpname"></label>
                </div>
                <div class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Votre email" required>
                    <label for="email"></label>
                </div>
                  <div class="md-form">
                    <i class="fa fa-user-o prefix"></i>
                    <input type="text" id="identifiant" class="form-control" name="identifiant" placeholder="Créer un identifiant" required>
                    <label for="identifiant"></label>
                </div>
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Votre mot de passe" required>
                    <label for="password"></label>
                </div>

                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input type="password" id="password2" class="form-control" name="password2" placeholder="Repetez le mot de passe" required>
                    <label for="password2"></label>
                </div>

                 <div class="md-form">
                    <i class="fa fa-phone prefix"></i>
                    <input type="text" id="tel" class="form-control" name="tel" placeholder="Votre numéro de téléphone" required>
                    <label for="tel"></label>
                </div>

                 <div class="md-form">
                    <i class="fa fa-users prefix"></i>
                    <input type="text" id="typeUser" class="form-control" name="typeUser" placeholder="Distributeur / Consommateur / Producteur" liste="typeListe" required>
                    <datalist name="typeListe"></datalist>
                    <label for="typeUser"></label>
                </div>

                <?php include ('js/scriptAdresse.php'); ?>

                 <div class="md-form">
                    <i class="fa fa-envelope-o prefix"></i>
                    <input type="text" id="idRue" class="form-control" name="rue" placeholder="Rue" required>
                    <label for="rue"></label>
                </div>

                <div class="md-form">
                    <i class="fa fa-globe prefix"></i>
                    <input type="text" id="idCodePostal" class="form-control" name="codePostal" placeholder="Code Postal" required>
                    <label for="codePostal"></label>
                </div>

                  <div class="md-form">
                    <i class="fa fa-globe prefix"></i>
                    <input type="text" id="idVille" class="form-control" name="ville" placeholder="Ville" required>
                    <label for="rue"></label>
                </div>
<
                <div class="text-center">
                    <button class="submit_button btn btn-primary" type="submit" name="signup" value="signup">S'inscrire</button>

                    <hr>

                    <p>Vous avez déjà un compte?<br> <a href="index.php"><i class="fa fa-home"></i>Retour a l'acceuil</a></p>
             
                </div>
              </form> 
        <!--Footer links-->
        <?php include ('footerLinks.html');?>
        <!--/.Footer links-->

        <!--Copyright-->
         <?php include ('bas.html');?>
        <!--/.Copyright-->
