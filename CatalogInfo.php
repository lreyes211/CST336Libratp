<?php

$namedParameters = array();
include '../Connect.php';
$dbConn = getDBConnection("Recipe");

$sql = "SELECT * FROM Catalog WHERE 1 AND name LIKE :name  "; //using Named Parameters to prevent SQL Injection
$namedParameters[':name'] = "%" . $_GET['name'] . "%";
$statement= $dbConn->prepare($sql); 
$statement->execute($namedParameters); //Always pass the named parameters, if any
$record = $statement->fetch(PDO::FETCH_ASSOC); 

//print_r($record);
//compare name to datebase for more info from <h2> <?=$_GET['name']
//add the where 1 part e.e >.<

if($record['dishType'] == 3)
{

$sql = "SELECT * FROM Nonvegetarian WHERE 1 AND name LIKE :name  "; //using Named Parameters to prevent SQL Injection
$namedParameters[':name'] = "%" . $record['name'] . "%";
$statement= $dbConn->prepare($sql); 
$statement->execute($namedParameters); //Always pass the named parameters, if any
$record = $statement->fetch(PDO::FETCH_ASSOC); 
 //   print_r($record);
}

if($record['dishType'] == 2)
{
$sql = "SELECT * FROM Vegetarian WHERE 1 AND name LIKE :name  "; //using Named Parameters to prevent SQL Injection
$namedParameters[':name'] = "%" . $record['name'] . "%";
$statement= $dbConn->prepare($sql); 
$statement->execute($namedParameters); //Always pass the named parameters, if any
$record = $statement->fetch(PDO::FETCH_ASSOC); 
  //  print_r($record);
}

if($record['dishType'] == 1)
{
$sql = "SELECT * FROM Dessert WHERE 1 AND name LIKE :name  "; //using Named Parameters to prevent SQL Injection
$namedParameters[':name'] = "%" . $record['name'] . "%";
$statement= $dbConn->prepare($sql);
$statement->execute($namedParameters); //Always pass the named parameters, if any
$record = $statement->fetch(PDO::FETCH_ASSOC); 
 //   print_r($record);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detailed Recipe Info </title>
    </head>
    <body style="background-color:white">
        <h2 style="color:Red">Recipe Name: </h2>
        <h2> <?=$record['name']?></h2>
        <h2 style="color:Red">Cook Time: </h2>
        <h2> <?=$record['time']?></h2>
        <h2 style="color:Red">Main Ingredient: </h2>
        <h2> <?=$record['type']?></h2>
        <h2 style="color:Red">
        <a href="<?=$record['Hyperlink']?>" target="_blank"> More Info!</a></h2>
        
        <!--insert picture maybe not-->
    </body>
</html>