<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include "header.html" ?>
    <?php 
        $title = "My First Post";
        $author = "Mike";
        $wordCount = 400;
        include "article-header.php"?>
    <br>
    <!-- check boxes -->
    <!-- <form action="index.php" method="post">
        Apples: <input type="checkbox" name="fruits[]" value="apples"><br>
        Oranges: <input type="checkbox" name="fruits[]" value="oranges"><br>
        Pear: <input type="checkbox" name="fruits[]" value="pear"><br>
        <input type="submit">
    </form> -->
    <!-- <?php
        $fruits = $_POST["fruits"];
        echo $fruits[0];
    ?> -->
    <!-- key value pairs -->
    <!-- <form action="index.php" method="post">
        <input type="text" name="student">
        <input type="submit">
    </form> -->
    <!-- <?php
        $grades = array("Jim"=>"A+","Pam"=>"B-","Oscar"=>"C+");
        echo $grades[$_POST["student"]];
    ?> -->
    <!-- functions -->
    <!-- <?php
        function sayHi($name){
            echo "Hello $name";
        }
        function cube($num){
            return $num*$num*$num;
        }
        sayHi("Kushidhar");
        $cubeResult = cube(41);
        echo $cubeResult;
    ?> -->

    <!-- if else statements -->
    <!-- <?php
        $isMale = true;
        $isTall = true;
        if($isMale && $isTall){
            echo("You are Kushidhar");
        }else{
            echo("You are Murali!");
        }
    ?> -->
    <!-- while loop -->
    <?php
    $index = 1;
    while($index<=5){
        echo "$index <br>";
        $index++;
    }
    ?> 

    <?php
        for($i = 1;$i<=5;$i++){
            echo "Hii there $i<br>";
        }
    ?>
    <?php include "footer.html" ?>

</body>
</html>