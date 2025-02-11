<!-- 
    Name: Varun Deep Singh
    Date: September 29th,2023
    File Name: db.php
 -->
 <!-- FILE TO KEEP ALL THE FUCNTIONS AND EXECUTABLE CODE THAT RELATES TO DATABASE -->
<?php

// function to open a connection with the database.
function db_connect(){
    return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
}
$conn=db_connect();


// Preparing sql executable statements
$stmt1=pg_prepare($conn,'user_retrieve',"SELECT * FROM users WHERE EmailAddress=$1");
$prep_statement2=pg_prepare($conn,'user_update_login_time',"UPDATE users SET LastLoggedIn=$1 WHERE EmailAddress=$2");


$prep_stmt_3_insert=pg_prepare($conn, 'insert_user', "INSERT INTO  
users(EmailAddress, Password, FirstName, LastName, CreatedTime, 
phoneExtension, UserType) VALUES ($1, $2, $3, $4, $5, $6, $7)");

$stmt4=pg_prepare($conn,'client_reg', "INSERT INTO clients(EmailAddress, FirstName, LastName, 
PhoneNumber, Extension, Sales_id,LogoPath) VALUES($1,$2,$3,$4,$5,$6,$7)");

$stmt5=pg_prepare($conn, "client_check","SELECT * FROM clients WHERE EmailAddress=$1");


$prep_statement5=pg_prepare($conn,'client_names','SELECT firstname,emailaddress from clients WHERE sales_id=$1');

$register_call=pg_prepare($conn,'insert_call','INSERT INTO calls(time_of_call,client_id,notes) VALUES($1,$2,$3)');

// function to select user if there is  a match
function user_select($email_address){
    global $conn;
    $results=pg_execute($conn,'user_retrieve',array($email_address));
    return $results;
}

// fucntion to aunthenticate the user with password
function user_authenticate($email_add,$password){
    global $conn;
        $results=user_select($email_add);
        $user=pg_fetch_assoc($results,0);
        if(password_verify($password,$user['password'])){
            $_SESSION['user_email']=$user['emailaddress'];
            $now=date("Y-m-d G:i:s");
            // using the  update prepared statement to update the last logged in the database.
            pg_execute($conn,"user_update_login_time",array($now,$email_add));
            return $user;
        }
        else{
            return false;
        }
}

//function to insert a sales person
function insert_salesperson($email_address, $password, $fName, $lName,
$phone, $usertype){
global $conn;
$now = date("Y-m-d G:i:s");                           
return pg_execute($conn, 'insert_user',array($email_address, 
password_hash($password, PASSWORD_BCRYPT),
$fName, $lName, $now, $phone, $usertype));
}

function get_sale_id($em_id){
    global $conn;
    $stmt_temp=pg_prepare($conn,'sale_id',"SELECT id FROM users WHERE emailaddress=$1");
    $result3=pg_execute($conn,'sale_id',array($em_id));
    $r1=pg_fetch_row($result3);
    return $r1[0];
}
//function to register a client
function register_client($fName,$lName,$email_address,$phone,$extension,$path){
    global $conn;
    // EmailAddress, FirstName, LastName, 
    // PhoneNumber, Extension, Sales_id
    
    return pg_execute($conn,'client_reg',array($email_address,$fName,$lName,$phone,$extension,
    get_sale_id($_POST['selection']),$path
    ));

}

//function to get results from salesperson table
function result_from_sales(){
    global $conn;
    $prep_statement3=pg_prepare($conn,'sale_u','SELECT firstname,lastname,emailaddress from users WHERE usertype=$1 ');
   $sales_r= pg_execute($conn, 'sale_u',array(SALES));
   return $sales_r;
}

//function to check if a client exists
function client_select($email_address){
    global $conn;
    $results=pg_execute($conn,'client_check',array($email_address));
    return $results;

}

//function to get client id by client email
function results_from_clients(){
    global $conn;
 
   $sales_r= pg_execute($conn, 'client_names',array($_SESSION['user']['id']));
   return $sales_r;

}
//function to register a call
function register_call($client1,$local_date_time,$notes){
    global $conn;
    $results=client_select($client1);
    $row1=pg_fetch_row($results);
    return pg_execute($conn,'insert_call',array($local_date_time,$row1[0],$notes));
}

$salesperson_select_all= pg_prepare($conn,"salesperson_select_all",
"SELECT Id,emailaddress,FirstName,LastName,phoneExtension,UserType FROM users WHERE
UserType='s'");

function salesperson_select_all($page)
{
    global $conn;

    $result= pg_execute($conn,"salesperson_select_all",array());

    $count=pg_num_rows($result);
    $arr= array();
    for($i= ($page-1)*RECORDS; $i < $count && $i < $page*RECORDS; $i++)
    {
        array_push($arr,pg_fetch_assoc($result,$i));
    }
    return $arr;
}

function salesperson_count()
{
    global $conn;
    $result=pg_execute($conn,"salesperson_select_all", array());
    return pg_num_rows($result);
}


$client_select_all= pg_prepare($conn,"client_select_all",

    'SELECT EmailAddress,FirstName,LastName,PhoneNumber,Extension,LogoPath FROM clients ;'
    );


$client_select_all_sales=pg_prepare($conn,"client_select_all_sales",'SELECT EmailAddress,FirstName,LastName,PhoneNumber,Extension,LogoPath from clients WHERE Sales_id=$1');

function client_select_all($page){

global $conn;
if($_SESSION['user']['usertype']=='a'){
    $result= pg_execute($conn,"client_select_all",array());
}
else{
    $result= pg_execute($conn,"client_select_all_sales",array($_SESSION['user']['id']));
}

    $count=pg_num_rows($result);
    $arr= array();
    for($i= ($page-1)*RECORDS; $i < $count && $i < $page*RECORDS; $i++)
    {
        array_push($arr,pg_fetch_assoc($result,$i));
    }
    return $arr;

}


function client_count(){
    global $conn;
    if($_SESSION['user']['usertype']=='a'){
        $result= pg_execute($conn,"client_select_all",array());
    }
    else{
        $result= pg_execute($conn,"client_select_all_sales",array($_SESSION['user']['id']));
    }
    
        return pg_num_rows($result);
}






$call_select_all=pg_prepare($conn,"call_select_all",'SELECT * from calls WHERE client_id IN (SELECT id from clients WHERE Sales_id=$1 )');

function call_select_all($page){
    global $conn;

    $result= pg_execute($conn,"call_select_all",array($_SESSION['user']['id']));
    $count=pg_num_rows($result);
    $arr= array();
    for($i= ($page-1)*RECORDS; $i < $count && $i < $page*RECORDS; $i++)
    {
        array_push($arr,pg_fetch_assoc($result,$i));
    }
    return $arr;
}



function call_count()
{
    global $conn;
    $result=pg_execute($conn,"call_select_all", array($_SESSION['user']['id']));
    return pg_num_rows($result);
}
    
    $change_pass=pg_prepare($conn,"change_pass",'UPDATE users SET password=$1 WHERE Id=$2');
function change_pass($new){
    global $conn;
    echo($_SESSION['user']['id']);
    return pg_execute($conn,'change_pass',array(password_hash($new, PASSWORD_BCRYPT),$_SESSION['user']['id']));

}





?>