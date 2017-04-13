<?php
session_start();

    include '../Connect.php';
    $dbConn = getDBConnection("Recipe");
    //include 'functions.php';
    
    //session_destroy();
    if(isset($_GET['cart']))
    {
        //var_dump($_SESSION['cart']);
        if(empty($_SESSION['cart']))
        {
            $_SESSION['cart']= array();//makes array
            //array_push($_SESSION['cart'], 5);
            //var_dump($_SESSION['cart']);
            
        }
        
        if(isset($_GET['nums']))
        {
            echo "Nums: " . $_GET['nums'];
            foreach($_GET['nums'] as $num)
        {
            echo $num;
            array_push($_SESSION['cart'], $num);
            
        }
        var_dump($_SESSION['cart']);
        }
        else{
            echo "**empty";
        }
        
    }
    
    function getRecipes() {
        global $dbConn;
        $sql = "SELECT * FROM Catalog WHERE 1";
        $sql .=" AND name LIKE :name ";
        $namedParameters[':name'] = '%' . $_GET['recipeName'] . '%';//searching
        
        if (!empty($_GET['sortType'])) {
            $sql .=" ORDER BY type ASC ";
        }
    
        else {
            $sql .=" ORDER BY name ASC ";
        }
        
        $stmt = $dbConn -> prepare ($sql);
        $stmt -> execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }
    
    function getTypes() {
        global $dbConn;
        $sql = "SELECT DISTINCT(type) FROM Catalog WHERE 1";
        $sql .=" AND type LIKE :type ";
        $namedParameters[':type'] = '%' . $_GET['recipeType'] . '%';
        $stmt = $dbConn -> prepare ($sql);
        $stmt -> execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }
    
?>


<!DOCTYPE html>
<html>
    <head>
        <title> CST336 Libra </title>
        <style type="text/css">
        @import url("/Teamproject/CSS/Styles.css");
        </style>
    </head>
    <body>
        <h1> Recipe Book à La Libra </h1>
        <form>
            Recipe Name: <input type="text" name="recipeName"/>
            <select name="recipeType">
            <option value="">Specify Type</option>
            <?php
            $recipeTypes = getTypes();
            foreach ($recipeTypes as $recipeType) {
            echo "<option>" . $recipeType['type'] . "</option>";
            }
            ?>
            </select>
                    
            <br /><br />
            Sort: 
                <input type="radio" name="sortType" value="type">Type
                <br /><br />
                <input type="submit" name = "search" value="Search" />
                <input type="submit" name = "cart" value="Add Selected to Cart" />
                <br /><br />
<div style="float:left">
        <table>
            <?php
            
            // echo "<a href='userInfo.php?userId=".$user['userId']."' target='userInfoFrame'>" . $user['firstName'] . "</a> ";
            //echo "<a href='' onclick='window.open(\"userInfo.php?userId=".$user['userId']." \", \"userWindow\", \"width=200, height=200\" )'>" 
            
            $recipe = getRecipes();
            echo "<tr> <th> List # </th><th></th><th> Name of Recipe </th><th> Cook Time </th><th> Type of Dish </th></tr>";    
            foreach($recipe as $recipe) {
               echo "<tr><td>". $recipe['number'] ." </td><td> <input type='checkbox' name='nums[]' value='". $recipe['number'] ."'></td><td><a href='catalogInfo.php?name=".$recipe['name']."' target='InfoFrame'>".$recipe['name'] . "</a>";
               echo "</td><td>".$recipe['time']  . "</td><td>" . $recipe['type'] . "</td></tr>";
            }
            ?>
        </table>
        </div>
        </form>
        <span class="menu">
            <?= "<a href='Cart.php'>Cart(" . count($_SESSION["cart"]) .")</a>" ?>
        </span>
        <br />
        <hr>
        <br />

        <div style="float:right">
            <iframe src="" width="400" height="400" name="InfoFrame" align="middle" scrolling="auto"> </iframe>
        </div>

        </body>
        <br /><br /> 
            <footer style="clear:left">
        <hr>  
            2017 &copy; Tyler Chargin, Yashkaran Singh, Linda Reyes 
        <br /> 
            Disclaimer: All material above is used for teaching purposes. Information might be inaccurate. All recipes taken from: http://allrecipes.com/
        <br />
            <img src = "../../Img/CSUMBlogo.png" alt = "CSUMB logo" />
        </footer>
</html>
