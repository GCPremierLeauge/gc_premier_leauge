<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inning = $_POST['inning'];
    // Update the database with the selected inning
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $PinningsNo = $_POST['inningsNo'];
    $PmatchNo = $_POST['matchNo'];
    $PbatFirstTeam = $_POST['batFirstTeam'];
    $PbatSecondTeam = $_POST['batSecondTeam'];
    $PbatsManID = $_POST['batsManID'];
    $opponent;
    if($PinningsNo == 1){
        $opponent = $PbatSecondTeam;
    }else{
        $opponent = $PbatFirstTeam;
    }

    $sql = "INSERT INTO BATSMANDETAILS VALUES ('$PmatchNo','$PinningsNo','$PbatsManID','NOTOUT','','',0,0,0,0,0,0,0,0,0,0,0.0,'$opponent',0)";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
}


?>

<form id ="formChange12" action="playing11.php" method="post">
    <input type="submit" value="goBack">
</form>

<script type="text/javascript">
    document.getElementById('formChange12').submit(); // SUBMIT FORM
</script>