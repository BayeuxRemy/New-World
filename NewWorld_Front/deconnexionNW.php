<?php
include("connexionBase.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
</head>
<body>
<?php
/*      Utilisateur connecté
*   déconnexion en supprimant les variables de session
*/
if(isset($_SESSION['username']))
{
  unset($_SESSION['username'], $_SESSION['idUser']);
  echo "<div class=\"msg\">Vous avez été déconnecté</div>";
}
if(!(isset($_SESSION['username']))) {
 header('Location: index.php');
} 
?>
</body>
</html>