<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: oct 24th,2023
    Course: INFT 2100
    File Name: salespeople.php
 -->
<?php
$pagetitle = "Sale People Registration";
include "./includes/header.php";
if(!isset($_SESSION ['user'])||
(isset($_SESSION['user'])&&$_SESSION['user']['usertype']!= ADMIN)){
    $_SESSION['flash_msessage_to_display']="User not an admin"."<br/>";
    session_unset();
    session_destroy();
    session_start();
    header("Location: sign-in.php");
    ob_flush();
}

$fName = "";
$lName = "";
$email_address = "";
$password1 = "";
$password2 = "";
$phone = "";
$message = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $fName = trim($_POST['inputFName']);
    $lName = trim($_POST['inputLName']);
    $email_address = trim($_POST['inputEmail']);
    $password1 = trim($_POST['inputPassword1']);
    $password2 = trim($_POST['inputPassword2']);
    $phone = trim($_POST['inputPhone']);

    //validate First Name
    if(!isset($fName) || $fName == ""){
        $error .= "You must enter your First Name.</br>";
    }

    //validate Last Name
    if(!isset($lName) || $lName == ""){
        $error .= "You must enter your Last Name.</br>";
    }

    //validate email address
    if(!isset($email_address) || $email_address == ""){
        $error .= "You must enter your email address.</br>";
    }
    elseif(!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
        $error .= "<em>". $email_address . "</em> is not a valid email address.";
        $email_address = "";
    }
    elseif(pg_num_rows(user_select($email_address))==1)
    {
     $error .= "This email (".$email_address.") already exists.<br/>";
     $email_address = "";
    }

    //validate password
    if(!isset($password1) || $password1 == "" || !isset($password2) || $password2 == ""){
    //if the user does not enter anything.
    $error .="You must enter your password.<br/>";
    }
    else
    {
        if (strcmp($password1, $password2)){
        $error .= "Entered password and confirm password should be the same.<br/>";
    }
}

    if($error == ""){
        if(insert_salesperson($email_address, $password1, $fName, $lName, $phone, SALES)){
            $message = "You have successfully registered the user.";
            append_to_file("User addition","Success",$email_address);
            $email_address = "";
            $fName = "";
            $lName = "";
            $phone = "";
        }
        else{
            append_to_file("User addition","Failure",$email_address);
            $error .= "Something wrong with insert";
        }
    }
    else{
        $error .= "<br/>Please Try Again.";
    }
    $message .= $error;
    $_SESSION['message_from_sale']=$message;
}
?>
<?php
if(isset($_SESSION['message_from_sale'])){
    echo $_SESSION['message_from_sale'];
    unset($_SESSION['message_from_sale']);
}
$user = array(
    array(
        "type" => "text",
        "name" => "inputFName",
        "value" => $fName,
        "label" => "First Name"
    ),
    array(
        "type" => "text",
        "name" => "inputLName",
        "value" => $lName,
        "label" => "Last Name"
    ),
    array(
        "type" => "email",
        "name" => "inputEmail",
        "value" => $email_address,
        "label" => "Email address"
    ),
    array(
        "type" => "password",
        "name" => "inputPassword1",
        "value" => "",
        "label" => "Password"
    ),
    array(
        "type" => "password",
        "name" => "inputPassword2",
        "value" => "",
        "label" => "Confirm Password"
    ),
    array(
        "type" => "text",
        "name" => "inputPhone",
        "value" => $phone,
        "label" => "Phone Number"
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



////////////////////////////////////////////////////////////////////


$page=1;
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }
    display_table(
        array(
            "id" => "ID",
            "EmailAddress" =>"Email Address",
            "FirstName" => "First Name",
            "LastName" => "Last Name",
            "PhoneExtension" => "Phone Number",
            "UserType" => "User Type"
        ),

        salesperson_select_all($page),
        salesperson_count(),
        $page
    );




/////////////////////////
?>