<?php

require_once 'twigdoctrineloader.php';

unset($_COOKIE['userId']);
unset($_COOKIE['voornaam']);
unset($_COOKIE['emailadres']);
setcookie('userId', '' , time() - 1200 );
setcookie('voornaam', '', time() - 1200);
setcookie('emailadres', '', time() - 86400);
session_destroy();

header('location:index.php?message=loggedOut');
exit(0);

