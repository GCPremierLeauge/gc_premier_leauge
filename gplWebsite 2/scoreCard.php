<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta http-equiv="refresh" content="1"> -->

    <title>Document</title>
</head>
<body>
    
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check for errors
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $teams = array(
                    2 => "LionKings",
                    1 => "Black Panthers",
                    3 => "Mighty Eagles",
                    4 => "PowerStrikers"
        );
    ?>
    <?php
    $matchNo = $_POST['matchNo'];
    $totalOvers = $_POST['overs'];
    $teamAId = $_POST['teamAID'];
    $teamBId = $_POST['teamBID'];
    


    $sql = "SELECT playerId, playerName FROM playerdetails";
    $result = mysqli_query($conn, $sql);

    // Create the associative array
    $players = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $players[$row["playerId"]] = $row["playerName"];
    }
    
        echo "<h3> Match $matchNo | $teams[$teamAId] v/s $teams[$teamBId] </h3>";

        echo "<hr>";
        
        $sql = "SELECT inningsNo FROM ballByBallDetails where matchNo = $matchNo ORDER BY ballID DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $inningsNo = $row['inningsNo'];
        }

        // Fetch total score of innings 1 
        $sql = "SELECT ballNo,wickets,total FROM ballByBallDetails where matchNo = $matchNo and inningsNo= 1 ORDER BY ballID DESC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $FballNo = $row['ballNo'];
            $Fwickets = $row['wickets'];
            $Ftotal = $row['total'];
        }
        $overNo = $FballNo/6;
        $overs = (int)$overNo.".". $FballNo%6;

        ECHO "SCORE : $Ftotal / $Fwickets    ($overs)<br>";
        // ECHO "Overs: " .$overs ."<br>"; 
        // ECHO "Total: " .$Ftotal ."<br>"; 
        // ECHO "Wickets: " .$Fwickets ."<br>"; 


        $sql = "SELECT batterID,outType,runsScored, ballsFaced, 4s, 6s FROM BATSMANDETAILS WHERE matchNo = '$matchNo' and inningsNo =1";
        $result = mysqli_query($conn, $sql);
        // echo "<table>";
        // echo "<tr><th>batterID</th><th>outType</th><th>runsScored</th><th>ballsFaced</th><th>4s</th><th>6s</th></tr>";
        echo "<br><b>BATTING DETAILS</b><br>";
        echo "<table style='border: 1px solid black;'>";
        echo "<tr style='border: 1px solid black;'><th style='border: 1px solid black;'>batterID</th><th style='border: 1px solid black;'>outType</th><th style='border: 1px solid black;'>runsScored</th><th style='border: 1px solid black;'>ballsFaced</th><th style='border: 1px solid black;'>4s</th><th style='border: 1px solid black;'>6s</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr style='border: 1px solid black;'>";
            echo "<td style='border: 1px solid black;'>" . $players[$row['batterID']] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['outType'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['runsScored'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['ballsFaced'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['4s'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['6s'] . "</td>";
            echo "</tr>";
        }
        // while ($row = mysqli_fetch_assoc($result)) {
        //     echo "<tr>";
        //     echo "<td>" . $players[$row['batterID']] . "</td>";
        //     echo "<td>" . $row['outType'] . "</td>";
        //     echo "<td>" . $row['runsScored'] . "</td>";
        //     echo "<td>" . $row['ballsFaced'] . "</td>";
        //     echo "<td>" . $row['4s'] . "</td>";
        //     echo "<td>" . $row['6s'] . "</td>";
        //     echo "</tr>";
        // }
        echo "</table>";

        echo "<br><b>BOWLER DETAILS</b><br>";
        $sql = "SELECT bowlerID,ballsBowled,runsConceded,wickets,maiden,economy from BOWLERDETAILS where matchNo = '$matchNo' and inningsNo = 1;";
        $result = mysqli_query($conn, $sql);

        echo "<table style='border: 1px solid black;'>";
        echo "<tr><th style='border: 1px solid black;'>Bowler ID</th><th style='border: 1px solid black;'>Overs</th><th style='border: 1px solid black;'>Runs Conceded</th><th style='border: 1px solid black;'>Wickets</th><th style='border: 1px solid black;'>Maiden</th><th style='border: 1px solid black;'>Economy</th></tr>";

        // echo "<tr><th>Bowler ID</th><th>Overs</th><th>Runs Conceded</th><th>Wickets</th><th>Maiden</th><th>Economy</th></tr>";
        // while($row = mysqli_fetch_assoc($result)) {
        //     $overNo = $row["ballsBowled"]/6;
        //     $oversBowled = (int)$overNo.".". $row["ballsBowled"]%6;
        //     echo "<tr><td>".$players[$row["bowlerID"]]."</td><td>".$oversBowled."</td><td>".$row["runsConceded"]."</td><td>".$row["wickets"]."</td><td>".$row["maiden"]."</td><td>".$row["economy"]."</td></tr>";
        // }
        while($row = mysqli_fetch_assoc($result)) {
            $overNo = $row["ballsBowled"]/6;
            $oversBowled = (int)$overNo.".". $row["ballsBowled"]%6;
            echo "<tr style='border: 1px solid black;'><td style='border: 1px solid black;'>".$players[$row["bowlerID"]]."</td><td style='border: 1px solid black;'>".$oversBowled."</td><td style='border: 1px solid black;'>".$row["runsConceded"]."</td><td style='border: 1px solid black;'>".$row["wickets"]."</td><td style='border: 1px solid black;'>".$row["maiden"]."</td><td style='border: 1px solid black;'>".$row["economy"]."</td></tr>";
        }
        echo "</table>";



        if($inningsNo == 2){

            echo "<hr> 2nd innings<br>";
            $target = $Ftotal+1;
            $sql = "SELECT ballNo,wickets,total FROM ballByBallDetails where matchNo = $matchNo and inningsNo= 2 ORDER BY ballID DESC LIMIT 1";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $FballNo = $row['ballNo'];
                $Fwickets = $row['wickets'];
                $Ftotal = $row['total'];
            }

            $overNo = $FballNo/6;
            $overs = (int)$overNo.".". $FballNo%6;


            $ballsRemaining = $totalOvers*6 -$FballNo;

            ECHO "SCORE : $Ftotal / $Fwickets    ($overs)<br>";
            ECHO "TARGET : " .$target ."<br>";
            echo "Required ".$target-$Ftotal." in ". $ballsRemaining. " balls";
            // ECHO "Overs: " .$overs ."<br>"; 
            // ECHO "Total: " .$Ftotal ."<br>"; 
            // ECHO "Wickets: " .$Fwickets ."<br>"; 

            


        $sql = "SELECT batterID,outType,runsScored, ballsFaced, 4s, 6s FROM BATSMANDETAILS WHERE matchNo = '$matchNo' and inningsNo =2";
        $result = mysqli_query($conn, $sql);
        echo "<br><b>BATTING DETAILS</b><br>";
        echo "<table style='border: 1px solid black;'>";
        echo "<tr style='border: 1px solid black;'><th style='border: 1px solid black;'>batterID</th><th style='border: 1px solid black;'>outType</th><th style='border: 1px solid black;'>runsScored</th><th style='border: 1px solid black;'>ballsFaced</th><th style='border: 1px solid black;'>4s</th><th style='border: 1px solid black;'>6s</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr style='border: 1px solid black;'>";
            echo "<td style='border: 1px solid black;'>" . $players[$row['batterID']] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['outType'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['runsScored'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['ballsFaced'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['4s'] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row['6s'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<br><b>BOWLER DETAILS</b><br>";
        $sql = "SELECT bowlerID,ballsBowled,runsConceded,wickets,maiden,economy from BOWLERDETAILS where matchNo = '$matchNo' and inningsNo = 2;";
        $result = mysqli_query($conn, $sql);



        echo "<table style='border: 1px solid black;'>";
        echo "<tr><th style='border: 1px solid black;'>Bowler ID</th><th style='border: 1px solid black;'>Overs</th><th style='border: 1px solid black;'>Runs Conceded</th><th style='border: 1px solid black;'>Wickets</th><th style='border: 1px solid black;'>Maiden</th><th style='border: 1px solid black;'>Economy</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $overNo = $row["ballsBowled"]/6;
            $oversBowled = (int)$overNo.".". $row["ballsBowled"]%6;
            echo "<tr style='border: 1px solid black;'><td style='border: 1px solid black;'>".$players[$row["bowlerID"]]."</td><td style='border: 1px solid black;'>".$oversBowled."</td><td style='border: 1px solid black;'>".$row["runsConceded"]."</td><td style='border: 1px solid black;'>".$row["wickets"]."</td><td style='border: 1px solid black;'>".$row["maiden"]."</td><td style='border: 1px solid black;'>".$row["economy"]."</td></tr>";
        }
        echo "</table>";

        }

    ?>
        <form action="scoreCard.php" method="post" id = "seeScores" style="display: none";>
            <input type="text" name="matchNo" value="<?php echo $matchNo ?>" >
            <input type="text" name="teamAID" value="<?php echo $teamAId ?>" >
            <input type="text" name="teamBID" value="<?php echo $teamBId ?>" >
            <input type="text" name="overs" value="<?php echo $totalOvers ?>" >
            <input type="submit">
        </form>
        <script>
        setTimeout(function() {
            document.getElementById("seeScores").submit();
        }, 2000);
        </script>

</body>

</html>