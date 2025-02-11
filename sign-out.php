<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: September 29th,2023
    Course: INFT 2100
    File Name: sign-out.php
 -->
<?php
$pagetitle="Sign-Out";
require "./includes/header.php";
// storing the email before destroying the session
$signed_out_email=$_SESSION['user_email'];

// unsetting the whole session and destroying it.
unset($_SESSION);
session_destroy();
// starting a new session
session_start();

// setting a flash message 
$_SESSION['flash_msessage_to_display']="Successfully Logged Out. User: ".$signed_out_email;
// adding activity to a file
append_to_file("Sign-Out","Success",$signed_out_email);
// redirecting to sign in
header("Location:./sign-in.php");
ob_flush();
?>