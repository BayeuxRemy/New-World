<?php
session_start(); 

	$user = "rbayeux";
	$pwd = "ini01";
	$serveur = "localhost";
	$base = "newWorld";

	mysqli_connect($serveur, $user, $pwd);
	//mysql_select_db($base);
	// connection à la base
	if (!($cnx = mysqli_connect($serveur, $user, $pwd, $base))) 
	{
		echo ("connexion impossible ".$cnx->connect_error);
		return false;
	}
		
	$cnx->query("SET NAMES utf8");

	//echo "Connexion réussie à la base $base<br><br>";
	

$url_home="index.php";
?>
