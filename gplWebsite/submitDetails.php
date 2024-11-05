<?php include "playersDetails.php"?>
<?php 
            $striker = $_POST['striker'];
            $non_striker = $_POST['nonstriker'];
            $bowler = $_POST['bowler'];
            $isWide = isset($_POST['wide']) ? 1 : 0;
            $isNoBall = isset($_POST['noball']) ? 1 : 0;
            $isByes = isset($_POST['byes']) ? 1 : 0;
            $runs = $_POST['number'];
            $outType = isset($_POST['outype']) ? $_POST['outype'] : "NOTOUT";
            $isAssist = isset($_POST['assist']) ? $_POST['assist'] : 0;
            $assistBy = $_POST['assistBy'];
            $isNonStrikerOut = isset($_POST['isNonStrikerOut']) ? 1 : 0;
            $inningsNumber = $_POST['inningsNo'];
            $matchNumber = $_POST['matchNo'];

            echo "ISNOBALL " .$isNoBall;
            include "ballByBallUpdate.php";
?>

<form id="myForm"  action="playing11.php" method="post">
    <input type="submit" value="goBack">
</form>

<script type="text/javascript">
    document.getElementById('myForm').submit(); // SUBMIT FORM
</script>