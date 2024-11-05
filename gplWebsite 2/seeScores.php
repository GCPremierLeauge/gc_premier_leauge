<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
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
    $sql = "SELECT matchNo, TeamAID, TeamBID, Toss, Chose, Overs, isCompleted, inningsNO FROM MATCHDETAILS";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $matchNo = $row['matchNo'];
        $teamAID = $row['TeamAID'];
        $teamBID = $row['TeamBID'];
        $toss = $row['Toss'];
        $chose = $row['Chose'];
        $overs = $row['Overs'];
        $isCompleted = $row['isCompleted'];
        $inningsNO = $row['inningsNO'];
        $bgColor = "#" . substr(md5(rand()), 0, 6);
    ?>
  <div class="match-details" onclick="submitForm('<?php echo $matchNo ?>')" style='border: 1px solid black; padding: 10px; margin-bottom: 10px; width:400px;background-color:<?php echo $bgColor;?>'>
    <u><h3>Match No: <?php echo $matchNo ?></h3></u>
    <p><?php echo $teams[$teamAID] ." v/s " .$teams[$teamBID] ?></p>
    <?php echo $teams[$toss] ."won the toss and choose to " .$chose ?>
    <p>Is Completed: <?php echo $isCompleted ?></p>
    

    <form id="form-<?php echo $matchNo ?>" method="post" action="scoreCard.php">
      <input type="hidden" name="matchNo" value="<?php echo $matchNo ?>">
      <input type="hidden" name="teamAID" value="<?php echo $teamAID ?>">
      <input type="hidden" name="teamBID" value="<?php echo $teamBID ?>">
      <input type="hidden" name="toss" value="<?php echo $toss ?>">
      <input type="hidden" name="chose" value="<?php echo $chose ?>">
      <input type="hidden" name="overs" value="<?php echo $overs ?>">
      <input type="hidden" name="isCompleted" value="<?php echo $isCompleted ?>">
      <input type="hidden" name="inningsNO" value="<?php echo $inningsNO ?>">
      <input type="hidden" name="teamAID" value="<?php echo $teamAID ?>">
      <input type="hidden" name="teamBID" value="<?php echo $teamBID ?>">
      <input type="hidden" name="overs" value="<?php echo $overs ?>">
      <input type="hidden" name="isCompleted" value="<?php echo $isCompleted ?>">
      <input type="submit" value="see scorecard">
    </form>
  </div>
<?php
}
?>

<script>
  function submitForm(matchNo) {
    document.getElementById('form-' + matchNo).submit();
  }
</script>


        
</body>
</html>