<?php

# Web accessible at: http://git.juanleonardosanchez.com/code-samples/algorithms/Herons_SquareRoot_Finder.php?num=365656435&guess=3

# Get a user number, or default to 25
$num = $_GET['num'] ? $_GET['num'] : 25;
$sqrt = $_GET['guess'] ? $_GET['guess'] : $num / 3;

# General inits, not required, but legibility
$sqrt;
$sqr; # $sqrt * $sqrt;
$num_over_sqrt;
$loop_control; # .5 * ($sqrt + num/$sqrt)

# General inits for table out
$col1[] = "Square Root / Guess";
$col2[] = "Square";
$col3[] = "Approximation";
$col4[] = "New Square Root / Machine Guess";

while($sqrt * $sqrt != $num){
    $sqr = $sqrt * $sqrt;
    $num_over_sqrt = $num / $sqrt;
    $newsqrt = (.5 * ($sqrt + ($num / $sqrt)));

    $col1[] = $sqrt;
    $col2[] = $sqr;
    $col3[] = $num_over_sqrt;
    $col4[] = $newsqrt;

    $sqrt = $newsqrt;
}

$count = count($col4);


echo "<table>";
for($i = 0; $i <= $count; $i++){
    echo "<tr><td>" . $col1[$i] . "</td>";
    echo "<td>" . $col2[$i] . "</td>";
    echo "<td>" . $col3[$i] . "</td>";
    echo "<td>" . $col4[$i] . "</td></tr>";
}
echo "</table>";

echo "The square root of $num is $sqrt";