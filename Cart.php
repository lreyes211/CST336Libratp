<?php
// Start the session
session_start();
require_once('../Connect.php');
$dbConn = getDBConnection("Recipe");


if(isset($_GET['clearCart'])) {
        session_destroy();
}

function displayCart() {
    global $dbConn;
        if (!empty($_SESSION['cart'])) {
        $_SESSION['cart'];
        $sql= "select * from Catalog where number in (";
        
        foreach ($_SESSION['cart'] as $inv) {
       // echo $inv . " ";
        $sql .= (int)$inv. ","; //$int = (int)$num;
        
            }
        
        $sql[strlen($sql)-1] = ")";
        //echo $sql;
        
        $stmt = $dbConn -> prepare ($sql);
        $stmt -> execute( );
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $records;
        
        }
        
        else {
            return NULL;
        }
    }
    
?>

<html>
    <head>
        <title>Cart - Recipe Cart </title>
        <style type="text/css">
        @import url("/Teamproject/CSS/Styles.css");
        </style>
    </head>
    
<main>
    <div class="center">
        <header class="logo">
           <h1>Recipe Cart</h1>
        </header>
        <span class="menu">
            <span class="home">
                <a href='/Teamproject/Recipe.php'>Home</a>  
            </span>
        </span>
        <form>
        <input type="submit" name= "clearCart" value="Empty Cart" />
        </form>
        <body>
            <br/>
            <h1>Your cart contains:</h1>
            <div style="float:left">
        <table>
            <?php
            
            // echo "<a href='userInfo.php?userId=".$user['userId']."' target='userInfoFrame'>" . $user['firstName'] . "</a> ";
            //echo "<a href='' onclick='window.open(\"userInfo.php?userId=".$user['userId']." \", \"userWindow\", \"width=200, height=200\" )'>" 
            
            $recipes = displayCart();
            if ($recipes != NULL) {
            echo "<tr> <th> List # </th><th> Name of Recipe </th><th> Cook Time </th><th> Type of Dish </th></tr>";    
            foreach($recipes as $recipe) {
               echo "<tr><td>". $recipe['number'] ."</td><td><a href='catalogInfo.php?name=".$recipe['name']."' target='InfoFrame'>".$recipe['name'] . "</a>";
               echo "</td><td>".$recipe['time']  . "</td><td>" . $recipe['type'] . "</td></tr>";
            }
            }
            else {
                echo "Nothing!";
            }
            ?>
        </table>
        </div>

    </body>
    </div>
       <div style="float:right">
            <iframe src="" width="400" height="400" name="InfoFrame" align="middle" scrolling="auto"> </iframe>
        </div>

    
        <footer>
        
        <br /><br />
        </footer>
</main>
</html>