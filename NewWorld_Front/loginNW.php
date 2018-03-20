<?php
  // Traitement du formulaire 
  if(isset($_REQUEST['login']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // récupération du mot de passe utilisateur
    $txtReq="select password, idUser from User where password='".$password."' and username='".$username."'";
    $result = $cnx->query($txtReq);
    if ($result=== false OR $result->num_rows<1) {
        $message = 'Utilisateur inconnu ou mauvais mot de passe';
    }
    else 
    {
        $ligne = $result->fetch_array();
        // màj du username et identifiant dans la session
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['idUser'] = $ligne['idUser'];
        
        $message= 'Connexion réussie';     
    }
  }
    // affichage éventuel d'un message sil y a lieu
    if(isset($message)) 
    {
      echo $message;
    }*/

?>