
    <!--Navbar-->
        <?php include ('haut.php');?>
    <!--/.Navbar-->
<?php
function get_ip() {
    // IP si internet partagé
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    // IP derrière un proxy
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Sinon : IP normale
    else {
        return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
}

if (!(isset($_REQUEST['send'])))    /* display the contact form */
    {
?>
    


    <!--Formulaire-->
    <br><br>
    <form class="mb-5 mt-5" method="POST" action="contactNW.php">
    <p class="h5 text-center mb-5">Nous contacter</p>

    <div class="md-form mb-5">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" name="name" id="name" class="form-control" placeholder="Votre nom" required>
        <!--<label for="name">Your name</label>-->
    </div>

    <div class="md-form mb-5">
        <i class="fa fa-envelope prefix grey-text"></i>
        <input type="email" name="email" id="email" class="form-control" placeholder="Votre email" required>
        <!--<label for="email">Your email</label>-->
    </div>

    <div class="md-form mb-5">
        <i class="fa fa-tag prefix grey-text"></i>
        <input type="text" name="subject" id="subject" class="form-control" placeholder="Sujet" required>
        <!--<label for="subject">Subject</label>-->
    </div>

    <div class="md-form mb-5">
        <i class="fa fa-pencil prefix grey-text"></i>
        <textarea type="text" name="message" id="message" class="md-textarea" style="height: 100px" placeholder="Votre message..." required></textarea>
        <!--<label for="message">Your message</label>-->
    </div>

    <div class="text-center">
        <button class="btn btn-default blue" name="send" id="send">Envoyer<i class="fa fa-paper-plane-o ml-1"></i></button>
    </div>

</form>
<?php
    } 
else                /* send the submitted data */
    {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $subject=$_POST['subject'];
        $message=$_POST['message'];
        if (($name=="")||($email=="")||($subject=="")||($message==""))
            {
            echo "Tous les champs sont requis, remplisser <a href=\"#\">le formulaire</a> correctement.";
            }
        else
        {       
            $header="From: $name<$email>\r\nReply-to: $email";
            mail("bayeux.remy@gmail.com", $subject, $message, $header);
            echo "Email envoyé!";

            $txtReqIdentifiant="SELECT max(idContact)+1 FROM Contact;";
            $resultatId=mysqli_query($txtReqIdentifiant);
            $tabInfo=mysqli_fetch_array($resultatId);
            $prochainIdentifiant=$tabInfo[0];

            $R = 'INSERT INTO Contact(idContact, nom, email, sujet, message, date, ip) VALUES ("'.$prochainIdentifiant.'","'.$name.'", "'.$email.'", "'.$subject.'","'.$message.'",now(),"'.get_ip().'")';

            $cnx->query($R);
        }  
    }
?>  
 <!--/.Formulaire-->

  <!--Copyright-->
   <!--Footer-->
  <?php include ('footerLinks.html');?> 
  <?php include ('bas.html');?>
  <!--/.Copyright-->
   <!--/.Footer-->