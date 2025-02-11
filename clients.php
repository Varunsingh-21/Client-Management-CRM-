<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: oct 24th,2023
    Course: INFT 2100
    File Name: clients.php
 -->
<?php
$pagetitle = "Client Registration page";
include "./includes/header.php";
if(!isset($_SESSION ['user'])||
(isset($_SESSION['user'])&&($_SESSION['user']['usertype']!= ADMIN &&$_SESSION['user']['usertype']!= SALES))){
    $_SESSION['flash_msessage_to_display']="User Not Authorized to view this page"."<br/>";
    header("Location: sign-in.php");
    ob_flush();
}
$fName = "";
$lName = "";
$email_address = "";
$phone = "";
$extension="";
$sales_person="";
$message = "";
$error = "";
$file="";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $fName = trim($_POST['inputFName']);
    $lName = trim($_POST['inputLName']);
    $email_address = trim($_POST['inputEmail']);
    $phone = trim($_POST['inputPhone']);
    $extension=trim($_POST['inputext']);
    $sales_person=trim($_POST['selection']);
    $file=$_FILES['logo_path']['tmp_name'];    
    
    //validate first name
    if(!isset($fName) || $fName == ""){
        $error .= "You must enter your First Name.</br>";
    }

    //validate Last Name
    if(!isset($lName) || $lName == ""){
        $error .= "You must enter your Last Name.</br>";
    }
    if(!isset($phone) || !is_numeric($phone)){
        $error .= "You must enter your phone number correctly.</br>";
        
    }
    if(!isset($extension) || $extension == ""){
        $error .= "You must enter your Phone extention.</br>";
    }


    //validate email address
    if(!isset($email_address) || $email_address == ""){
        $error .= "You must enter your email address.</br>";
    }
    elseif(!filter_var($email_address, FILTER_VALIDATE_EMAIL)){
        $error .= "<em>". $email_address . "</em> is not a valid email address.";
        $email_address = "";
    }
    elseif(!isset($file)){
        $error.="Please select a file to upload";
    }
    elseif(pg_num_rows(client_select($email_address))==1)
    {
     $error .= "This email (".$email_address.") already exists.<br/>";
     $email_address = "";
    }
    if($error == ""){
        $tmp_name=$_FILES['logo_path']['tmp_name'];
        $name=basename($_FILES['logo_path']['name']);
        echo $name;
        move_uploaded_file($tmp_name, "./upload/".$_FILES['logo_path']['name']);
        $logo_path=" ./upload/".$name;
        // register_client($fName,$lName,$email_address,$phone,$extension,$logo_path);
        if(register_client($fName,$lName,$email_address,$phone,$extension,$logo_path)){
            $message = "You have successfully registered the client.";
            append_to_file("Client Registration"," Success ".$sales_person,$email_address);
            $email_address = "";
            $fName = "";
            $lName = "";
            $phone = "";
            $extension = "";
        }
        else{
            append_to_file("Client Registration"," Failure ",$email_address);
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
        "type" => "text",
        "name" => "inputPhone",
        "value" => $phone,
        "label" => "Phone Number"
    ),
    array(
        "type" => "text",
        "name" => "inputext",
        "value" => $extension,
        "label" => "Extension"
    ),
    array(
        "type"=>"file",
        "name"=>"logo_path",
        "value"=>"",
        "label"=>"No file selected"
    )
    ,
    array(
        "type" => "select",
        "name" => "salesinput",
        "value" => "",
        "label" => "Sales Person"
        
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
$page=1;
if(isset($_GET['page'])){
    $page=$_GET['page'];
}


display_table(
    array(
        "EmailAddress" =>"Email Address",
        "FirstName" => "First Name",
        "LastName" => "Last Name",
        "PhoneNumber" => "Phone Number",
        "Extension" => "Phone Extension",
        "LogoPath" => "Logo"
    ),
    client_select_all($page),
    client_count(),
    $page
);
?>