<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch</title>
</head>
<body>
    
<?php
        $conn = mysqli_connect('localhost','root','','test1');
        if(!$conn){
            echo "Connection error" . mysqli_connect_error();
        }

        // WRITE A QUERY
        $sql = 'SELECT name,email,phone  FROM USERS';

        // MAKE A QUERY & GET RESULT
        $result = mysqli_query($conn,$sql);

        // fetch the resulting rows as an array
        $details = mysqli_fetch_all($result,MYSQLI_ASSOC);

        mysqli_free_result($result);

        //close the connection to the database
        mysqli_close($conn);

        // print_r($details);
?>

        
        <?php foreach($details as $detail){?>
            <?php echo "<p>". $detail["name"] ."</p>" ?>
            <?php echo "<p>". $detail["email"] ."</p>" ?>
            <?php echo "<p>". $detail["phone"] ."</p>" ?>
            <hr>
      <?php }?>

</body>
</html>