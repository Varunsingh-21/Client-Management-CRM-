
<?php
include "./includes/header.php";
$pagetitle="Change Password";

// if user is not signed in. Making him unable to access the dashboard
if(!isset($_SESSION['user_email'])){
    header("Location:sign-in.php");
}
// using the flash message to display the name and last logged in time.
if(isset($_SESSION['flash_msessage_to_display'])){
    $message=$_SESSION['flash_msessage_to_display'];
    unset($_SESSION['flash_msessage_to_display']);
}
else{
    $message="";
}
?>
<h2>
    <?php echo $message?>
</h2>
<?php
$current_pass="";
$new_pass="";
$error="";
if($_SERVER["REQUEST_METHOD"] === "POST"){
$current_pass=trim($_POST['cpassword']);
$new_pass=trim($_POST['newpassword']);

if(!isset($current_pass) || $current_pass == ""||!isset($new_pass)||$new_pass==""){
    $error .="Please fill both the fields<br/>";
}
elseif(!password_verify($current_pass,$_SESSION['user']['password'])){
    $error .="Current password is incorrect<br/>";
}
if($error==""){
    if(change_pass($new_pass)){

        header("Location:./sign-out.php");
        ob_flush();
    }
    else{
        $error.="something went wrong<br/>";
    }
}
else{
    $error.= "Please Try Again.";
}
echo $error;
}
$user = array(
    array(
        "type" => "password",
        "name" => "cpassword",
        "value" => "",
        "label" => "Current Password"
        
    ),
    array(
        "type" => "password",
        "name" => "newpassword",
        "value" => "",
        "label" => "New Password"
        
    ),
    array(
        "type" => "submit",
        "name" => "",
        "value" => "",
        "label" => "Register"
    ),
    array(
        "type" => "reset",
        "name" => "",
        "value" => "",
        "label" => "Clear"
    ),
);
display_form($user);
?>