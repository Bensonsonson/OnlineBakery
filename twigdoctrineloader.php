<?php

require_once("Doctrine/Common/Classloader.php");
require_once("src/Bestellingen/Libraries/Twig/Autoloader.php");

use Doctrine\Common\ClassLoader;

$classloader = new ClassLoader("Bestellingen", "src");
$classloader->register();

$autoloader = Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("src/Bestellingen/Presentation");
$twig = new Twig_Environment($loader, array('debug'=>true, 'strict_variables' => false));
$twig->addExtension(new Twig_Extension_Debug);


