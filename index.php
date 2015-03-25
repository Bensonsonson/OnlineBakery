<?php

require_once 'twigdoctrineloader.php';

//use 
$errormessage = "";
$message = "";

if (isset($_GET['message'])) {
    $getMessage = $_GET['message'];
    switch($getMessage){
        case 'emailsent': $message = 'Registration complete. Check email for your password';
            break;
        case 'paswoordSent': $message = 'Your new password has been sent to your emailaddress';
            break;
        case 'reLogin' : $message = 'Please login again';
            break;
        case 'loggedOut': $message = 'You successfully logged out';
            break;
    }
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    switch ($error) {
        case 'database': $errormessage = "Unable to acces database";
            break;
        case 'empty': $errormessage = "The field(s) cannot be empty";
            break;
        case 'noRegistration': $errormessage = "Unable to register username and password";
            break;
        case 'existingUser':$errormessage = "Emailaddress already exists. Please choose another.";
            break;
        case 'userNotFound':$errormessage = "Username not found";
            break;
        case 'wrongPassword':$errormessage = "Wrong password entered";
            break;
        case 'noEmail': $errormessage = "Not a valid emailadres";
            break;
        case 'noInt': $errormessage = "Postcode must be an integer";
            break;
        default: $errormessage = "Something went terribly wrong!!! Please try again.";
    }
}


$view = $twig->render('index.twig', array('errormessage' => $errormessage, 'message' => $message));
print($view);
