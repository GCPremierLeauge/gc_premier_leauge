<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Match Input</title>
</head>
<!-- <body> -->
<style>
body {
  background-color: #E6E6FA;
}
</style>

	<!-- ************STARTING OF THE WEBSITE FOR ADMIN PANEL **************** -->
	<div style="width:800px; margin:100px auto; border: 1px solid black; background-color: #f0f0f0;">


	<form action="playing11.php" method="POST">

		<!-- match no : input  -->
        <label for="MatchNo"> &nbsp; <b>Match No:</b></label>
        <input type="number" name="MatchNo" id="MatchNo" required style="width: 40px;">
		<br><br>

		<!-- team 1 inputs -->
		<label for="teamAname">&nbsp; <b>Team A name:</b></label>
		<select name="teamAname" id="teamAname">
			<option value="3">Mighty Eagles</option>
			<option value="4">Power Strikers</option>
			<option value="1">Black Panthers</option>
			<option value="2">Lion Kings</option>
		</select><br><br>

		<!-- team 2 inputs -->
		<label for="teamBname">&nbsp; <b>Team B name:</b></label>
		<select name="teamBname" id="teamBname">
			<option value="4">Power Strikers</option>
			<option value="3">Mighty Eagles</option>
			<option value="1">Black Panthers</option>
			<option value="2">Lion Kings</option>
		</select><br><br>

		<!-- TOSS WON BY: -->
		
		<label for="tossWonBy"> &nbsp; <b>Toss Won by</b></label>
		<select name="tossWonBy" id="tossWonBy">
			<option value="4">Power Strikers</option>
			<option value="3">Mighty Eagles</option>
			<option value="1">Black Panthers</option>
			<option value="2">Lion Kings</option>
		</select><br><br>

		<!--  Choose To : input  -->
        <label for="chooseTo">&nbsp; <b>Choose to:</b></label>
		<select name="chooseTo" id="chooseTo">
			<option value="bat">Bat</option>
      		<option value="bowl">Bowl</option>
     	</select><br><br>
			<!--  number of overs : input  -->
			<label for="overs">&nbsp; <b>Overs :</b></label>
			<input type="number" name="overs" id="overs" required style="width: 40px;"><br><br>

		<!-- on Submit -->
		&nbsp;&nbsp;<input type="submit">
		
	</form>


	<hr>
	<a href="seeScores.php" target=”_blank”>SeeScores</a>


	</div>
</body>
</html>