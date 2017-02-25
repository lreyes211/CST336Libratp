<?php

function WinningTotal ($Winner,$S1, $S2,$S3,$S4) {
    if ($Winner[0] == "Everyone Busted!") {
        $Totals = array();
        $Totals[] = 0;
        return $Totals;
    }
    else {
        $Amount = array();
        $Amount[] = $S1;
        $Amount[] = $S2;
        $Amount[] = $S3;
        $Amount[] = $S4;
        $P = array("Linda", "Tyler", "Yashkaran", "Seth");
        $Totals = array();
        
        for ($i = 0; $i < count($Winner); $i++) {
            for ($j = 0; $j < count($Amount); $j++) {
                if ($Winner[$i] != $P[$j]) {
                    $Totals[$i] += $Amount[$j];
                }
            }
        }
        return $Totals;
    }
}
    
function FindWin ($S1, $S2,$S3,$S4,&$Winners) {
    $Win_score = CalcWin ($S1, $S2, $S3, $S4);
    if ($Win_score == -1) {
        $Winners[] = "Everyone Busted!";
    }
    else {
        $P = array("Linda", "Tyler", "Yashkaran", "Seth");
        $Amount = array();
        $Amount[] = $S1;
        $Amount[] = $S2;
        $Amount[] = $S3;
        $Amount[] = $S4;
        
        for ($i = 0; $i < count($P); $i++) {
            if ($Amount[$i] == $Win_score) {
                $Winners[] = $P[$i];
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <Style> @import url("/Labs/Lab3/CSS/Styles.css");</Style>
        <title> CST336 SilverJack </title>
    </head>
    
    <body>
        <?php
        $Deck = array();
        $Amount = array();
        $P1C[0] = "/Linda.jpg";
        $P2C[0] = "/Tyler.jpg";
        $P3C[0] = "/Yashkaran.jpg";
        $P4C[0] = "/Seth.jpg";
        
        echo "<h1> Silver Jack </h1>";
        echo "<br />";
        for ($j = 0; $j < 4; $j++) {
            echo "<table>";
            $HoldIndex = 0;
            $HoldArray = RandPlayersDisplay ($prevDisplay, $HoldIndex);
            echo "<tr><td> <img src='Img/$HoldArray[0]'/>";
            $Amount[$HoldIndex] = 0;
            
            for ($i = 0; DeckTotal($HoldArray) < 42 ; $i++) {
                if (abs(42 - DeckTotal($HoldArray) < 7)) {
                    break;
                }
                Carddisplay($HoldArray,$Deck);
                $Amount[$HoldIndex] = DeckTotal ($HoldArray);
            }
            
            echo "<text>". $P[$HoldIndex] . "  " . "<b>&nbsp;&nbsp;$Amount[$HoldIndex]</b>" . "</text>";
            echo "<br />";
            $HoldIndex = 0;
            echo "</tr></td>";
            echo "</table>";
        }   
        
        $Winners = array();
        FindWin($Amount[0], $Amount[1], $Amount[2], $Amount[3], $Winners);
        $Totals = WinningTotal($Winners, $Amount[0], $Amount[1], $Amount[2], $Amount[3]);
        echo "<h2 id=Winner style=color:white;> $Winners[0] wins $Totals[0] points!</h2>";
        echo "<br/>";
        ?>
        
        <form method="GET">
        <input type="submit" name="submitForm" value="Rematch"/>
        </form>
        
        
        <br />
        <br />
        <div id="wrapper">
            
        <b>Rules:</b> <br />
        Each player draws cards until the sum of the cards is <i> close enough</i> to 42 or has just exceeded 42.
        Jack is worth 11 points, Queen 12, King 13, Ace 1.
        When the sum of card values exceeds 42, the player loses the game automatically (bust).
        The player(s) with the sum of card values <b> equal or lower </b> and closer to 42 win(s) the sum of the points <b> made by the other players.</b>
        </div>
        <br />
        <br />
        
        <footer>
        <hr>    
        2017 &copy; Linda, Tyler, Yashkaran <br /> 
        Disclaimer: All material above is used for teaching purposes. Information might be inaccurate.
    
        <br />
    
        <img src = "../../Img/CSUMBlogo.png" alt = "CSUMB logo" />
    
        </footer>
        
    </body>
    
</html>