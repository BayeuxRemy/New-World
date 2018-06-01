
    <!--Navbar-->
        <?php include ('haut.php');?>
    <!--/.Navbar-->
    <div style="margin-top:0px; width: 100%; height: 65px; background-color: black;"></div>
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
    <form class="mb-5 mt-5" method="POST" action="contactNW.php">
    <p class="h5 text-center mb-5">Nous contacter</p>

    <div class="md-form mb-3">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" name="name" id="name" class="form-control" placeholder="Votre nom" required>
        <!--<label for="name">Your name</label>-->
    </div>

    <div class="md-form mb-3">
        <i class="fa fa-envelope prefix grey-text"></i>
        <input type="email" name="email" id="email" class="form-control" placeholder="Votre email" required>
        <!--<label for="email">Your email</label>-->
    </div>

    <div class="md-form mb-3">
        <i class="fa fa-tag prefix grey-text"></i>
        <input type="text" name="subject" id="subject" class="form-control" placeholder="Sujet" required>
        <!--<label for="subject">Subject</label>-->
    </div>

    <div class="md-form mb-4">
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
                $msg = "Tous les champs sont requis, remplisser <a href=\"#\">le formulaire</a> correctement.";
            }
        else
        {       
            $header="From: $name<$email>\r\nReply-to: $email";
            mail("bayeux.remy@gmail.com", $subject, $message, $header);
            $msg = "<br /><br /><br /><br /><br /><br /><br /><br /><br />Votre email à bien été envoyé, <br /><br /> on vous répondra par mail dès que possible.<br /><br /> <a href=\"index.php\"><i class=\"fa fa-home\"></i> Retour à l'accueil</a>";

            global $cnx;

            $txtReqIdentifiant="SELECT ifnull(max(idContact),100)+1 as nextId FROM contact;";
            $resultatId=mysqli_query($cnx, $txtReqIdentifiant);
            $data=mysqli_fetch_assoc($resultatId);
            $prochainIdentifiant=$data['nextId'];

            $R = 'INSERT INTO contact(idContact, nom, email, sujet, message, date, ip) VALUES ("'.$prochainIdentifiant.'","'.$name.'", "'.$email.'", "'.$subject.'","'.$message.'",now(),"'.get_ip().'")';

            $cnx->query($R);
        } 

        if(isset($message))
        {
            echo '<div class="msg" id="contact">'.$msg.'</div>';
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