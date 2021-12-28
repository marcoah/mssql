<?php 
    require('vendor/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    /* Database config */
    $db_serv = $_ENV['DB_SERVER'];;
    $db_user = $_ENV['DB_USERNAME'];
    $db_pass = $_ENV['DB_PASSWORD'];
    $db_daba = $_ENV['DB_DATABASE'];; 

?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>Lista de Productos</title>
    </head>
    <body>

    <div class="container">
        <div class="table-responsive">
            <table class="table caption-top">
                <caption>Lista de Productos</caption>
                <thead>
                    <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">ProductNumber</th>
                    <th scope="col">ListPrice</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $serverName = "(local)\sqlexpress";
                $connectionOptions = array(
                    "database" => $db_daba,
                    "uid" => $db_user,
                    "pwd" => $db_pass
                );

                $conn = sqlsrv_connect($db_serv, $connectionOptions);
                if( $conn === false ) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $sql = "SELECT [ProductID], [Name], [ProductNumber], [ListPrice] FROM [AdventureWorks2012].[Production].[Product]";
                $stmt = sqlsrv_query( $conn, $sql );
                if( $stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                
                while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo '<tr><th scope="row">'.$row['ProductID']."</th><td>".$row['Name']."</td><td>".$row['ProductNumber']."</td><td>".$row['ListPrice']."</td></tr>";
                }
                sqlsrv_free_stmt( $stmt);
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>