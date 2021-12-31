<?php  
    require('../vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    /* Database config */
    $db_serv = $_ENV['DB_SERVER'];;
    $db_user = $_ENV['DB_USERNAME'];
    $db_pass = $_ENV['DB_PASSWORD'];
    $db_daba = $_ENV['DB_DATABASE'];; 

    $serverName = $db_serv;
    $connectionOptions = array(
        "database" => $db_daba,
        "uid" => $db_user,
        "pwd" => $db_pass
    );


/* Connect using Windows Authentication. */  
$conn = sqlsrv_connect( $serverName, $connectionOptions);  
if( $conn === false )  
{  
     echo "Could not connect.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  

/* Get the product picture for a given product ID. */  
$tsql = "SELECT LargePhoto   
         FROM Production.ProductPhoto AS p  
         JOIN Production.ProductProductPhoto AS q  
         ON p.ProductPhotoID = q.ProductPhotoID  
         WHERE ProductID = ?";  

$params = array(&$_REQUEST['productId']);  

/* Execute the query. */  
$stmt = sqlsrv_query($conn, $tsql, $params);  
if( $stmt === false )  
{  
     echo "Error in statement execution.</br>";  
     die( print_r( sqlsrv_errors(), true));  
}  

/* Retrieve the image as a binary stream. */  
$getAsType = SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY);  
if ( sqlsrv_fetch( $stmt ) )  
{  
   $image = sqlsrv_get_field( $stmt, 0, $getAsType);  
   fpassthru($image);  
}  
else  
{  
     echo "Error in retrieving data.</br>";  
     die(print_r( sqlsrv_errors(), true));  
}  

/* Free the statement and connectin resources. */  
sqlsrv_free_stmt( $stmt );  
sqlsrv_close( $conn );  
?>