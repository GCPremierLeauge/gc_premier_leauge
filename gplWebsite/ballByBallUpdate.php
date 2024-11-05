<form id ="formCI" action="changeInnings.php" method="post">
    <input type="submit" value="Change inning">
</form>

<?php
$DBballNo;
$DBballID;
$DBbowlerID;
$DBstrikerID;
$DBnonStrikerID;
$DBruns;
$DBwide = 0;
$DBnoBall = 0;
$DBbye = 0;
$DBdismissalType = '';
$DBassistedBy = '';
$DBtotal;
$DBwickets;
$DBpartnerShip;
$DBhighlight = 0;
$DBmatchNo = -1;
$DBinningsNo = -1;
?>

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

    echo "Entered in ball by ball update";
    $sql = "SELECT ballNo, ballID, total, wickets, parternerShip FROM ballByBallDetails ORDER BY ballID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
            $DBballNo = $row['ballNo'];
            $DBballID = $row['ballID'];
            $DBtotal = $row['total'];
            $DBwickets = $row['wickets'];
            $DBpartnerShip = $row['parternerShip'];
    }
?>


<?php

$DBballID ++;
$DBbowlerID = $bowler;
$DBstrikerID = $striker;
$DBnonStrikerID = $non_striker;

$CONSTBATSMANID = $DBstrikerID;
$CONSTBOWLERID = $DBbowlerID;
$CONSTNONSTRIKERID = $DBnonStrikerID;

$DBinningsNo = $inningsNumber;
$DBmatchNo = $matchNumber;

if ($outType != 'NOTOUT'){
    $DBdismissalType = $outType;
    $DBwickets ++;
    $DBpartnerShip = 0;
    $DBhighlight = 1;
    if ($outType == 'run-out' || $outType == 'catch' || $outType == 'stump'){
        $DBassistedBy = $assistBy;
    }
    else {
        $runs = 0;
    }
}

if ($isWide == 1){
    $DBwide = 1;
    $DBruns = $runs;
    $DBtotal += $runs + 1;
    $DBpartnerShip += $runs + 1;
    $DBbye = 0;
}
else if ($isNoBall == 1){
    $DBtotal ++;
    $DBnoBall = 1;
    $DBpartnerShip ++;
    $DBruns = $runs;
    $DBtotal += $runs;
    $DBpartnerShip += $runs;
    if ($isByes == 1){
        $DBbye = 1;
    }
}
else if ($isByes == 1){
    $DBtotal += $runs;
    $DBruns = $runs;
    $DBbye = 1;
    $DBpartnerShip += $runs;
    $DBballNo += 1;
}
else {
    $DBtotal += $runs;
    $DBpartnerShip += $runs;
    $DBballNo += 1;
    $DBruns = $runs;
}

// ee logic ardham kaledha,murali ki jyothi ki phone cheyy
$a = $runs % 2 == 1 && $DBballNo%6 != 0;
$b = $DBballNo%6 == 0 && ($runs % 2 == 1 && ($isWide == 1 || $isNoBall == 1));
$c = $DBballNo%6 == 0 && ($runs % 2 == 0 && ($isWide == 0 && $isNoBall == 0));

if ($a || $b || $c){
    $dummy = $striker;
    $DBstrikerID = $non_striker;
    $DBnonStrikerID = $dummy;
}

if ($runs >= 4){
    $DBhighlight = 1;
}

?>

