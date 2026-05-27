<?php
function consoleLog($message){
        echo "<script>console.log('" . $message . "');</script>";
    }

function evenNumbers($x){
    $even = 0;
    $uneven = 0;
    for($i = 0; $i < count($x); $i++){
        if($x[$i]%2 == 0) $even++;
        else $uneven++;
    }
    echo "Even numbers: ".$even." Uneven numbers: ".$uneven;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My skill tree</title>
</head>
<body>
    
<?php
    echo "Hi, I like my project for practica";
    consoleLog("My my");
?>

<form method="get">
    <input type="number" name="n1" placeholder="Enter a number">
    <input type="number" name="n2" placeholder="Enter a number">
    <input type="number" name="n3" placeholder="Enter a number">
    <input type="number" name="n4" placeholder="Enter a number">
    <input type="number" name="n5" placeholder="Enter a number">
    <input type="number" name="n6" placeholder="Enter a number">
    <input type="number" name="n7" placeholder="Enter a number">
    <input type="number" name="n8" placeholder="Enter a number">
    <input type="number" name="n9" placeholder="Enter a number">
    <input type="number" name="n10" placeholder="Enter a number">
    <input type="submit" value="Submit">
</form>

<?php
    if(!empty($_GET)){
        $numbers = [];
        for($i = 1; $i <= 10; $i++){
            $key = "n".$i;
            if(!isset($_GET[$key]) || $_GET[$key]===""){
                echo "Error: You need to fill all the spaces!";
                die();
            }
                $numbers[] = (int)$_GET[$key];
        }
        evenNumbers($numbers);
    }
?>

</body>
</html>