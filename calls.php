<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: oct 24th,2023
    Course: INFT 2100
    File Name: calls.php
 -->
<?php
$pagetitle = "Calls Registration page";
include "./includes/header.php";
if(!isset($_SESSION ['user'])||
(isset($_SESSION['user']) &&$_SESSION['user']['usertype']!= SALES)){
    $_SESSION['flash_msessage_to_display']="User Not Authorized to view this page"."<br/>";
    header("Location: sign-in.php");
    ob_flush();
}
$client="";
$sales_person="";
$local_date_time="";
$notes="";
$error="";
$message="";
if($_SERVER["REQUEST_METHOD"] === "POST"){


$sales_person=$_SESSION["user"]["emailaddress"];
$local_date_time=$_POST['dateinput'];
$notes=trim($_POST['notes']);
$client=$_POST['selection2'];
if(!isset($local_date_time) || $local_date_time == ""){
    $error .= "You must enter the date and time of call.</br>";
}
if($error == ""){
    if(register_call($client,$local_date_time,$notes)){
        $message = "You have successfully registered the call.";
            append_to_file("Call Registration"," Success ",$sales_person);
            $client="";
        $sales_person="";
        $local_date_time="";
        $notes="";
        $error="";
    }
    else{
        append_to_file("Call Registration"," Failure ",$sales_person);
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
        "type" => "select2",
        "name" => "salesinput",
        "value" => $sales_person,
        "label" => "Sales Person"
        
    ),
    array(
        "type" => "datetime-local",
        "name" => "dateinput",
        "value" => $local_date_time,
        "label" => "call time"
        
    ),
    array(
        "type" => "textarea",
        "name" => "notesinput",
        "value" => $notes,
        "label" => "Notes"
        
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
        "id" =>"Call ID",
        "time_of_call" => "Time of Call",
        "client_id" => "Client ID",
        "notes" => "Notes",
    ),
    call_select_all($page),
    call_count(),
    $page
);
?>