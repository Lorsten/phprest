<?php

/*Server setting */
error_reporting(1);
ini_set("display_errors", 1);


// Set to true for localserver
$local = true;


if ($local) {
    define("DBHOST", "Localhost");
    define("DBUSER", "root");
    define("DBPASSWORD", "");
    define("DBDATABASE", "courses");
}

