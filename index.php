<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
define("ROOT", __DIR__);
//require(ROOT."/config.php");
require(ROOT."/Toro.php");
//require(ROOT."/lib/db.php");
require(ROOT."/handlers/home.php"); //function requires all the files stored in ROOT."/handlers/"

ToroHook::add("404", function() {
    echo "Not found";
});

Toro::serve(array(
    "/" => "HomeHandler"
));
?>
