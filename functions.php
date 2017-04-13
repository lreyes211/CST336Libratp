<?php

//https://cst336tchargin-tchargin.c9users.io/phpmyadmin/
include '../Connect.php';

$dbConn = getDBConnection("Recipe");

$search = "";

if(isset($_GET['search']))  // will be called only when search button is pressed
{
    global $search;
    $search = "search";
    search();
    //getRecipes();
    //filterRecipe();
}

function search()  // will print entire table
{
    global $search;
    if($search!="")
    {
        $recipe = getRecipes();
        //$recipe = filterRecipe();
        foreach($recipe as $recipe) 
        {
            echo $recipe['name'] . "   " . $recipe['time']  . "   " . $device['type'] . "<br />";
        }
        
    }
}

function getRecipes()
{
    global $dbConn;
    $sql = "SELECT * FROM Vegetarian natural join Nonvegetarian WHERE 1";
    
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute( );
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
    
    //print_r ($records);
    //echo $records;
}

function filterRecipe()
{
    global $dbConn;
    $sql = "SELECT * from Catalog where 1";
    if (isset($_GET['recipeName']) ) { //"status checkbox was checked"
        
        $sql .= " AND name = :name";
        $namedParameters[':name'] = $_GET['recipeName'];
            
    }
        
    if (!empty($_GET['recipeType']) ) {
        
        $sql .=" AND type = :recipeType ";
        $namedParameters[':recipeType'] = $_GET['recipeType'];
            
    }
        
    if (!empty($_GET['sortBy']) ) {
        
        $sql .=" ORDER BY ".$_GET['sortBy']." ASC ";
            
    }
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute($namedParameters);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $records;
}
?>