<?php session_start(); ?>

<?php
include('config.php');

if(!isset($_SESSION["userID"])){

    // get url from current site
    $_SESSION["current_url"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    echo "<div class = \"full-page-cover\"></div>";
    // Echo Google Login Box div
    echo "<div class = \"login-box\">";
    echo "<h2>Please Login First</h2>";
    echo "<p>Not a member? Sign up to join our community.";
    echo "<br>Membership is free (always).</p>";
    $goo = 'href=\''.$google_client->createAuthUrl().'\'';
    $login_button2 = '<div><button class="g-signin2" data-ux_mode="redirect" data-theme="light" onclick="window.location.'.$goo.'" ></button><p>Doesn\'t have Google account? Click <a href="https://accounts.google.com/signup/v2/webcreateaccount?hl=en&flowName=GlifWebSignIn&flowEntry=SignUp">here</a> to sign up.</p></div>';
    echo $login_button2;
    echo "</div>";}
    else {
        $userID = $_SESSION["userID"];
    }
?>