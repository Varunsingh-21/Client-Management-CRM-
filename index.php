<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: September 29th,2023
    Course: INFT 2100
    File Name: index.php
 -->
<?php
// index page
$pagetitle="Index";
require "./includes/header.php";
// if user is signed in redirecting him to the dashboard
if (isset($_SESSION['user_email'])){
    header("Location:dashboard.php");
}
?>

<h1 class="cover-heading">Cover your page.</h1>
<p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
<p class="lead">
    <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
</p>

<?php
include "./includes/footer.php";
?>    