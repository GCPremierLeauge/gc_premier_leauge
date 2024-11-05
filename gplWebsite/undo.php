<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Update the database with the selected inning
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    

    /*
    BALLBYBALLDETAILS VALUES ('$DBballNo', '$DBballID', '$DBbowlerID', '$DBstrikerID', '$DBnonStrikerID', '$DBruns', '$DBwide', '$DBnoBall', '$DBbye', '$DBdismissalType', '$DBassistedBy', '$DBtotal', '$DBwickets', '$DBpartnerShip', '$DBhighlight', '$DBmatchNo', '$DBinningsNo')";
    BATSMANDETAILS (matchNo, inningsNo, batterID, outType, assistBy, bowledBy, runsScored, 0s, 1s, 2s, 3s, 4S, 5s, 6s, 7s, 8s, strikeRate, opponentTeamID, ballsFaced) ;
    BOWLERDETAILS (matchNo, inningsNo, bowlerID, ballsBowled, dots, maiden, runsConceded, wides, noballs, byes, wickets, economy, opponetTeamID ) 

    ************************************* BATTER DETAILS UNDO




    ************************************* BOWLER DETAILS UNDO

    
    */ 
    $sql = "SELECT ballNo, ballID, bowlerID, strikerID, nonStrikerID, runs, wide, noBall, bye, dismissalType, assistedBy, total, wickets, parternerShip, highlight, matchNo, inningsNo FROM ballByBallDetails ORDER BY ballID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        // Store the values of each column in the corresponding variables
        $DBballNo = $row['ballNo'];
        $DBballID = $row['ballID'];
        $DBbowlerID = $row['bowlerID'];
        $DBstrikerID = $row['strikerID'];
        $DBnonStrikerID = $row['nonStrikerID'];
        $DBruns = $row['runs'];
        $DBwide = $row['wide'];
        $DBnoBall = $row['noBall'];
        $DBbye = $row['bye'];
        $DBdismissalType = $row['dismissalType'];
        $DBassistedBy = $row['assistedBy'];
        $DBtotal = $row['total'];
        $DBwickets = $row['wickets'];
        $DBpartnerShip = $row['parternerShip'];
        $DBhighlight = $row['highlight'];
        $DBmatchNo = $row['matchNo'];
        $DBinningsNo = $row['inningsNo'];
    }


    $CONST_STRIKER_ID = $DBstrikerID;


    $sql = "SELECT matchNo, inningsNo, batterID, outType, assistBy, bowledBy, runsScored, 0s, 1s, 2s, 3s, 4S, 5s, 6s, 7s, 8s, strikeRate, opponentTeamID, ballsFaced FROM BATSMANDETAILS where batterID = '$DBstrikerID' and matchNo ='$DBmatchNo'";
    $query = mysqli_query($conn,$sql);

     
    while($row = mysqli_fetch_assoc($query)) {
        $BAmatchNo = $row["matchNo"];
        $BAinningsNo = $row["inningsNo"];
        $BAbatterID = $row["batterID"];
        $BAoutType = $row["outType"];
        $BAassistBy = $row["assistBy"];
        $BAbowledBy = $row["bowledBy"];
        $BArunsScored = $row["runsScored"];
        $BA0s = $row["0s"];
        $BA1s = $row["1s"];
        $BA2s = $row["2s"];
        $BA3s = $row["3s"];
        $BA4s = $row["4S"];
        $BA5s = $row["5s"];
        $BA6s = $row["6s"];
        $BA7s = $row["7s"];
        $BA8s = $row["8s"];
        $BAstrikeRate = $row["strikeRate"];
        $BAopponentTeamID = $row["opponentTeamID"];
        $BAballsFaced = $row["ballsFaced"];
    }
    

    $sql = "SELECT matchNo, inningsNo, bowlerID, ballsBowled, dots, maiden, runsConceded, wides, noballs, byes, wickets, economy, opponetTeamID FROM BOWLERDETAILS where matchNo = '$DBmatchNo' and bowlerID = '$DBbowlerID' ";
    $query = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($query)) {
            $BOmatchNo = $row['matchNo'];
            $BOinningsNo = $row['inningsNo'];
            $BObowlerID = $row['bowlerID'];
            $BOballsBowled = $row['ballsBowled'];
            $BOdots = $row['dots'];
            $BOmaiden = $row['maiden'];
            $BOrunsConceded = $row['runsConceded'];
            $BOwides = $row['wides'];
            $BOnoballs = $row['noballs'];
            $BObyes = $row['byes'];
            $BOwickets = $row['wickets'];
            $BOeconomy = $row['economy'];
            $BOopponetTeamID = $row['opponetTeamID'];
             echo "<br>finished the entering11";
    }

    echo "<br>DDfinished the entering2";
    // 


        if ($DBbye == 1){
            $BAballsFaced --;
        }
        else if ($DBwide == 0 && $DBbye == 0){
            $BAballsFaced --;
            $BArunsScored -= $DBruns;
            switch ($DBruns) {
            case "0":
                $BA0s --;
                break;
            case "1":
                $BA1s --;
                break;
            case "2":
                $BA2s --;
                break;
            case "3":
                $BA3s --;
                break;
            case "4":
                $BA4s --;
                break;
            case "5":
                $BA5s --;
                break;
            case "6":
                $BA6s --;
                break;
            case "7":
                $BA7s --;
                break;
            case "8":
                $BA8s --;
                break;
            }
        }
        echo "<br>DDfinished the entering3";
        if ($DBdismissalType != ''){
            $BAoutType = 'notout';
            $BAbowledBy = '';
            $BAoutType = '';
            $BAassistBy = '';
        }
        if($BAballsFaced == 0){
            $BAstrikeRate = 0;
        }else{
        $BAstrikeRate = $BArunsScored*100 / $BAballsFaced;
        }

        // BOWLER DETAILS UNDO

        if ($DBbye == 1 && $DBnoBall == 1){
            $BOrunsConceded --;
            $BOnoballs --;
        }
        else if ($DBbye == 1){
            $BOballsBowled --;
            $BObyes -= $DBruns ;
        }
        else if ($DBwide == 1){
            $BOrunsConceded -= $DBruns + 1;
            $BOwides -= $DBruns + 1;
        }
        else if ($DBnoBall == 1){
            $BOrunsConceded -= $DBruns + 1;
            $BOnoballs --;
        }
        else{
            $BOballsBowled --;
            $BOrunsConceded -= $DBruns;
        }
        if ($DBdismissalType != '' && $DBdismissalType != "run-out") {
            $BOwickets --;
        }
        if ($DBruns == 0){
            $BOdots --;
        }
        if ($BOballsBowled == 0){
            $BOeconomy = 0;
        }
        else{
            $BOeconomy = ($BOrunsConceded * 6)/$BOballsBowled;
        }
        echo "<br>DDfinished the entering4";
    
    $sql = "UPDATE BATSMANDETAILS SET
            outType = '$BAoutType', 
            assistBy = '$BAassistBy', 
            bowledBy = '$BAbowledBy', 
            runsScored = '$BArunsScored', 
            0s = '$BA0s',
            1s = '$BA1s',
            2s = '$BA2s',
            3s = '$BA3s',
            4S = '$BA4s',
            5s = '$BA5s',
            6s = '$BA6s',
            7s = '$BA7s',
            8s = '$BA8s',
            strikeRate = '$BAstrikeRate',
            ballsFaced = '$BAballsFaced'
          WHERE 
            matchNo = '$BAmatchNo' AND  
            batterID = '$DBstrikerID'";
            
    $query = mysqli_query($conn,$sql);
    echo "<br>DDfinished the entering5";
    $sql = "UPDATE BOWLERDETAILS SET matchNo='$BOmatchNo', inningsNo='$BOinningsNo', bowlerID='$BObowlerID', ballsBowled='$BOballsBowled', dots='$BOdots', maiden='$BOmaiden', runsConceded='$BOrunsConceded', wides='$BOwides', noballs='$BOnoballs', byes='$BObyes', wickets='$BOwickets', economy='$BOeconomy', opponetTeamID='$BOopponetTeamID' WHERE matchNo = '$DBmatchNo' AND bowlerID = '$DBbowlerID'";
    $result = mysqli_query($conn, $sql);
        echo "<br>DDfinished the entering2112";
    $sql = "DELETE FROM ballByBallDetails WHERE ballID = (SELECT MAX(ballID) FROM ballByBallDetails WHERE NOT ballNo = 0)";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

}


?>

<form id ="undoChange" action="playing11.php" method="post">
    <input type="submit" value="goBack">
</form>

<script type="text/javascript">
    document.getElementById('undoChange').submit(); // SUBMIT FORM
</script>