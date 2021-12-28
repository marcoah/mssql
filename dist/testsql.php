<?php

require('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

/* Database config */
$serverName = $_ENV['DB_SERVER'];;
$db_user = $_ENV['DB_USERNAME'];
$db_pass = $_ENV['DB_PASSWORD'];
$db_daba = $_ENV['DB_DATABASE'];; 

$serverName = "(local)\sqlexpress";
$connectionOptions = array(
    "database" => $db_daba,
    "uid" => $db_user,
    "pwd" => $db_pass
);

//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
//Select Query
$tsql= "SELECT @@Version as SQL_VERSION";
//Executes the query
$getResults= sqlsrv_query($conn, $tsql);
//Error handling
if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));
   ?>
    <h1> Results : </h1>
<?php
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        echo ($row['SQL_VERSION']); echo ("<br/>");
    }
    sqlsrv_free_stmt($getResults);
    function FormatErrors( $errors ) {
        /* Display errors. */
        echo "Error information: <br/>";
        foreach ( $errors as $error ) {
            echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";
            echo "Code: ".$error['code']."<br/>";
            echo "Message: ".$error['message']."<br/>";
        }
    }
    ?>