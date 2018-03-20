<?php
include("connexionBase.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>New World !</title>

     <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">

    <!-- My Css -->
  <link href="css/style.css" rel="stylesheet">

    <!-- Template styles -->
    <style rel="stylesheet">
        /* TEMPLATE STYLES */

        /* Necessary for full page carousel*/
        html,
        body,
        .view {
            height: 100%;
        }
        /* Navigation*/
        
        .navbar {
            background-color: transparent;
        }
        
        .scrolling-navbar {
            -webkit-transition: background .5s ease-in-out, padding .5s ease-in-out;
            -moz-transition: background .5s ease-in-out, padding .5s ease-in-out;
            transition: background .5s ease-in-out, padding .5s ease-in-out;
        }
        
        .top-nav-collapse {
            background-color: #2b3f66;
        }
        
        footer.page-footer {
            background-color: #2b3f66;
            margin-top: 0;
        }
        
        @media only screen and (max-width: 768px) {
            .navbar {
                background-color: #2b3f66;
            }
        }
        /* Carousel*/
        
        .carousel,
        .carousel-item,
        .active {
            height: 100%;
        }
        
        .carousel-inner {
            height: 100%;
        }
        /*Caption*/
        
        .flex-center {
            color: #fff;
        }
        
        @media (min-width: 776px) {
            .carousel .view ul li {
                display: inline;
            }
            .carousel .view .full-bg-img ul li .flex-item {
                margin-bottom: 1.5rem;
            }
        }
        .navbar .btn-group .dropdown-menu a:hover {
            color: #000 !important;
        }
        .navbar .btn-group .dropdown-menu a:active {
            color: #fff !important;
        }
    </style>

    <!-- Mon CSS -->
    <link href="css/myCss.css" rel="stylesheet">
</head>

<body> 
<nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar ">
            <div class="container">
                <a class="navbar-brand" href="#">NW</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
                            <?php 
                          if (isset($_SESSION['username']))
                          {
                            $username=$_SESSION['username'];
                        ?>  
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Acheter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Produire</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link" href="distribNW.php">Distribuer</a>
                        </li>
                            <p class="nav-item ml-sm-5 text-white">Bievenu <?php echo $username ?></p>
                         <li class="nav-item ml-sm-5">
                            <a href="deconnexionNW.php" class="nav-link"><i class="fa fa-sign-in"></i>Déconnexion</a>
                        <?php
                          } else { 
                        ?>
                        </li>
                            <a href="#modal_login" id="show_login" class="nav-link" data-toggle="modal" data-target="#modal_login"><i class="fa fa-sign-in"></i>Connexion</a>
                        <?php
                          }
                        ?>
                        </li>
                    </ul>
                    <form class="form-inline">
                        <i class="fa fa-search" style="color:white;"></i><input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    </form>

                </div>
            </div>
        </nav>

<div class="modal fade modal-ext" id="modal_login" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="login" class="ajax-auth">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="text-center">
                    <h3 class="h3-responsive"><i class="fa fa-sign-in"></i> Connexion : </h3>
                   
                    <!--
                        wsl_render_auth_widget
                        WordPress Social Login 2.3.0.
                        http://wordpress.org/plugins/wordpress-social-login/
                    -->

                    <style type="text/css">
                    .wp-social-login-connect-with{}.wp-social-login-provider-list{}.wp-social-login-provider-list a{}.wp-social-login-provider-list img{}.wsl_connect_with_provider{}</style>

                    <!-- wsl_render_auth_widget -->
                    <hr>
                    <p class="status"></p>
                    <input type="hidden" id="security" name="security" value="aaeeddaed125" /><input type="hidden" name="_wp_http_referer" value="/" />
                    <div class="md-form">
                        <!--<label for="username">Votre identifiant</label>-->
                        <i class="fa fa-user prefix"></i>
                        <input type="text" id="username" class="form-control" name="username" placeholder="Identifiant" required>                
                    </div>

                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        <!--<label for="password">Votre mot de passe</label>-->
                    </div>

                    <div class="text-center">
                        <button class="submit_button btn btn-primary" type="submit" name="login" value="LOGIN">Se Connecter</button>
                    </div>

                    <hr>
                    <div class="text-center">
                        <p>Pas encore inscrit? <a href="signupNW.php">S'inscrire</a></p>
                        <p> Mot de passe <a href="#">oublié?</a></p>
                    </div>
                </div>
                <!-- fin de la div textcenter -->
            </form>
            <!-- fin de la première fenêtre-->
        </div>
    </div>
</div>
<!-- chargement de jquery -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src ="js/login.js"></script>