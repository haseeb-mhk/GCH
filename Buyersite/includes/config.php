<?php   
require('stripe/init.php');

$Publishable_key = "pk_test_51Ph3GVHekS5vpVHsAbZHHlWSecs1EZqJIc5Awt19K23mE170hyolXUQzn5LQWiayMudtYE3VtFUqdTYeU1BOLJsI00a6wjdHib";
$Secret_key = "sk_test_51Ph3GVHekS5vpVHsOWpmMNIWVdrnh3nlo42mN5cdV4N3LCpQd3hVzJIDIaochG9tjLTPpEArk1wFXUnkKXR8xtAD00cM5bNIoM";
\Stripe\Stripe::setApiKey($Secret_key);

?>