<!-- <?php
    echo "<br>printing names<br>";
    echo "DBballNo: " . $DBballNo . "<br>";
    echo "DBballID: " . $DBballID . "<br>";
    echo "DBbowlerID: " . $DBbowlerID . "<br>";
    echo "DBstrikerID: " . $DBstrikerID . "<br>";
    echo "DBnonStrikerID: " . $DBnonStrikerID . "<br>";
    echo "DBruns: " . $DBruns . "<br>";
    echo "DBwide: " . $DBwide . "<br>";
    echo "DBnoBall: " . $DBnoBall . "<br>";
    echo "DBbye: " . $DBbye . "<br>";
    echo "DBdismissalType: " . $DBdismissalType . "<br>";
    echo "DBassistedBy: " . $DBassistedBy . "<br>";
    echo "DBtotal: " . $DBtotal . "<br>";
    echo "DBwickets: " . $DBwickets . "<br>";
    echo "DBpartnerShip: " . $DBpartnerShip . "<br>";
    echo "DBhighlight: " . $DBhighlight . "<br>";
    echo "DBmatchNo: " . $DBmatchNo . "<br>";
    echo "DBinningsNo: " . $DBinningsNo . "<br>";

?> -->

<?php
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "INSERT INTO BALLBYBALLDETAILS VALUES ('$DBballNo', '$DBballID', '$DBbowlerID', '$DBstrikerID', '$DBnonStrikerID', '$DBruns', '$DBwide', '$DBnoBall', '$DBbye', '$DBdismissalType', '$DBassistedBy', '$DBtotal', '$DBwickets', '$DBpartnerShip', '$DBhighlight', '$DBmatchNo', '$DBinningsNo')";
    $query = mysqli_query($conn,$sql);
    // echo "<script>console.log('ballbyball detail update succesful')</script>";// ;}else{echo "Error Occured";}
    // echo 

    echo "<br>finished the entering";

    // fetch from the batsman details table
    $sql = "SELECT matchNo, inningsNo, batterID, outType, assistBy, bowledBy, runsScored, 0s, 1s, 2s, 3s, 4S, 5s, 6s, 7s, 8s, strikeRate, opponentTeamID, ballsFaced FROM BATSMANDETAILS where batterID = '$CONSTBATSMANID' and matchNo ='$DBmatchNo'";
    $query = mysqli_query($conn,$sql);

     echo "<br>finished the entering2";
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
    // complete fetching 
     echo "<br>finished the entering3";
    // update to batsman
    
        if ($DBwide == 0 && $DBbye == 0){
            $BAballsFaced ++;
            $BArunsScored += $DBruns;
            switch ($DBruns) {
            case "0":
                $BA0s ++;
                break;
            case "1":
                $BA1s ++;
                break;
            case "2":
                $BA2s ++;
                break;
            case "3":
                $BA3s ++;
                break;
            case "4":
                $BA4s ++;
                break;
            case "5":
                $BA5s ++;
                break;
            case "6":
                $BA6s ++;
                break;
            case "7":
                $BA7s ++;
                break;
            case "8":
                $BA8s ++;
                break;
            }
        }
     

        if ($DBbye == 1){
            $BAballsFaced ++;
        }
        if ($DBdismissalType != ''){
            $BAbowledBy = $DBbowlerID;
            $BAoutType = $DBdismissalType;
            $BAassistBy = $DBassistedBy;
        }

        else{
            $BAoutType = "NOTOUT";
        }
        // echo "<br>finished the entering31";
        if($BAballsFaced == 0){
            $BAstrikeRate = 0;
        }else{
        $BAstrikeRate = $BArunsScored*100 / $BAballsFaced;
        }
    // completed updating the variables

 echo "<br>finished the entering4";
    
    // push into database
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
            inningsNo = '$BAinningsNo' AND 
            batterID = '$CONSTBATSMANID' ";
            
    $query = mysqli_query($conn,$sql);

    // complete push into database
         echo "<br>finished the entering5";

    /*** FETCH BOWLER DETAILS FROM THE DATABASE */

    // echo $bowler ."dadsf <br>";
    // $sql = "SELECT matchNo, inningsNo, bowlerID, ballsBowled, dots, maiden, runsConceded, wides, noballs, byes, wickets, economy, opponetTeamID FROM BOWLERDETAILS where matchNo = '$DBmatchNo' and bowlerID = '$DBbowlerID' ";
    
    $sql = "SELECT matchNo, inningsNo, bowlerID, ballsBowled, dots, maiden, runsConceded, wides, noballs, byes, wickets, economy, opponetTeamID FROM BOWLERDETAILS where matchNo = '$DBmatchNo' and bowlerID = '$DBbowlerID' ";
    $query = mysqli_query($conn,$sql);
     echo "<br>finished the entering6";
    // echo "<script>console.log($DBbowlerID);</script>";
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
    echo "<br>finished the entering7";
    

    
    // update to bowler
        if ($isNoBall == 1 && $isByes == 1){
            $BOnoballs ++;
            $BOrunsConceded +=  1;

        }
        else if ($isByes == 1){
            $BOballsBowled ++;
            $BObyes += $DBruns ;
        }
        else if ($isWide == 1){
            $BOrunsConceded += $DBruns + 1;
            $BOwides += $DBruns + 1;
        }
        else if ($isNoBall == 1){
            $BOrunsConceded += $DBruns + 1;
            $BOnoballs ++;
        }
        else{
            $BOballsBowled ++;
            $BOrunsConceded += $DBruns;
        }
         echo "<br>finished the entering122";
        if ($DBdismissalType != '' && $DBdismissalType != "run-out") {
            $BOwickets ++;
        }
        echo "<br>finished the entering123";
        if ($DBruns == 0){
            $BOdots ++;
        }
        if ($BOballsBowled == 0){
            $BOeconomy = 0;
        }
        else{
            $BOeconomy = ($BOrunsConceded * 6)/$BOballsBowled;
        }
        // $BOeconomy = ($BOrunsConceded * 6)/$BOballsBowled;
    echo "<br>finished the entering125";

    echo "Match No: $BOmatchNo <br>";
    echo "Innings No: $BOinningsNo <br>";
    echo "Bowler ID: $BObowlerID <br>";
    echo "Balls Bowled: $BOballsBowled <br>";
    echo "Dots: $BOdots <br>";
    echo "Maiden: $BOmaiden <br>";
    echo "Runs Conceded: $BOrunsConceded <br>";
    echo "Wides: $BOwides <br>";
    echo "No Balls: $BOnoballs <br>";
    echo "Byes: $BObyes <br>";
    echo "Wickets: $BOwickets <br>";
    echo "Economy: $BOeconomy <br>";
    echo "Opponent Team ID: $BOopponetTeamID <br>";

    // update them in database
    
    $sql = "UPDATE BOWLERDETAILS SET matchNo='$BOmatchNo', inningsNo='$BOinningsNo', bowlerID='$BObowlerID', ballsBowled='$BOballsBowled', dots='$BOdots', maiden='$BOmaiden', runsConceded='$BOrunsConceded', wides='$BOwides', noballs='$BOnoballs', byes='$BObyes', wickets='$BOwickets', economy='$BOeconomy', opponetTeamID='$BOopponetTeamID' WHERE matchNo = '$DBmatchNo' AND inningsNo = '$inningsNumber' AND bowlerID = '$bowler'";
    $result = mysqli_query($conn, $sql);

// 


    $sql = "SELECT Overs FROM `MATCHDETAILS` WHERE matchNo = $DBmatchNo";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
            $Fovers = $row['Overs'];
    }
    echo "<br>Fovers" .$Fovers;
    $overNo = $DBballNo/6;
    if ((int)$overNo == $Fovers || $DBwickets == 10){
        if ($DBinningsNo == 2){
            echo "<br>entered if loop innings 2";
            $sql = "UPDATE MATCHDETAILS SET isCompleted = 'YES' WHERE matchNo= $DBmatchNo";
            $query = mysqli_query($conn,$sql);
            header('Location: matchComplete.php');
            echo "success"; 
        }else{
            echo "<br>entered if loop";
            echo "hii there";
            echo "<script type='text/javascript'>document.getElementById('formCI').submit();</script>";
        }
    }
?>




<!-- <script type='text/javascript'>document.getElementById('formCI').submit();</script> -->
    