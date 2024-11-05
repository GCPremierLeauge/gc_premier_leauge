
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playing 11</title>
</head>

<body>

    <div>

            <?php include "playersDetails.php"?>

            <!-- establising the connection -->
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "test";

                $teams = array(
                    2 => "LionKings",
                    1 => "Black Panthers",
                    3 => "Mighty Eagles",
                    4 => "PowerStrikers"
                );

                // check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    if (!$conn){
                        die("Connection failed: " . mysqli_connect_error());
                    }else{
                        echo "<script>console.log('Connection Established succesfully in playing11.php');</script>";
                    }
                }
            ?>
            

            <?php

            // checking the duplicate entries
            if (isset($_POST["MatchNo"])) {
                $matchNo = $_POST["MatchNo"];
                $sql = "SELECT COUNT(*) FROM MATCHDETAILS where matchNo = '$matchNo' ";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_fetch_array($result)[0];
                if($count >= 1){
                    $sql = "select isCompleted from MATCHDETAILS where matchNo=$matchNo";
                    $result = mysqli_query($conn, $sql);
                    $FisCompleted = mysqli_fetch_array($result)[0];
                    if($FisCompleted == 'YES'){
                        header('Location: matchComplete.php');
                    }
                    $matchNo = -1;
                }
            } else {
                $matchNo = -1;
            }

            
            // storing the details from the submitted form in index.php page
            $teamAname = $_POST["teamAname"];
            $teamBname = $_POST["teamBname"];
            $tossWonBy = $_POST["tossWonBy"];
            $chooseTo = $_POST["chooseTo"];
            $noOfOvers = $_POST["overs"];
            $innings = 1;


            // checking if we are entering from index page or playing 11 page

            if($matchNo != -1){
                $sql = "INSERT INTO MATCHDETAILS VALUES ('$matchNo','$teamAname','$teamBname','$tossWonBy','$chooseTo','$noOfOvers','NOT',1)";
                $query = mysqli_query($conn,$sql);
                if($query){echo "<script>console.log('succesfully inserted data into matchdetails table');</script>";}else{echo "failed to inserted data into matchdetails table";}
                $ballIdFixed = ($matchNo-1)*1000; 
                $SQL = "INSERT INTO ballByBallDetails VALUES (0,$ballIdFixed,'','','',0,0,0,0,'','',0,0,0,0,$matchNo,1)";
                $query = mysqli_query($conn,$SQL);
                if($query){echo "<script>console.log('succesfully inserted data into ballByBallDetails table');</script>";}else{echo "<script>console.log('failed to inserted data into ballByBallDetails table');</script>";}
            }else{
                
                // FETCHING THE MATCH DETAILS ,WE NEED THIS DATA BCZ IF WE REACH PLAYING 11 AGAIN WE NEED THIS DATA
                $sql1 = "SELECT matchNo, TeamAID, TeamBID, Toss, Chose,Overs,inningsNo FROM MATCHDETAILS WHERE isCompleted = 'NOT' ";
                $conn1 = mysqli_connect($servername, $username, $password, $dbname);
                $result = mysqli_query($conn1, $sql1);
                while ($row = mysqli_fetch_assoc($result)) {
                    $matchNo = $row['matchNo'];
                    $teamAname = $row["TeamAID"];
                    $teamBname = $row["TeamBID"];
                    $tossWonBy = $row["Toss"];
                    $chooseTo = $row["Chose"];
                    $noOfOvers = $row["Overs"];
                    $innings = $row["inningsNo"];
                }

                // FETCHING THE DETAILS TO ,USED IN THE FORM
                $sql1 = "SELECT total, wickets, ballNo,strikerID,nonStrikerID,bowlerID FROM ballByBallDetails ORDER BY ballID DESC LIMIT 1";
                $conn1 = mysqli_connect($servername, $username, $password, $dbname);
                $result = mysqli_query($conn1, $sql1);
                while ($row = mysqli_fetch_assoc($result)) {
                    $Ftotal = $row['total'];
                    $Fwickets = $row['wickets'];
                    $FballNo = $row['ballNo'];
                    $FstrikerID = $row['strikerID'];
                    $FnonStrikerID = $row['nonStrikerID'];
                    $FbowlerID = $row['bowlerID'];
                }
                mysqli_close($conn);
            }
        

                // print selected values
                echo "Match No: " . $matchNo . "<br>";
                echo "Team A name: " . $teams[$teamAname] . "<br>";
                echo "Team B name: " . $teams[$teamBname] . "<br>";
                echo "Toss won by " . $teams[$tossWonBy] . " and chose to " . $chooseTo . " first <br>";
                echo "No of overs: " . $noOfOvers . "<br>";


                $bat_first_team;
                $bat_second_team;
                if($chooseTo == 'bat'){
                    if($teamAname == $tossWonBy){
                        $bat_first_team = $teamAname;
                        $bat_second_team = $teamBname;
                    }else{
                        $bat_first_team = $teamBname;
                        $bat_second_team = $teamAname;
                    }
                }else{
                    if($teamAname == $tossWonBy){
                        $bat_first_team = $teamBname;
                        $bat_second_team = $teamAname;
                    }else{
                        $bat_first_team = $teamAname;
                        $bat_second_team = $teamBname;
                    }
                }
        ?>


        <?php
        $overNo = $FballNo/6;
        $Fovers = (int)$overNo.".". $FballNo%6;
        ?>

        
        <form action="submitDetails.php" method="POST">
                
            <!-- STARTING OF STRIKER NON STRIKER BOWLER   -->
            <hr>
            <?php
                    if($innings == 1){
                        echo $teams[$bat_first_team] .": $Ftotal/$Fwickets ($Fovers)<hr>";
                        echo "Striker<br>";
                        $team_id = $bat_first_team;
                        $selected_id = $FstrikerID;
                        $name_s = "striker";
                        include "team-dropdown.php";
                        echo "<br>";

                        echo "Non-Striker<br>";
                        $name_s = "nonstriker";
                        $selected_id = $FnonStrikerID;
                        $team_id = $bat_first_team;
                        include "team-dropdown.php";
                        echo "<hr>";
                        echo "Bowler<br>";
                        $name_s = "bowler";
                        $selected_id = $FbowlerID;
                        $team_id = $bat_second_team;
                        include "team-dropdown.php";
                    }else{   
                        echo $teams[$bat_second_team] .": $Ftotal/$Fwickets ($Fovers)<hr>";
                        echo "Striker<br>";
                        $name_s = "striker";
                        $selected_id = $FstrikerID;
                        $team_id = $bat_second_team;
                        include "team-dropdown.php";
                        echo "<br>";
                        echo "Non-Striker:<br>";
                        $name_s = "nonstriker";
                        $selected_id = $FnonStrikerID;
                        $team_id = $bat_second_team;
                        include "team-dropdown.php";
                        echo "<hr>";
                        echo "Bowler:<br>";
                        $name_s = "bowler";
                        $selected_id = $FbowlerID;
                        $team_id = $bat_first_team;
                        include "team-dropdown.php";
                }
            ?>
            <!-- END OF STRIKER NON STRIKER BOWLER -->
            <hr>

            <!-- BALL TYPE check boxes for extras -->
            Ball Type:
            <label for="wide">
                <input type="checkbox" id="wide" name="wide" value="1"> Wide
            </label>
            <label for="noball">
                <input type="checkbox" id="noball" name="noball" value="1"> No Ball
            </label>
            <label for="byes">
                <input type="checkbox" id="byes" name="byes" value="1"> Byes
            </label>
            <hr>
            
            <!-- runs (0-6) -->
            
            Runs:
            <?php
                for ($i = 0; $i <= 8; $i++) {
                    $checked = ($i === 0) ? 'checked' : ''; // Add this line to check the radio button with a value of 0
                    echo "<input type='radio' name='number' value='$i' required $checked>$i";
                }
            ?>
            <hr>
            
            OutType:

            <input type="radio" id="bowled" name="outype" value="bowled">
            <label for="bowled">Bowled</label>

            <input type="radio" id="stump" name="outype" value="stump">
            <label for="stump">Stump</label>

            <input type="radio" id="catch" name="outype" value="catch">
            <label for="catch">Catch</label>

            <input type="radio" id="hit-wicket" name="outype" value="hit-wicket">
            <label for="hit-wicket">Hit-wicket</label>

            <input type="radio" id="run-out" name="outype" value="run-out">
            <label for="run-out">Run-out</label>
            

            <button onClick="reset()">Reset</button>
            <br>isNonStrikerOut : <input type="checkbox" name="isNonStrikerOut" value="1" ><hr>
            isAssist : <input type="checkbox" name="assist" id="assistById" value="1" onclick="toggleDiv()"><br>

            <div id="assistByDiv" >
                Assist By:
                    <?php
                        if($innings == 1){
                            $team_id = $bat_second_team;
                            $name_s = 'assistBy';
                            include "team-dropdown.php";
                        }else{
                            $team_id = $bat_first_team;
                            $name_s = 'assistBy';
                            include "team-dropdown.php";
                        }
                    ?>  
            </div>

            <hr>
            InningsNo: <input type="text" name="inningsNo" value="<?php echo $innings ?> " readonly> <br>
            MatchNo: <input type="text" name="matchNo" value="<?php echo $matchNo ?> " readonly><hr>

            <input type="submit">
        </form>
            


        <hr>
        <form action="undo.php" method="post">
            <input type="submit" value="UNDO">
        </form>
        <hr>

    </div>


    <form action="createBatsman.php" method="post">
        <input type="text" name="inningsNo" style="display:none;" value="<?php echo $innings ?> " readonly> 
        <input type="text" name="matchNo" style="display:none;" value="<?php echo $matchNo ?> " readonly>
        <input type="text" name="batFirstTeam" style="display:none;" value="<?php echo $bat_first_team ?> " readonly>
        <input type="text" name="batSecondTeam" style="display:none;" value="<?php echo $bat_second_team ?> " readonly>
       Create batsman:
       <?php 
            if($innings == 1){
            $team_id = $bat_first_team;
            }else{
                $team_id = $bat_second_team;
            }
            $selected_id = $FstrikerID;
            $name_s = "batsManID";
            include "team-dropdown.php"; 
        ?>
        <input type="submit" value="Create Batsman">
    </form>

    <br>

    <form action="deleteBatsman.php" method="post">
        <input type="text" name="inningsNo" style="display:none;" value="<?php echo $innings ?> " readonly> 
        <input type="text" name="matchNo" style="display:none;" value="<?php echo $matchNo ?> " readonly>

       DeleteBatsman :
       <?php 
            if($innings == 1){
            $team_id = $bat_first_team;
            }else{
                $team_id = $bat_second_team;
            }
            $selected_id = $FstrikerID;
            $name_s = "batsManID";
            include "team-dropdown.php"; 
        ?>
        <input type="submit" value="Delete Batsman">
    </form>

     <br>

    <form action="createBowler.php" method="post">
        <input type="text" name="inningsNo" style="display:none;" value="<?php echo $innings ?> " readonly> 
        <input type="text" name="matchNo" style="display:none;" value="<?php echo $matchNo ?> " readonly>
        <input type="text" name="batFirstTeam" style="display:none;" value="<?php echo $bat_first_team ?> " readonly>
        <input type="text" name="batSecondTeam" style="display:none;" value="<?php echo $bat_second_team ?> " readonly>
       Create Bowler:
       <?php 
            if($innings == 2){
            $team_id = $bat_first_team;
            }else{
                $team_id = $bat_second_team;
            }
            $selected_id = $FstrikerID;
            $name_s = "bowlerId";
            include "team-dropdown.php"; 
        ?>
        <input type="submit" value="Create Bowler">
    </form>

     <br>
                
    <form action="deleteBowler.php" method="post">
        <input type="text" name="inningsNo" style="display:none;" value="<?php echo $innings ?> " readonly> 
        <input type="text" name="matchNo" style="display:none;" value="<?php echo $matchNo ?> " readonly>
        Delete Bowler:
       <?php 
            if($innings == 2){
            $team_id = $bat_first_team;
            }else{
                $team_id = $bat_second_team;
            }
            $selected_id = $FstrikerID;
            $name_s = "bowlerId";
            include "team-dropdown.php"; 
        ?>
        <input type="submit" value="Delete Bowler">
    </form>

             <br>
    
    <script>
        function reset() {
            document.getElementById("bowled").checked = false;
            document.getElementById("stump").checked = false;
            document.getElementById("catch").checked = false;
            document.getElementById("hit-wicket").checked = false;
            document.getElementById("run-out").checked = false;
        }
        var div = document.getElementById("assistByDiv");
        div.style.display = "none"
        function toggleDiv() {
                var checkbox = document.getElementById("assistById");
                var div = document.getElementById("assistByDiv");
                if (checkbox.checked == true) {
                    div.style.display = "block";
                } else {
                    div.style.display = "none";
                }
        }

        var hide = document.getElementsByClassName('hideElement');
        
    </script>

</body>
</html>