<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// $conn = mysqli_connect('localhost','root','','test1') or die('Connection Failed!' .mysqli_connect_error());


// check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// get the team ID entered by the user
// $team_id = $_POST['team_id'];
$team_id;
$name_s;
$selected_id;
// query the database to get the team members for the specified team ID
$sql = "SELECT playername, playerid FROM playerdetails WHERE teamid = '$team_id'";
$result = mysqli_query($conn, $sql);

// create the dropdown menu
echo "<select name='$name_s' id='$name_s'>";
while ($row = mysqli_fetch_assoc($result)) {

    $selected = ($row['playerid'] == $selected_id) ? 'selected' : '';
    echo "<option value='" . $row['playerid'] . "' $selected>" . $row['playername'] . "</option>";
    
  // echo "<option value='" . $row['playerid'] . "' ></option>" . $row['playername'] . "</option>";
}
echo "</select>";

// close the database connection
mysqli_close($conn);

?>
