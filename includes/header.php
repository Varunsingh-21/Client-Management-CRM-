
<!-- 
    Name: Varun Deep Singh
    Date: September 29th,2023
    File Name: header.php
 -->

 <!-- header for the files -->
<?php 
// starting a session to store key value pairs
session_start();

// adding all the required files
require("./includes/constants.php");
require("./includes/db.php");
require("./includes/functions.php");
ob_start();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?php echo $pagetitle;?></title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css" rel="stylesheet">
	
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
            <?php
            // changing the company name box as per requirements
            if(isset($_SESSION['Full_name'])){
                echo $_SESSION['Full_name'];
            } 
            else{
                echo 'Company Name';
            }
            ?>

        </a>
        <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <!-- changing the sideout link and text as per requirements -->
            <?php
            if(isset($_SESSION['user_email'])){
                echo '<a class="nav-link" href="sign-out.php">Sign Out</a>';
            }
            else{
                echo '<a class="nav-link" href="./sign-in.php">Sign In</a>';
            }
            ?>
        </li>
    </ul>
</nav>







<?php 
// making the navigation bar dynamic
if(isset($_SESSION['user_email'])){

    echo'<div class="container-fluid">
    <div class="row">
    
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
<ul class="nav flex-column">
<li class="nav-item">
<a class="nav-link active" href="./dashboard.php">
<span data-feather="home"></span>
Dashboard <span class="sr-only">(current)</span>
</a>
</li>
<li class="nav-item">
<a class="nav-link active" href="./change-password.php">
<span data-feather="home"></span>
Change Password <span class="sr-only">(current)</span>
</a>
</li>
';

if (isset($_SESSION['user'])&&($_SESSION['user']['usertype']==ADMIN)){
    echo '<li class="nav-item">'.
            '<a class="nav-link active" href="./salespeople.php">'.
                '<span data-feather="home"></span>'.
                'Salesperson Registration <span class="sr-only">(current)</span>'.
            '</a>'.
            '</li> 
            <li class="nav-item">'.
            '<a class="nav-link active" href="./clients.php">'.
                '<span data-feather="home"></span>'.
                'Client Registration <span class="sr-only">(current)</span>'.
            '</a>'.
            '</li>';
    }
    else{
        if(isset($_SESSION['user'])&&$_SESSION['user']['usertype']==SALES){
            echo '
            <li class="nav-item">'.
            '<a class="nav-link active" href="./clients.php">'.
                '<span data-feather="home"></span>'.
                'Client Registration <span class="sr-only">(current)</span>'.
            '</a>'.
            '</li>
            <li class="nav-item">'.
            '<a class="nav-link active" href="./calls.php">'.
                '<span data-feather="home"></span>'.
                'Calls Registration <span class="sr-only">(current)</span>'.
            '</a>'.
            '</li> '
            ;
        }

        else{

      
        echo '<li class="nav-item">
        <a class="nav-link" href="#">
        <span data-feather="file"></span>
        Orders
        </a>
        </li>
        <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="shopping-cart"></span>
                Products
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                    <span data-feather="users"></span>
                    Customers
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="bar-chart-2"></span>
                    Reports
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="layers"></span>
                    Integrations
                    </a>
                    </li>
                    </ul>
                    
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                    <span data-feather="plus-circle"></span>
                    </a>
                    </h6>
            <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                Current month
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">
                <span data-feather="file-text"></span>
                    Last quarter
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Social engagement
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="file-text"></span>
                    Year-end sale
                    </a>
                    </li>
                    </ul>
                    
 ';         
}          
                }
                   echo '</div>
                   </nav> <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">';
                    }
                    ?>