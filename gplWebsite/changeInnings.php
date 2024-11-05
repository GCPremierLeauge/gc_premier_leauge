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
    $sql = "UPDATE matchdetails SET inningsNO = 2 WHERE isCompleted = 'NOT'";
    if (mysqli_query($conn, $sql)) {
        echo "Innings updated successfully";
    } else {
        echo "Error updating innings: " . mysqli_error($conn);
    }

    $sql = "SELECT ballID,matchNo FROM ballByBallDetails ORDER BY ballID DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
            $FballId = $row['ballID'];
            $FmatchNo = $row['matchNo'];
    }
    $FballId++;
    $SQL = "INSERT INTO ballByBallDetails VALUES (0,$FballId,'','','',0,0,0,0,'','',0,0,0,0,$FmatchNo,2)";
    $query = mysqli_query($conn,$SQL);

    mysqli_close($conn);
}


?>

<form id ="formChange" action="playing11.php" method="post">
    <input type="submit" value="goBack">
</form>

<script type="text/javascript">
    document.getElementById('formChange').submit(); // SUBMIT FORM
</script>