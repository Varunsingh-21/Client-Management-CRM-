<!-- 
    Name: Varun Deep Singh
    Student ID:100865156
    Date: September 29th,2023
    Course: INFT 2100
    File Name: sign-in.php
 -->
<?php
    $pagetitle="Sign In Page";
    include "./includes/header.php";
    // dynamic page title

    // redirection and flash messages
if (isset($_SESSION['user_email'])){
    header("Location:dashboard.php");
}
if(isset($_SESSION['flash_msessage_to_display'])){
    $message=$_SESSION['flash_msessage_to_display'];
    unset($_SESSION['flash_msessage_to_display']);
}
else{
    $message="";
}
     echo "<h2>".$message."<h2/>";

    //  if the page loads in POSt as request method
if ($_SERVER["REQUEST_METHOD"]=="POST"){

    $email_address=trim($_POST['inputEmail']);
    $password=trim($_POST['inputPassword']);
    $message="";

    if(!isset($email_address)||strlen($password)==0){
        $message.="You must enter the EmailAddress and password<br/>";
    }
    else if(!filter_var($email_address,FILTER_VALIDATE_EMAIL)){
        $message.="<em>".$email_address."<em> is not a valid Email. <br/>";
    }
    if(!isset($password)){
        $message.="You must enter your password<br/>";        
    }
    if($message==""){
        $user=0;
        // checking if we have a user in db with the same email as entered by the user trying to access.
        $results=user_select($email_address);
        if(pg_num_rows($results)==1){
            // if user with same email is found checking if the hashed password matches the plain one when dehashed.
            $user=user_authenticate($email_address,$password);
                if($user){
                    $_SESSION['user']=$user;
                    // adding variables to the session
                    $_SESSION['Full_name']='Hi, '.$user['firstname']." ".$user['lastname'];
                    $_SESSION['flash_msessage_to_display']="You have successfully Logged In: ".$user['firstname']." ".$user['lastname']."<br/>"."Last Logged in: ".$user['lastloggedin'];

                    // adding activity to the log file
                append_to_file('Sign-In','success',$email_address);
                // redirecting
                header("Location:dashboard.php");
                // flushing the buffer
                ob_flush();
            }
            else{
                // adding an alert message
                $message.="user did not authenticate correctly<br/>";
                $user=0;
                append_to_file('Sign-In','Failure',$email_address);
            }
        }
        else{            
            $message.="user did not authenticate correctly<br/>";
            append_to_file('Sign-In','Failure',$email_address);

        }
    }
        echo '<h3>'.$message.'</h3>';
}

?>   

<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="text" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" >
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<?php
include "./includes/footer.php";
?>    