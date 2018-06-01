<?php include ('haut.php');?>


<form method="post">

                 <div class="text-center">
                <div style="margin-top:0px; width: 100%; height: 65px; background-color: black;"></div>
                    <h3 class="h3-responsive mt-3 mb-5"><i class="fa fa-user-plus"></i> Inscription</h3>
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
                    <input type="text" id="typeUser" class="form-control" name="typeUser" placeholder="consommateur / distributeur / producteur" liste="choixType" required>
                    <datalist id="choixType">
                        <option value="consommateur">consommateur</option> 
                        <option value="distributeur">distributeur</option>
                        <option value="producteur">producteur</option>
                    </datalist>
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

                <div class="text-center">
                    <button class="submit_button btn btn-primary" type="submit" name="signup" value="signup">S'inscrire</button>

                    <hr>

                    <p>Vous avez déjà un compte?<br> <a href="index.php"><i class="fa fa-home"></i>Retour a l'acceuil</a></p>
             
                </div>
              </form> 

<?php

 if(isset($_REQUEST['signup']))
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
                $ip = $_SERVER['REMOTE_ADDR'];

                global $cnx;
                 //faire la requete qui cherche le prochain identifiant pour l'utilisateur
                 $txtReqIdentifiant="SELECT ifnull(max(idUser),1000)+1 as nextId FROM utilisateur";
                 $resultatId=mysqli_query($cnx,$txtReqIdentifiant);
                 $data = mysqli_fetch_assoc($resultatId);
                 $prochainIdentifiant=$data['nextId'];
                
                 //faire la requete qui cherche l'id du rôle choisi par l'utilisateur
                 $txtReqIdRole = "SELECT idRole FROM role WHERE libelleRole ='".$typeUser."';";
                 $resultatIdRole =mysqli_query($cnx, $txtReqIdRole);
                 $data = mysqli_fetch_assoc($resultatIdRole);
                 $idRole = $data['idRole'];

                // vérification de l'absence d'utilisateur inscrit sous ce pseudo/email/tel
                $result = $cnx->query('SELECT idUser from utilisateur where username="'.$username.'";');
                if ($result->num_rows < 1) {

                    $resultat = $cnx->query('SELECT idUser from utilisateur where email="'.$email.'";');
                    if ($resultat->num_rows < 1) {

                        $resul = $cnx->query('SELECT idUser from utilisateur where tel="'.$tel.'";');
                        if ($resul->num_rows < 1) {

                            // enregistrement des informations
                            $R = 'INSERT INTO utilisateur VALUES ('.$prochainIdentifiant.',"'.$username.'","'.$nom.'","'.$prenom.'",now(),"'.$email.'","'.$password.'",NULL,"'.$ip.'",NULL,"'.$rue.'","'.$ville.'","'.$codePostal.'","'.$tel.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,"'.$idRole.'",NULL);';
                         if($cnx->query($R))
                         {
                    
                            echo '<div class="msg">Vous avez été inscrit.<br> Vous pouvez vous connecter.<br></div>';
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
            echo '<div class="msg">'.$message.'</div>';
    }
?>

        <!--Footer links-->
        <?php include ('footerLinks.html');?>
        <!--/.Footer links-->

        <!--Copyright-->
         <?php include ('bas.html');?>
        <!--/.Copyright-->
