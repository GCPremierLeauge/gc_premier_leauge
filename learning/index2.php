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
        /* data types */ 

        $phrase = "Ch Kushidhar Reddy";
        $age = 30;
        $cgpa = 7.75;
        $isInnocent = true;
            // null //;

        /* working with strings */
        echo (strtolower($phrase));
        echo strlen($phrase);
        $phrase[0] = 'B';
        echo $phrase[0];
        echo "<br>";
        echo str_replace("Kushidhar","YD",$phrase);
        echo "<br>";
        // echo $phrase;
        echo substr($phrase,8,4);

        // working with numbers
        $num = 10;
        $num++;
        $num--;
        $num += 23;
        echo "<br>--------<br>";
        // echo sqrt(101);abs,max,min,
        // echo round(3.2);
        // echo ceil(4.3);
        // echo $num;

        /* Taking inputs */
      
    ?>
    <hr>
    <form action="index.php" method="post">
        Name: <input type="text" name="username">
        Age: <input type="text" name="age">

        <input type="submit">
    </form>
    Your name is :<?php
        echo $_POST["age"];
    ?>
    <hr>
    <?php
        $friends = array("Kevin",1,false,3.3,"Karen","Oscar","Jim");
        $friends[1] = true;
        echo $friends[1];

        $length=count($friends);
        $friends[$length] = "Hii there";
        echo $friends[count($friends)-1];
    ?>

    

</body>
</html>